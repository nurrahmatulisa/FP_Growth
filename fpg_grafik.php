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
    <h1>Grafik Hasil Fp-Growth</h1>
</div>
<script src="assets/js/highcharts.js"></script>
<script src="assets/js/exporting.js"></script>
<script src="assets/js/export-data.js"></script>
<script src="assets/js/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
</figure>
<?php
$rows = $db->get_results("SELECT item, COUNT(id_transaksi) AS total
FROM tb_data 
WHERE item IN (SELECT left_item FROM tb_hasil WHERE left_item NOT LIKE '%, %' UNION SELECT right_item FROM tb_hasil WHERE left_item NOT LIKE '%, %') 
GROUP BY item;");
$series = array();
foreach ($rows as $row) {
    $series[$row->item] = $row->total * 1;
}
?>
<hr />
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Keterangan</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($series as $key => $val) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $key ?></td>
                    <td><?= $val ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Frequent Itemset Hasil Fp-Growth'
        },
        // subtitle: {
        //     text: 'Source: WorldClimate.com'
        // },
        xAxis: {
            categories: <?= json_encode(array_keys($series)) ?>,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total (item)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Item',
            data: <?= json_encode(array_values($series)) ?>
        }]
    });
</script>