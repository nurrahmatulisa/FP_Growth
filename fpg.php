<head>
  <?php include 'header.php' ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <?php include 'navbar.php' ?>
    <!-- Right navbar links -->
  </nav>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php include 'sidebar.php' ?>
  </aside>

   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perhitungan FPG</h1>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
<?php

/**
 * File ini adalah form yang ditampilkan
 * untuk diisi sebelum melakukan proses perhitungan
 * @param tanggal_awal : tanggal paling kecil dari data yang akan diproses
 * @param tanggal_akhir : tanggal paling besar dari data yang akan diproses
 * @param min_support : prosentase minimal support dari fp growth
 * @param min_support : prosentase minimal confidence dari fp growth
 * Jika sudah mengisi semua dan klik tombol hitung, akan menginclude fpg_func.php dan fpg_hasil.php
 */
//mengambil tanggal awal dari tb_data sebagai tanggal awal default
$tanggal_awal = $db->get_var("SELECT min(tanggal) FROM tb_data");
//mengambil tanggal akhir dari tb_data sebagai tanggal akhir default
$tanggal_akhir = $db->get_var("SELECT max(tanggal) FROM tb_data");

//setting tanggal sesuai inputan, jika tidak diubah akan mengambil tanggal default
$tanggal_awal = set_value('tanggal_awal', $tanggal_awal);
$tanggal_akhir = set_value('tanggal_akhir', $tanggal_akhir);
?>
<div class="row">
    <div class="col-md-6">
        <form method="post">
            <input type="hidden" name="m" value="fpg" />
            <div class="form-group">
                <label>Tanggal awal <span class="text-danger">*</span></label>
                <input class="form-control" name="tanggal_awal" type="date" value="<?= $tanggal_awal ?>">
            </div>
            <div class="form-group">
                <label>Tanggal akhir <span class="text-danger">*</span></label>
                <input class="form-control" name="tanggal_akhir" type="date" value="<?= $tanggal_akhir ?>">
            </div>
            <div class="form-group">
                <label>Minimal support (%) <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="min_support" value="<?= set_value('min_support', 25) ?>" />
            </div>
            <div class="form-group">
                <label>Minimal confidence (%) <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="min_confidence" value="<?= set_value('min_confidence', 75) ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Hitung</button>
            </div>
        </form>
    </div>
</div>
<?php
if ($_POST) {
    //include file fpg_func.php
    include 'fpg_func.php';
    //include file fpg_hasil.php
    include 'fpg_hasil.php';
}
?>