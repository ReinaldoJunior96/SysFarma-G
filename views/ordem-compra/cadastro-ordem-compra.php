<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../usuario/login.php");
}
switch ($_SESSION['usuario']) {
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
    <div class="content-wrapper">
        <div class="col-md-12 mt-3">
            <!-- general form elements -->
            <div class="card card-olive">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-import"></i> Ordem de compra</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" action="../../back/response/ordem-compra/post-ordem-compra.php">
                    <div class="card-body">
                        <div class="form-group col-md-12">
                            <label class="font-weight-normal">Fornecedor</label>
                            <select class="form-control select2" name="nome_f">
                                <option selected></option>
                                <?php
                                require_once('../../back/controllers/FornecedorController.php');
                                $fornecedorController = new FornecedorController();
                                $fornecedores = $fornecedorController->listFornecedores();
                                foreach ($fornecedores as $v) {
                                    ?>
                                    <option class="roboto-condensed"
                                            value="<?= $v->nome_fornecedor ?>"><?= str_replace("-", " ", $v->nome_fornecedor) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="form-inline mt-3">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="radio" class="form-check-input" name="info_ne" value="0"
                                           id="exampleCheck1" required>
                                    <label class="form-check-label" for="exampleCheck1">Nota Fiscal</label>
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="radio" class="form-check-input" name="info_ne" value="1"
                                           id="exampleCheck2" required>
                                    <label class="form-check-label" for="exampleCheck2">Nota de Entrega</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-teal col-md-2 elevation-2">Cadastrar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
            <div class="card" id="tabela" style="display: none">
                <div class="card-header bg-olive">
                    <h3 class="card-title"></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr class="text-gray">
                            <th class="">NºOrdem</th>
                            <th class="">N.F / N.E</th>
                            <th class="">Fornecedor</th>
                            <th class="">Criada em</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="text-olive">
                        <?php
                        include '../../back/controllers/CompraController.php';
                        $view_ordens = new CompraController();
                        $all_ordens = $view_ordens->listOC();
                        foreach ($all_ordens as $v) {
                            ?>
                            <tr>
                                <td class=""><?= $v->id_ordem ?></td>
                                <td ><a class="text-olive font-weight-bold"
                                            href="../nota-fiscal/produtos-nota-fiscal.php?idnf=<?= $v->id_fk_nf ?>">Acessar</a>
                                </td>
                                <td ><a class="text-olive"
                                            href="adicionar-produtos.php?idordem=<?= $v->id_ordem ?>"><?= $v->nome_f ?></a></td>
                                <td class=""><?= date("d/m/Y H:i:s", strtotime($v->data_c)) ?></td>

                                <td><a href="../../back/response/ordem-compra/delete-ordem-compra.php?idordem=<?= $v->id_ordem ?>"><i
                                                class='fas fa-trash text-danger'></i></a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <?php include('../componentes/footer.php'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../dist/js/dataTableCustom.js"></script>
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
