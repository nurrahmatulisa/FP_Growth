

<?php

/**
 * file ini untuk menampilkan hasil fp growth berdasarkan inputan dari user pada halaman sebelumnya.
 */

//menyimpan waktu mulai eksekusi
$time_start = microtime(true);

//mengambil data dari tb_data berdasarkan tanggal inputan
$data =  $db->get_results("SELECT * FROM tb_data WHERE tanggal>='$tanggal_awal' AND tanggal<='$tanggal_akhir'");

//setting minimal support menjadi 25 jika dikosongkan
$min_support = set_value('min_support', 25);
//setting minimal confidence menjadi 25 jika dikosongkan
$min_confidence = set_value('min_confidence', 25);

foreach ($data as $row) {
    $tanggal[$row->id_transaksi] = $row->tanggal;
}

//mengkonversi data dari bentuk tabel ke bawah menjadi array item per transaksi
$data = convert($data);

//memanggil class fpgrowth yang ada di fpg_func.php
$f = new fpgrowth($data, $min_support, $min_confidence);

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Dataset</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Item</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($data as $key => $val) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $key ?></td>
                    <td><?= $tanggal[$key] ?></td>
                    <td><?= implode(', ', $val) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Frequent Itemset</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Itemset</th>
                    <th>Qty</th>
                    <th>Support</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($f->frequent_itemset as $key => $val) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $key ?></td>
                    <td><?= $val ?></td>
                    <td><?= round($f->support[$key], 2) ?>%</td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Ordered Itemset</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Itemset</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($f->ordered_itemset as $key => $val) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= implode(', ', $val) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Fp Tree</h3>
    </div>
    <div class="panel-body">
        <?= $f->display() ?>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Conditional Patern Base</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Conditional Patern Base</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            // echo '<pre>' . print_r($f->item, 1) . '</pre>';
            // echo '<pre>' . print_r($f->cpb, 1) . '</pre>';
            foreach ($f->item as $key => $val) :
                if (isset($f->cpb[$key])) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="nw"><?= $key ?></td>
                        <td>
                            <?php
                            $arr = array();
                            foreach ($f->cpb[$key] as $key => $val) {
                                $arr[] = "{<code>" . implode(',', $val['items']) . ":$val[count]</code>}";
                            }
                            echo implode(', ', $arr); ?>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Conditional Fp Tree</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Conditional Fp Tree</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($f->item as $key => $val) :
                if (isset($f->cfpt[$key])) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="nw"><?= $key ?></td>
                        <td>
                            <?php
                            $arr = array();
                            foreach ($f->cfpt[$key] as $key => $val) {
                                $arr[] = "{<code>" . implode(',', $val['items']) . ":$val[count]</code>}";
                            }
                            echo implode(', ', $arr); ?>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Frequency Patern</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Frequent Patern</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($f->fpg as $key => $val) : ?>
                <?php foreach ($val as $k => $v) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $key ?></td>
                        <td>
                            <?= implode(', ', $v['items']); ?> (<?= $v['count'] ?>)
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Aturan Asosiasi</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Rule</th>
                    <th>Support</th>
                    <th>Confidence</th>
                    <th>Lift Ratio</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            //menghapus hasil tb_hasil
            $db->query("TRUNCATE tb_hasil");
            foreach ($f->ass as $key => $val) :
                if ($val['conf'] >= $min_confidence / 100) :
                    //insert hasil asosiasi ke tb_hasil
                    $db->query("INSERT INTO tb_hasil (left_item, right_item, supp, conf, lift) 
                        VALUES ('" . esc_field(implode(', ', $val['left'])) . "', '" . esc_field(implode(', ', $val['right'])) . "', '$val[sup]', '$val[conf]', '$val[lr]')");
            ?>
                    <tr class="<?= $val['conf'] >= $min_confidence / 100 ? '' : 'danger' ?>">
                        <td><?= $no++ ?></td>
                        <td>Jika <code><?= implode('</code>, <code>', $val['left']) ?></code> maka <code><?= implode('</code>, <code>', $val['right']) ?></code></td>
                        <td><?= $val['a'] ?>/<?= $val['total'] ?> = <?= round($val['sup'] * 100, 2) ?>%</td>
                        <td><?= $val['a'] ?>/<?= $val['b'] ?> = <?= round($val['conf'] * 100, 2) ?>%</td>
                        <td><?= round($val['lr'], 2) ?></td>
                    </tr>
            <?php endif;
            endforeach ?>
        </table>
    </div>
</div>
<?php

//menyimpan waktu selesai
$time_end = microtime(true);
//waktu eksemusi dalam detik
$time = $time_end - $time_start;
//memory yang digunakan dalam kilo byte
$memory = memory_get_usage() / 1024;

//menyimpan hasil ke tb_options
update_option('fpg_supp', $min_support);
update_option('fpg_conf', $min_confidence);
update_option('fpg_time', $time);
update_option('fpg_memory', $memory);
update_option('fpg_data', count($data));

//menampilkan waktu eksekusi dan memory yang digunakan
echo '<pre>';
echo "\nExecution Time: $time seconds";
echo "\nMemory Usage: " . $memory . ' kilo bytes';
echo '</pre>';

?>