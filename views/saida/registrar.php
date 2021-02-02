<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: login.php");
}
require_once('../../back/controllers/configCRUD.php');
$s = new ConfigCRUD();
require_once('../../back/controllers/EstoqueController.php');
$view_estoque = new EstoqueController();
$all_estoque = $view_estoque->verEstoqueFarmaciaSaida();
switch ($_SESSION['user']) {
    case 'farma.hvu':
        $permissao = 'disabled';
        break;
    case 'compras.hvu':
        $permissao = '';
        break;
    default:
        $permissao = '';
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
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <?php include('../componentes/sidebar.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <?php $date = date_create($_GET['data_s']); ?>
                <h3 class="card-title">Setor: <?= str_replace("-", " ", $_GET['nomesetor']) ?> -
                    Data: <?= date_format($date, 'd/m/Y') ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="../../back/response/saidasetor/n_saida_r.php">
                    <input type="hidden" name="data_s" value="<?= $_GET['data_s'] ?>">
                    <input type="hidden" name="setor_s" value="<?= $_GET['nomesetor'] ?>">
                    <input type="hidden" name="user" value="<?= $_SESSION['user'] ?>">
                    <?php foreach ($all_estoque as $value) { ?>
                        <input type="hidden" name="produto_s[]"  value="<?= $value->id_estoque ?>">
                        <div class="form-group row">
                            <label for="inputEmail3"
                                   class="col-sm-5 col-form-label text-left font-weight-light"><?= $value->produto_e ?></label>
                            <div class="col-sm-2">
                                <input type="number" id="qtedesolicitada" class="form-control" name="saidaqte_p[]" onkeyup="testando();">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label text-left font-weight-normal">
                                <strong>Em Estoque: <span id="valorestoque"><?= $value->quantidade_e ?></span></strong>
                            </label>
                        </div>
                        <hr>
                    <?php } ?>
                    <button type="submit" class="btn bg-primary col-sm-2 roboto-condensed text-white">Registrar
                        Saída
                        <i class="far fa-edit ml-2"></i>
                </form>
            </div>
            <!-- /.card-body -->
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
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page script -->


<script>
    function testando() {
        var str = $("input[name*='saidaqte_p']").val();
        console.log(str);
    }
</script>
</body>
</html>
