<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../../usuario/login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="../../../dist/img/logo-single.png" type="image/x-icon">
    <title>g-stock</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../../dist/css/mycss.css">
</head>
<body class="hold-transition sidebar-mini roboto-condensed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include('../componentes-exames/nav.php') ?>
    <!-- /.navbar -->
    <?php include('../componentes-exames/sidebar.php') ?>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-white">
        <section class="text-center">
            <img src="../../../dist/img/logo-hvu.jpg" class="img-fluid mt-5" style="opacity: 0.8;" alt="Imagem responsiva">
        </section>
    </div>
    <!-- /.content-wrapper -->

    <?php include('../componentes-exames/footer.php'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
</body>
</html>
