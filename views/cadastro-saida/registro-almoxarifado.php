<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: login.php");
}
require_once('../../back/controllers/EstoqueController.php');
$view_estoque = new EstoqueController();
$all_estoque = $view_estoque->verProdDiversos();

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
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/mycss.css">
</head>
<body class="hold-transition sidebar-mini roboto-condensed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user"></i>
                    <span>Usuário: <?= $_SESSION['usuario'] ?></span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <?php include('../componentes/sidebar.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-3">
        <div class="card">
            <div class="card-header bg-olive">
                <?php $date = date_create($_GET['data_s']); ?>
                <span class="badge badge-pill bg-white text-olive"><i
                            class="text-olive fas fa-star-half"></i><?= str_replace("-", " ", $_GET['nomesetor']) ?></span>
                <span class="badge badge-pill bg-white text-olive"><i
                            class="text-olive fas fa-star-half"></i><?= date_format($date, 'd/m/Y') ?></span>
            </div>
            <!--<form method="POST" action="../../back/response/saida-setor/registrar-saida-back.php">-->
            <form method="POST" id="insertSaida">
                <input type="hidden" name="data_s" value="<?= $_GET['data_s'] ?>">
                <input type="hidden" name="setor_s" value="<?= $_GET['nomesetor'] ?>">
                <input type="hidden" name="usuario" value="<?= $_SESSION['usuario'] ?>">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label class="font-weight-normal">Produto</label>
                            <select class="form-control select2 col-md-12" id="produtoid" name="produtoid" required
                                    onchange="getInEstoque();">
                                <option selected></option>
                                <?php foreach ($all_estoque as $values): ?>
                                    <option value="<?= $values->id_estoque ?>"><?= str_replace("-", " ", $values->produto_e) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="font-weight-normal">Quantidade</label>
                            <div class="input-group">
                                <input type="number" class="form-control"
                                       id="qtdesolicitada" name="quantidade_solicitada" required  onkeyup="validacao();">
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="font-weight-normal">Em Estoque</label>
                            <div class="input-group">
                                <input class="form-control" id="estoque"  readonly type="text" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <button type="submit" id="registrar" class="btn btn-success col-sm-2">Registrar Saída
                    </button>
                </div>
            </form>
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
<script src="../../requests/saida-setor-ajax/buscar-produto.js"></script>
<script src="../../requests/saida-setor-ajax/post-produto.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>

</script>
<script>
    $(function (qualifiedName, value) {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

    })
    function validacao() {
        const solicitada = parseInt(document.getElementById('qtdesolicitada').value);
        const estoque = parseInt(document.getElementById('estoque').value);
        if (solicitada > estoque || solicitada === 0) {
            document.getElementById('registrar').setAttribute('disabled', 'disabled');
        } else {
            document.getElementById('registrar').removeAttribute('disabled')
        }
    }
</script>

</body>
</html>
