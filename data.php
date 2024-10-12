<head>
  <?php include 'header.php' ?>
</head>
<!-- <body class="hold-transition sidebar-mini">
<div class="wrapper">  -->
<?php include 'sidebar.php'; ?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <?php include 'navbar.php' ?>
    <!-- Right navbar links -->
  </nav>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-weight: bold;">Data Transaksi</h1>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="data" />
            <div class="form-group mr-1">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= _get('q') ?>" />
            </div>
            <div class="form-group mr-1">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            </div>
            <div class="form-group mr-1">
                <a class="btn btn-primary" href="?m=data_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
            <div class="form-group mr-1">
                <a class="btn btn-warning" href="?m=data_import"><span class="glyphicon glyphicon-import"></span> Import</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Transaksi</th>
                    <th>Data</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $q = esc_field(_get('q'));
            $pg = new Paging();
            $limit = 20;
            $offset = $pg->get_offset($limit, _get('page'));

            $where = " WHERE item LIKE '%$q%'";

            $rows = $db->get_results("SELECT * FROM tb_data $where ORDER BY id_transaksi LIMIT $offset, $limit");

            $jumrec = $db->get_var("SELECT COUNT(*) FROM tb_data $where");

            $no = $offset;
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $row->id_transaksi ?></td>
                    <td><?= $row->item ?></td>
                    <td><?= $row->tanggal ?></td>
                    <td class="nw">
                        <a class="btn btn-xs btn-warning" href="?m=data_ubah&ID=<?= $row->id_data ?>"><span class="glyphicon glyphicon-edit"></span></a>
                        <a class="btn btn-xs btn-danger" href="aksi.php?act=data_hapus&ID=<?= $row->id_data ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="panel-footer">
        <ul class="pagination"><?= $pg->show("m=data&q=$q&page=", $jumrec, $limit, _get('page')) ?></ul>
    </div>
    </div>
  
</div>
</div>