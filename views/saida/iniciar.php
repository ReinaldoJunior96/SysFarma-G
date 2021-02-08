<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../user/login.php");
}
require_once('../../back/controllers/setoresController.php');
$s = new SetorController();
$setores = $s->verSetores();
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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
            <!-- general form elements -->
            <div class="card card-olive">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-invoice"></i> Saída </h3>
                </div>
                <form role="form" method="GET" action="registrar.php">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-9">
                                <label class="font-weight-normal">Setor</label>
                                <select class="form-control select2 col-md-12" name="nomesetor" required>
                                    <option selected></option>
                                    <?php foreach ($setores as $values): ?>
                                        <option value="<?= $values->setor_s ?>"><?= str_replace("-", " ", $values->setor_s) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-normal">Data</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-olive"><i
                                                    class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" data-inputmask-alias="datetime"
                                           data-inputmask-inputformat="dd/mm/yyyy" data-mask name="data_s">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 flex-grow-1 bd-highlight">
                                <button type="submit" class="btn bg-gradient-teal col-md-2 elevation-2">Iniciar</button>
                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="historico.php" class="float-right btn bg-gradient-olive elevation-1">
                                    <i class="fas fa-history"></i> Histórico
                                </a></div>
                        </div>
                    </div>
                </form>
                <?php if (isset($_GET['erroprod']) && count($_GET['erroprod']) > 0): ?>
                    <div class="p-3">
                        <div class="alert alert-default-danger elevation-2" role="alert">
                            <h3 class="text-danger font-weight-bold"><i class="fas fa-exclamation-circle"></i> Atenção!!
                            </h3>
                            <h5>Alguns produtos não foram registrados. &#128556;</h5>
                            <hr>
                            <?php foreach ($_GET['erroprod'] as $k): ?>
                                <span class=""><?= $k ?></span><br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php elseif (isset($_GET['produtos']) && $_GET['produtos'] == "success"): ?>
                    <div class="p-2">
                        <div class="alert alert-default-success" role="alert">
                            <h3 class="text-success font-weight-bold"><i class="fas fa-check-circle"></i> Sucesso!!</h3>
                            <h5>Todos os produtos foram registrados. &#128513;</h5>
                        </div>
                    </div>
                <?php endif; ?>
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
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

    })
</script>
</body>
</html>
