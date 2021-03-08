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
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../dist/css/mycss.css">
</head>

<body class="hold-transition sidebar-mini roboto-condensed">
<div class="wrapper">
    <!-- Navbar cima -->
    <?php include('../componentes/nav.php') ?>
    <!-- /.navbar sidebar -->
    <?php include('../componentes/sidebar.php') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="col-md-12 mt-3">
            <!-- general form elements -->
            <div class="card card-olive">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-share-alt-square"></i> Setores</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" id="setorform" method="post">
                    <input type="hidden" name="setor" value="1">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="font-weight-normal ">Informe o nome dos setor</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="novo_setor"
                                   placeholder="Qual setor você deseja cadastrar?">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-teal col-md-2 elevation-2">Adicionar</button>
                    </div>
                </form>
                <hr>
                <!-- /.card -->

                <div class="" id="tabela" style="display: none">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped text-olive">
                            <thead>
                            <tr>
                                <td class="bg-teal">Setores Cadastrados</td>
                                <td class="bg-teal"></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            require_once('../../back/controllers/SetorController.php');
                            $s = new SetorController();
                            $setores = $s->listSetores();
                            foreach ($setores as $v) {
                                ?>
                                <tr>
                                    <td class="font-weight-lighter"><?= str_replace("-", " ", $v->setor_s) ?></td>
                                    <td class="text-center">
                                        <a href="../../back/response/setor/delete-setor.php?setor=<?= $v->id_setor ?>">
                                            <i class="fas fa-window-close text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

        </div>
    </div>

    <?php include('../componentes/footer.php'); ?>
</div>
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
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- RequestAJAX -->
<script src="../../requests/setores-ajax/post-setor.js"></script>

</body>
</html>
