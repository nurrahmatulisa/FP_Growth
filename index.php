<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="favicon.ico" />

    <title>FP-Growth</title>
    <link href="assets/css/readable-bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/general.css" rel="stylesheet" />
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>
    <style type="text/css">
    
    
        .fp_tree ul {
            margin-left: 0px
        }

        .fp_tree li {
            list-style-type: none;
            margin: 5px;
            position: relative
        }

        .fp_tree li::before {
            content: "";
            position: absolute;
            top: -5px;
            left: -20px;
            border-left: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-radius: 0 0 0 0;
            width: 20px;
            height: 14px
        }

        .fp_tree li::after {
            position: absolute;
            content: "";
            top: 8px;
            left: -20px;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
            border-radius: 0 0 0 0;
            width: 20px;
            height: 100%
        }

        .fp_tree li:last-child::after {
            display: none
        }

        .fp_tree li:last-child:before {
            border-radius: 0 0 0 5px
        }

        ul.fp_tree>li:first-child::before {
            display: none
        }

        .fp_tree b {
            min-width: 50px;
        }
        body {
            background-color: #1863e6; /* Ganti dengan warna yang diinginkan */
        }

        .main-sidebar {
            background-color: #1863e6 !important; /* Ganti dengan warna yang diinginkan */
            /* !important digunakan untuk memastikan bahwa warna di-overide */
        }
        .bigger-font {
    font-size: 20px; /* Ganti dengan ukuran font yang diinginkan */
}
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.dtb1').DataTable();
            $('.dtb2').DataTable();
        });
    </script>
</head>

<body>
        <?php
        if (file_exists($mod . '.php'))
            include $mod . '.php';
        else
            include 'home.php';
        ?>

    <!-- <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>Copyright &copy; <?= date('Y') ?> Toko Bangunan XYZ</p>
                </div>
            </div>
        </div>
    </footer> -->
    <script type="text/javascript">
        $('.form-control').attr('autocomplete', 'off');
    </script>
</body>

</html>