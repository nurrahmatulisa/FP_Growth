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
   <section class="content-header">
    <h1>Ubah Password</h1>
</section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
<section class="content">
    <div class="row">
        <div class="col-sm-5">
            <?php if ($_POST) include 'aksi.php' ?>
            <form method="post">
                <div class="form-group">
                    <label>Password Lama <span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="pass1" />
                </div>
                <div class="form-group">
                    <label>Password Baru <span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="pass2" />
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="pass3" />
                </div>
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
            </form>
        </div>
    </div>
</section>