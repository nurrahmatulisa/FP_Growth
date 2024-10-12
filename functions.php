<?php

/**
 * fungsi-fungsi umum dan pengaturan yang ada di aplikasi selain perhitungan
 */

//menyembunyikan error kecuali E_NOTICE
error_reporting(~E_NOTICE);
//memulai session untuk login
session_start();

//setting maksimal waktu eksekusi (5 menit)
ini_set('max_execution_time', 60 * 5);
//setting maksimal memory yang digunakan (512 MB)
ini_set('memory_limit', '3036M');

//include file 'config.php'
include dirname(__FILE__) . '/config.php';
//include file 'includes/db.php'
include dirname(__FILE__) . '/includes/db.php';
//membuat koneksi ke database
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
//memanggil class paging
include dirname(__FILE__) . '/includes/paging.php';


function _post($key, $val = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];
    else
        return $val;
}

function _get($key, $val = null)
{
    global $_GET;
    if (isset($_GET[$key]))
        return $_GET[$key];
    else
        return $val;
}

function _session($key, $val = null)
{
    global $_SESSION;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return $val;
}

$mod = _get('m');
$act = _get('act');


/**
 * konversi data tabel menjadi array
 * @param array $data data tabel
 * @return array $data array
 */
function convert($data)
{
    $arr = array();
    foreach ($data as $row) {
        $v = trim(strtolower($row->item));
        $arr[$row->id_transaksi][$v] = $v;
    }
    return $arr;
}
/**
 * membuat kode otomatis
 * @param string $field nama field di tabel
 * @param string $table nama tabel di database
 * @param string $prefix awalan kode
 * @param string $length panjang kode selain awalan
 * @return string kode otomatis
 */
function kode_oto($field, $table, $prefix, $length)
{
    global $db;
    $var = $db->get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if ($var) {
        return $prefix . substr(str_repeat('0', $length) . (substr($var, -$length) + 1), -$length);
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}
/**
 * mengambil inputan post atau get
 * jika kosong akan mengambalikan nilai default
 * @param string $key nama field atau variabel
 * @param string $default nilai default
 * @return string nilai dari variabel
 */
function set_value($key = null, $default = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];

    if (isset($_GET[$key]))
        return $_GET[$key];

    return $default;
}
/**
 * menambahkan slash (/) jika ada tanda petik satu pada variabel
 * untuk mencegah error pada query
 * @param string $str isi variabel awal
 * @return string isi variabel yang sudah diisi slash
 */
function esc_field($str)
{
    if ($str)
        return addslashes($str);
}
/**
 * mengambil data dari tb_option berdasarkan option_name
 * @param string $option_name nama option
 * @return string isi data
 */
function get_option($option_name)
{
    global $db;
    return $db->get_var("SELECT option_value FROM tb_options WHERE option_name='$option_name'");
}
/**
 * mengubah data pata tb_option
 * @param string $option_name nama option
 * @param string $option_value isi baru dari option 
 */
function update_option($option_name, $option_value)
{
    global $db;
    return $db->query("REPLACE INTO tb_options (option_name, option_value) 
        VALUES ('$option_name', '$option_value')");
}
/**
 * berpindah ke halaman lain menggunakan java script
 */
function redirect_js($url)
{
    echo '<script type="text/javascript">window.location.replace("' . $url . '");</script>';
}
/**
 * menampilkan pesan dengan java script
 */
function alert($url)
{
    echo '<script type="text/javascript">alert("' . $url . '");</script>';
}
/**
 * menampilkan pesan dengan script php dan html
 */
function print_msg($msg, $type = 'danger')
{
    echo ('<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $msg . '</div>');
}
/**
 * mengubah tanggal dalam format sql menjadi format bahasa indonesia
 * @param string $data tanggal dalam format sql
 * @param string tanggal dalam format indonesia
 */
function tgl_indo($date)
{
    $tanggal = explode('-', $date);

    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $bulan = $array_bulan[$tanggal[1] * 1];

    return $tanggal[2] . ' ' . $bulan . ' ' . $tanggal[0];
}
