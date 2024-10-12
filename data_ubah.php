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
            <h1>Ubah Data</h1>
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
$row = $db->get_row("SELECT * FROM tb_data WHERE id_data='$_GET[ID]'");
?>
<section class="content-header">
    <h1>Ubah Data</h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <form method="post">
                <div class="form-group">
                    <label>Id Transaksi <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="id_transaksi" value="<?= set_value('id_transaksi', $row->id_transaksi) ?>" />
                </div>
                <div class="form-group">
                    <label>Item <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="item" value="<?= set_value('item', $row->item) ?>" />
                    <p class="help-block">Pisahkan setiap item dengan koma</p>
                </div>
                <div class="form-group">
                    <label>Tanggal <span class="text-danger">*</span></label>
                    <input class="form-control" type="date" name="tanggal" value="<?= set_value('tanggal', $row->tanggal) ?>" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                    <a class="btn btn-danger" href="?m=data"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</section>