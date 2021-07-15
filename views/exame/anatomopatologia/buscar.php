<?php
session_start();
if ($_SESSION['usuario'] == null || $_SESSION['password'] == null) {
    header("location: ../usuario/login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="../../../dist/img/logo-single.png" type="image/x-icon">
    <title>GStock</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- MeuCSS -->
    <link rel="stylesheet" href="../../../dist/css/mycss.css">
</head>
<body class="hold-transition sidebar-mini roboto-condensed">
<div class="wrapper">
    <!-- Navbar -->
    <?php include '../componentes-exames/nav.php'?>
    <!-- /.navbar -->
    <?php include '../componentes-exames/sidebar.php'?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="col-md-12 mt-3">
            <!-- general form elements -->
            <div class="card card-olive">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search"></i> Exames Anatomopatológicos</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <!-- /.card -->
                <div class="" id="tabela">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr class="bg-teal ">
                                <th class="font-weight-light">Proprietário</th>
                                <th>Animal</th>
                                <th>Cod. Anatamo</th>
                                <th>Raça</th>
                                <th>Data</th>
                                <th>Baixar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
require_once '../../../back/controllers/AnatamoController.php';
$anatamo = new AnatomoController();
$exames = $anatamo->listExamesAnatomo();
foreach ($exames as $v) {
    ?>
                                <tr>
                                    <td><?=$v->nome_proprietario?></td>
                                    <td><?=$v->nome_animal?></td>
                                    <td><?=$v->cod_anatomo?></td>
                                    <td><?=$v->raca_anatomo?></td>
                                    <td><?=$v->data_amostra?></td>
                                    <td><a href="../../../back/response/exame/anatomopatologia/download-exame-anatomo.php?exame_string=<?=$v->exame_string?>"><i class="fas fa-cloud-download-alt"></i></a></td>
                                </tr>
                                <?php }?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../componentes-exames/footer.php';?>
</div>
<!-- ./wrapper -->


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
<!-- DataTable -->
<script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../../dist/js/dataTableCustom.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- RequestAJAX -->
<script src="../../../requests/fornecedores-ajax/post-fornecedores.js"></script>

</body>
</html>
