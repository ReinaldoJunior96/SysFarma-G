<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../usuario/login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="../../dist/img/logo-single.png" type="image/x-icon">
    <title>g-stock</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/mycss.css">
</head>
<body class="hold-transition sidebar-mini roboto-condensed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include('../componentes/nav.php') ?>
    <!-- /.navbar -->
    <?php include('../componentes/sidebar.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="col-md-12 mt-3">
            <!-- /.card -->
            <div class="card">
                <div class="card-header bg-olive">
                    <?php
                    date_default_timezone_set('America/Sao_Paulo');
                    $today = new DateTime();
                    ?>
                    <h3 class="card-title"><i class="fas fa-file-invoice"></i> Relatório
                        . <?= date_format($today, 'd/m/Y H:i:s'); ?>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Produto</th>
                            <th style="width: 40px">Quanitdade</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        require_once('../../back/controllers/EstoqueController.php');
                        $produto = new EstoqueController();
                        $todosProdutosFarmacia = $produto->verEstoqueFarmacia();
                        $contagem = 0;
                        foreach ($todosProdutosFarmacia as $v) :
                            ?>
                            <tr>
                                <td><?= $contagem ?></td>
                                <td><?= $v->produto_e ?></td>
                                <td><?= $v->quantidade_e ?></td>
                                <td></td>
                            </tr>
                            <?php
                            $contagem++;
                        endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include('../componentes/footer.php'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
