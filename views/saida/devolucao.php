<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../user/login.php");
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
        <div class="col-md-12 mt-3">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-invoice"></i> Informe o setor e a data que desejar
                        iniciar o procedimento de saída
                    </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <form role="form" method="post" action="../../back/response/saidasetor/devolucao.php">
                    <?php
                    require_once('../../back/controllers/EstoqueController.php');
                    $d = new EstoqueController();
                    $devolucao = $d->searchDevolucao($_GET['idsaida']);
                    foreach ($devolucao

                             as $k):
                        ?>
                        <div class="card-body">

                            <input type="hidden" name="user" value="<?= $_SESSION['user'] ?>">
                            <input type="hidden" name="idsaida" value="<?= $k->id_saida ?>">
                            <input type="hidden" name="itemsaida" value="<?= $k->item_s ?>">
                            <input type="hidden" name="quantidadesaida" value="<?= $k->quantidade_s ?>">
                            <input type="hidden" name="setorsaida" value="<?= $k->setor_s ?>">
                            <input type="hidden" name="datas" value="<?= $k->data_s ?>">
                            <input type="hidden" name="datadiasaida" value="<?= $k->data_dia_s ?>">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Produto / Meterial</label>
                                    <input type='text' class='form-control' value="<?= $k->produto_e ?>" disabled
                                           name='produtosaida'>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Quantidade Devolvida</label>
                                    <input type="number" class='form-control' name="quantidadedevolvida">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Setor</label>
                                    <input type="text" class="form-control" disabled value="<?= $k->setor_s ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Data / Hora</label>
                                    <input type="text" class="form-control"
                                           disabled
                                           value="<?= $k->data_s ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">Confirme</label>
                                    <input type="password" class="form-control" name="autorizacao">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary col-md-2">Realizar Devolução</button>
                    </div>
                </form>

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
<script type='text/javascript'>
    (function () {
        if (window.localStorage) {
            if (!localStorage.getItem('firstLoad')) {
                localStorage['firstLoad'] = true;
                window.location.reload();
            } else
                localStorage.removeItem('firstLoad');
        }
    })();
</script>
</body>
</html>