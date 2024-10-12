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
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
<div class="page-header">
    <h1>Hasil FP-Growth</h1>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Konfigurasi</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <td>Jumlah Data</td>
                <td><?= get_option('fpg_data') ?></td>
            </tr>
            <tr>
                <td>Waktu Eksekusi</td>
                <td><?= get_option('fpg_time') ?> detik</td>
            </tr>
            <tr>
                <td>Memory Digunakan</td>
                <td><?= get_option('fpg_memory') ?> kilo byte</td>
            </tr>
            <tr>
                <td>Min. Support</td>
                <td><?= get_option('fpg_supp') ?> %</td>
            </tr>
            <tr>
                <td>Min. Confidence</td>
                <td><?= get_option('fpg_conf') ?> %</td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil Asosiasi</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover table-striped dtb1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Rule</th>
                    <th>Support</th>
                    <th>Confident</th>
                    <th>Lift Ratio</th>
                </tr>
            </thead>
            <?php
            $rows = $db->get_results("SELECT * FROM tb_hasil");
            $no = 0;
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $row->left_item ?> => <?= $row->right_item ?></td>
                    <td><?= round($row->supp * 100, 2) ?>%</td>
                    <td><?= round($row->conf * 100, 2) ?>%</td>
                    <td><?= round($row->lift, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>