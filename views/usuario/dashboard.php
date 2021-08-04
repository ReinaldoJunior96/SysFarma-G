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
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
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
    <div class="content-wrapper bg-white">
        <section class="text-center">
            <img src="../../dist/img/logo-hvu.jpg" class="img-fluid mt-2 mb-2" width="300" style="opacity: 0.8;"
                 alt="Imagem responsiva">
        </section>
        <div class="row col-12">
            <div class="card col-8">
                <div class="card-header border-transparent">
                    <h3 class="card-title"><i class="fas fa-calendar-alt text-success font-weight-bolder"></i> Atenção!
                        Acompanhe a validade das medicações</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <!--<button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>-->
                    </div>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="table-responsive " style="height: 300px;">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>Produto / Material</th>
                                <th>Lote</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            require_once('../../back/controllers/EstoqueController.php');
                            require_once('../../back/controllers/AvariaController.php');
                            $s = new EstoqueController();
                            $avariaController = new AvariaController();
                            $medicamentos = $s->controleVencimento();
                            foreach ($medicamentos as $v) {
                                date_default_timezone_set('America/Sao_Paulo');
                                $database = date_create($v->validade);
                                $datadehoje = date_create();
                                $resultado = date_diff($database, $datadehoje);
                                ?>
                                <tr>
                                    <?php if ($resultado->days <= 15 && $avariaController->verificaAvaria($v->lote) == 0): ?>
                                        <td> <?= $v->produto_e ?></td>
                                        <td><?= $v->lote ?></td>
                                        <td><i class="fas fa-exclamation-circle text-warning"></i> Vencimento
                                            em <?= $resultado->days ?>
                                            dias
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
            </div>
            <div class="col-4">
                <!-- Info Boxes Style 2 -->
                <div class="info-box mb-3 bg-warning">
                    <span class="info-box-icon text-white"><i class="fas fa-calendar-alt font-weight-bolder"></i></span>
                    <div class="info-box-content">
                        <!--<span class="info-box-text">Atenção!</span>-->
                        <span class="info-box-number text-white">Fique atendo na validade dos medicamentos</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon"><i class="fas fa-bezier-curve nav-icon"></i></span>
                    <div class="info-box-content">
                        <!--<span class="info-box-text">Mentions</span>-->
                        <span class="info-box-number">Preste atenção quando for registrar a saída</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-danger">
                    <span class="info-box-icon"><i class="fas fa-file-import"></i></span>

                    <div class="info-box-content">
                        <!-- <span class="info-box-text">Downloads</span>-->
                        <span class="info-box-number">Não esqueça o relatório diário de consumo</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-info">
                    <span class="info-box-icon"><i class="nav-icon fas fa-cubes"></i></span>

                    <div class="info-box-content">
                        <!--<span class="info-box-text">Direct Messages</span>-->
                        <span class="info-box-number">Sempre que possível, acompanhe o estoque</span>
                    </div>
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
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>

</body>
</html>
