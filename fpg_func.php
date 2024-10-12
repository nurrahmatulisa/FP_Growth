<?php

/**
 * Class fpgrowth
 * melakukan perhitungan fpgrowth
 */
class fpgrowth
{
    //data transaksi
    public $data;
    //total data transaksi
    protected $total_data;
    //item/category yang ada dalam data transaksi
    public $categories;
    //minimal jumlah data (berdasarkan min_support)
    protected $min_count;
    //minimal confident dalam persen
    protected $min_confidence;
    //frequest itemset dari data transaksi
    public $frequent_itemset;
    //support dari kumpulan data
    public $support;
    //itemset yang sudah terurut dari support terbesar
    public $ordered_itemset;
    //fp tree
    public $fp_tree;
    //item data beserta total transaksi
    public $item;
    //conditional patern base
    public $cpb;
    //conditional fp tree
    public $cfpt;
    //aturan asosiasi    
    public $ass;

    /**
     * konstruktor dari class fpgrowth
     * @param array $data Data transaksi yang diinputkan
     * @param int $min_support Nilai minimal support dalam persen
     * @param int $min_confidence Nilai minimal confidence dalam persen
     */

    function __construct($data, $min_support, $min_confidence)
    {
        $this->data = $data;
        $this->total_data = count($data);
        //menghitung jumlah item berdasarkan support yang diinputkan
        $this->min_count = $min_support / 100 * count($data);
        $this->min_confidence = $min_confidence;

        //memanggil fungsi2
        $this->frequent_itemset();
        $this->ordered_itemset();
        $this->fp_tree();
        $this->item();
        $this->cpb();
        $this->cfpt();
        $this->fpg();
        $this->association();
    }
    /**
     * mencari aturan asosiasi berdasarkan hasil fpg
     */
    function association()
    {
        $no = 0;
        $arr2 = array();
        foreach ($this->fpg as $k => $v) {
            foreach ($v as $item_key => $item_val) {
                $items = $item_val['items'];
                $arr = array();
                for ($a = 0; $a < count($items) - 1; $a++) {
                    $arr = array_merge(getCombinations($items, $a + 1), $arr);
                }
                foreach ($arr as $key => $val) {
                    $keys = array(
                        'left' => array(),
                        'right' => array(),
                    );
                    foreach ($items as $k => $v) {
                        if (in_array($v, $val))
                            $keys['left'][] = $v;
                        else
                            $keys['right'][] = $v;
                    }
                    $arr2[$no] = $keys;
                    $arr2[$no]['b'] = $this->get_match($arr2[$no]['left']);
                    $arr2[$no]['a'] = $item_val['count'];
                    $arr2[$no]['total'] = $this->total_data;
                    $arr2[$no]['sup'] = $arr2[$no]['a'] / $arr2[$no]['total'];
                    $arr2[$no]['conf'] = $arr2[$no]['a'] / $arr2[$no]['b'];
                    $s_head = $this->get_match($arr2[$no]['right']) / $this->total_data;
                    $arr2[$no]['lr'] = $arr2[$no]['conf'] / $s_head;
                    $no++;
                }
            }
        }
        $this->ass = $arr2;
    }
    /**
     * mencari berapa data transaksi yang terdapat item tertentu
     * @param array $needed kombinasi item
     * @return int jumlah transaksi
     */
    function get_match($needed)
    {
        $matches = 0;
        foreach ($this->data as $k => $v) {
            $arr = array();
            foreach ($v as $a => $b) {
                if (in_array($b, $needed)) {
                    $arr[] = $b;
                }
            }
            if (count($arr) == count($needed)) {
                $matches++;
            }
        }
        return $matches;
    }
    /**
     * mencari fp growth berdasarkan conditional fp tree
     */
    function fpg()
    {
        $arr = array();
        foreach ($this->cfpt as $key => $val) {
            foreach ($val as $k => $v) {
                $items = $v['items'];
                $items[] = $key;
                $count = count($items);
                $arr[$key][] = array(
                    'items' => $items,
                    'count' => $v['count'],
                );
            }
        }
        $this->fpg = $arr;
    }
    /**
     * conditional fp tree semua data berdasarkan conditional patern base
     */
    public function cfpt()
    {
        foreach ($this->item as $key => $val) {
            if (isset($this->cpb[$key])) {
                $this->cfpt[$key] = $this->_cfpt($this->cpb[$key]);
            }
        }
    }
    /**
     * cfpt data tertentu
     */
    private function _cfpt($data)
    {
        $arr = array();
        $key = array();

        $max = 0;
        foreach ($data as $val) {
            if (count($val['items']) > $max)
                $max = count($val['items']);

            $arr[] = $val['items'];
            foreach ($val['items'] as $k => $v) {
                $key[$v] = 1;
            }
        }
        $key = array_keys($key);
        $itemset = $max;
        $arr3 = array();
        while ($itemset >= 1) {
            $com = array();
            $com = getCombinations($key, $itemset);

            foreach ($com as $k => $v) {
                $result = $this->get_result($v, $data);
                if ($result['count'] >= $this->min_count)
                    $arr3[] = $result;
            }
            $itemset--;
        }
        return $arr3;
    }
    /**
     * hasil cfpt berdasarkan kombinasi itemset
     * @param array $com kombinasi itemset
     * @param array $data data transaksi
     * @return array hasil cfpt kombinasi
     */
    function get_result($com, $data)
    {
        $total = 0;
        foreach ($data as $key => $val) {
            if ($this->match($com, $val['items']))
                $total += $val['count'];
        }
        return array(
            'items' => $com,
            'count' => $total,
        );
    }
    /**
     * menentukan apakah satu array1 ada di array2
     * @param array $needed array pertama
     * @param array $data array kedua
     * @return bool match atau tidak
     */
    function match($needed, $data)
    {
        foreach ($needed as $key => $val) {
            if (!in_array($val, $data))
                return false;
        }
        return true;
    }
    /**
     * hasil cfpt berdasarkan kombinasi itemset
     * @param array $com kombinasi itemset
     * @param array $data data transaksi
     * @return array hasil cfpt kombinasi
     */
    /**
     * menghitung conditional patern base
     */
    function cpb()
    {
        $this->_cpb(array(),  'Root', $this->fp_tree['Root']);

        //echo '<pre>' . print_r($this->cpb, 1) . '</pre>';

        $arr = array();
        foreach ($this->cpb as $key => $val) {
            if (count($val['items']) > 1) {
                $key = $val['items'][count($val['items']) - 1];
                array_pop($val['items']);
                $arr[$key][] = $val;
            }
        }
        $this->cpb = $arr;
    }
    /**
     * conditional patern base untuk node tertentu
     * @param array $items kombinasi itemset
     * @param string $value node yang ingin dicari
     * @param array $tree pohon fp-tree
     * @return array hasil cpb
     */
    function _cpb($items, $value, $tree)
    {
        if ($tree['value'] != 'Root') {
            $items[] = $tree['value'];
            $this->cpb[] = array(
                'value' => $tree['value'],
                'items' => $items,
                'count' => $tree['count'],
            );
        }

        foreach ($tree['next'] as $key => $val) {
            $this->_cpb($items, $key, $val);
        }
    }
    /**
     * membalik urutan dalam array frequent itemset
     */
    function item()
    {
        $this->item = array_reverse($this->frequent_itemset, true);
    }
    /**
     * membangun fp tree
     */
    function fp_tree()
    {
        $this->fp_tree = array(
            'Root' => array(
                'value' => 'Root',
                'count' => 0,
                'next' => array(),
            ),
        );
        $this->build_tree($this->fp_tree['Root']['next'], $this->ordered_itemset);
    }
    /**
     * fungsi recursive untuk membangun fp tree dari setiap cabang
     * @param array $parent_node node induk
     * @param array $ordered_itemset data ordered itemset
     * @return array @node cabang dari tree
     */
    function build_tree(&$parent_node, $ordered_itemset = array())
    {
        $ordered_itemset = array_values($ordered_itemset);

        if (!$ordered_itemset)
            return;

        $ordered_itemset[0] = array_values($ordered_itemset[0]);

        $itemset = current($ordered_itemset);
        $item = current($itemset);

        unset($ordered_itemset[0][0]);

        if (!$itemset) {
            unset($ordered_itemset[0]);
            $this->build_tree($this->fp_tree['Root']['next'], $ordered_itemset);
        } else if (in_array($item, array_keys($parent_node))) {
            $parent_node[$item]['count']++;
            $this->build_tree($parent_node[$item]['next'], $ordered_itemset);
        } else {
            $parent_node[$item]['value'] = $item;
            $parent_node[$item]['count'] = 1;
            $parent_node[$item]['next'] = array();
            $this->build_tree($parent_node[$item]['next'], $ordered_itemset);
        }
    }
    /**
     * menampilkan fp tree dalam bentuk pohon
     */
    public function display()
    {
        echo "<ul class='fp_tree'><li><b class='btn btn-xs btn-danger'>Root</b>";
        $this->_display($this->fp_tree['Root']);
        echo "</li></ul>";
    }
    /**
     * fungsi redursive menampilkan cabang-cabang dari pohon
     */
    public function _display($tree)
    {
        echo "<ul>";
        foreach ($tree['next'] as $key => $val) {
            echo "<li> <b class='btn btn-xs btn-primary'>$key: $val[count]</b>";
            $this->_display($val);
            echo '</li>';
        }
        echo "</ul>";
    }
    /**
     * menghitung ordered itemset (item dari support terbesar)
     */
    function ordered_itemset()
    {

        foreach ($this->data as $data) {
            $arr = array();
            foreach ($this->frequent_itemset as $category => $count) {
                if (in_array($category, $data))
                    $arr[] = $category;
            }
            if ($arr)
                $this->ordered_itemset[] = $arr;
        }
        //print_r($this->frequent_itemset);
    }
    /**
     * menampilkan quantity setiap item berapa kali muncul di transaksi
     */
    function frequent_itemset()
    {
        foreach ($this->data as $key => $val) {
            foreach (array_unique($val) as $k => $v) {
                if (!isset($this->frequent_itemset[$v]))
                    $this->frequent_itemset[$v] = 1;
                else
                    $this->frequent_itemset[$v]++;
            }
        }
        //print_r($this->frequent_itemset);

        foreach ($this->frequent_itemset as $key => $val) {
            $this->categories[] = $key;
            if ($val < $this->min_count) {
                unset($this->frequent_itemset[$key]);
            } else {
                $this->support[$key] = $val / $this->total_data * 100;
            }
        }
        arsort($this->frequent_itemset);
    }
}
/**
 * fungsi recursive kombinasi
 * @param array $base data item yang akan dibuat kombinasi
 * @param int $n kombinasi berapa item
 * @return array hasil kombinasi
 */
function getCombinations($base, $n)
{
    $baselen = count($base);
    if ($baselen == 0) {
        return;
    }
    if ($n == 1) {
        $return = array();
        foreach ($base as $b) {
            $return[] = array($b);
        }
        return $return;
    } else {
        $oneLevelLower = getCombinations($base, $n - 1);
        $newCombs = array();
        foreach ((array) $oneLevelLower as $oll) {
            $lastEl = $oll[$n - 2];
            $found = false;
            foreach ($base as  $key => $b) {
                if ($b == $lastEl) {
                    $found = true;
                    continue;
                }
                if ($found == true) {
                    if ($key < $baselen) {
                        $tmp = $oll;
                        $newCombination = array_slice($tmp, 0);
                        $newCombination[] = $b;
                        $newCombs[] = array_slice($newCombination, 0);
                    }
                }
            }
        }
    }
    return $newCombs;
}
