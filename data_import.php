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
            <h1>Import Data</h1>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
<div class="row">
    <div class="col-md-6">
        <form method="post" enctype="multipart/form-data">
            <?php
            if ($_POST) {
                $row = 0;
                move_uploaded_file($_FILES['data']['tmp_name'], 'import/' . $_FILES['data']['name']) or die('Upload gagal');

                $arr = array();

                if (($handle = fopen('import/' . $_FILES['data']['name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);

                        if ($row > 0) {
                            for ($c = 1; $c < $num; $c++) {
                                $arr[$row][$c] = $data[$c];
                            }
                        }
                        $row++;
                    }
                    fclose($handle);
                }

                $data = array();
                foreach ($arr as $key => $val) {
                    $date = date_create($val[3], timezone_open("Europe/Oslo"));

                    $items = explode(',', $val[2]);
                    foreach ($items as $item) {
                        $item = trim($item);
                        if ($item) {
                            $data[] = array(
                                'id_transaksi' => $val[1],
                                'item' => esc_field($item),
                                'tanggal' => date_format($date, "Y-m-d"),
                            );
                        }
                    }
                }
                if ($data) {
                    $db->query("TRUNCATE tb_data");
                    $db->multi_query('tb_data', $data);

                    //echo '<pre>' . print_r($data, 1) . '</pre>';

                    print_msg('Dataset berhasil diimport!', 'success');
                } else {
                    print_msg('Data kosong. Tidak ada yang diimport');
                }
            }
            ?>
            <div class="form-group">
                <label>Pilih file</label>
                <input class="form-control" type="file" name="data" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" name="import"><span class="glyphicon glyphicon-import"></span> Import</button>
                <a class="btn btn-danger" href="?m=data"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>