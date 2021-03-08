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

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../dist/css/mycss.css">
</head>
<body class="hold-transition sidebar-mini roboto-condensed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include('../componentes/nav.php') ?>
    <!-- /.navbar -->
    <?php include('../componentes/sidebar.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-2">
        <div class="card">
            <div class="card-header bg-olive">
                <h3 class="card-title"><i class="fas fa-file"></i> Nota Fical</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr class="text-gray">
                        <th class="">Nota Fiscal</th>
                        <th class="">Nº Ordem</th>
                        <th class="">Fornecedor</th>
                        <th class="">Data de Emissão</th>
                        <th class="">Data Lançamento</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="text-olive">
                    <?php
                    require_once('../../back/controllers/NotaFiscalController.php');
                    $view_nf = new NotaFiscalController();
                    $allnf = $view_nf->listNF();
                    foreach ($allnf as $v) {
                        $data_emisao = date_create($v->data_emissao);
                        $data_lancamento = date_create($v->data_lancamento);
                        ?>
                        <tr>
                            <td><a class='text-olive' href=produtos-nota-fiscal.php?idnf=<?=$v->id_nf?>><?=$v->numero_nf?></a></td>
                            <td><a class='text-olive' href="../ordem-compra/adicionar-produtos.php?idordem=<?=$v->id_ordem?>"</a><?=$v->id_ordem?></td>
                            <td><?= $v->fornecedor ?></td>
                            <td><?= date_format($data_emisao, 'd/m/Y') ?> </td>
                            <td><?= date_format($data_lancamento, 'd/m/Y') ?></td>
                            <td><a href=edit-nf-view.php?idnf=<?=$v->id_nf?>><i class='fas fa-pen fa-1x color-icon-nf text-success'></i></a></td>
                            <td><a href=../../back/response/notaf/d_nf_r.php?idnf="<?=$v->id_nf?>><i class='fas fa-trash-alt fa-1x text-danger'></i></a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

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

<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../dist/js/dataTableCustom.js"></script>
</body>
</html>
