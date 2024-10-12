<?php
require_once 'functions.php';
/** login */
if ($mod == 'login') {
    $user = esc_field($_POST['user']);
    $pass = esc_field($_POST['pass']);

    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");
    if ($row) {
        $_SESSION['login'] = $row->user;
        redirect_js("index.php");
    } else {
        print_msg("Salah kombinasi username dan password.");
    }
} else if ($mod == 'password') {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];

    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login]' AND pass='$pass1'");

    if ($pass1 == '' || $pass2 == '' || $pass3 == '')
        print_msg('Field bertanda * harus diisi.');
    elseif (!$row)
        print_msg('Password lama salah.');
    elseif ($pass2 != $pass3)
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else {
        $db->query("UPDATE tb_admin SET pass='$pass2' WHERE user='$_SESSION[login]'");
        print_msg('Password berhasil diubah.', 'success');
    }
} elseif ($act == 'logout') {
    unset($_SESSION['login']);
    header("location:index.php?m=login");
}
/** data */
elseif ($mod == 'data_tambah') {
    $id_transaksi = $_POST['id_transaksi'];
    $item = $_POST['item'];
    $tanggal = $_POST['tanggal'];

    if ($tanggal == '' || $item == '' || $id_transaksi == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        foreach (explode(',', $item) as $item) {
            $item = trim($item);
            if ($item) {
                $db->query("INSERT INTO tb_data (id_transaksi, item, tanggal) VALUES ('$id_transaksi', '$item', '$tanggal')");
            }
        }
        redirect_js("index.php?m=data");
    }
} else if ($mod == 'data_ubah') {
    $id_transaksi = $_POST['id_transaksi'];
    $item = $_POST['item'];
    $tanggal = $_POST['tanggal'];

    if ($tanggal == '' || $item == '' || $id_transaksi == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE tb_data SET id_transaksi='$id_transaksi', item='$item', tanggal='$tanggal' WHERE id_data='$_GET[ID]'");
        redirect_js("index.php?m=data");
    }
} else if ($act == 'data_hapus') {
    $db->query("DELETE FROM tb_data WHERE id_data='$_GET[ID]'");
    header("location:index.php?m=data");
}
