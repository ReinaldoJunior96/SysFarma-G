<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../user/login.php");
}
require_once('../../back/controllers/configCRUD.php');
$s = new ConfigCRUD();
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
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <form class="form-inline">
            <a disabled="" class="nav-link"></a>
        </form>
    </nav>
    <!-- /.navbar -->
    <?php include('../componentes/sidebar.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <small>Ordem de compra</small>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="#" data-toggle="modal" data-target="#modal-lg">Ver
                                    Produtos</a></li>
                            <li class="breadcrumb-item active"><a href="ordem_pdf.php?id_ordem=<?= $_GET['ordem'] ?>">Imprimir</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Produtos Adicionados</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <?php
                            require_once('../../back/controllers/CompraController.php');
                            $dados = new CompraController();
                            $dados_ordem = $dados->verOrdemTotal($_GET['ordem']);
                            $somaValor = 0;
                            foreach ($dados_ordem as $value) {
                                $somaValor += $value->valor_un_c * $value->qtde_compra;
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php $valorUNCompraDisplay = floatval($value->valor_un_c) ?>
                                    <?= $value->produto_e ?> / <?= "Qtde: " . $value->qtde_compra ?>
                                    / <?= "Total (R$): " . $value->qtde_compra * $valorUNCompraDisplay ?>
                                    <a href="../../back/response/compra/d_prod_compra.php?idprod=<?= $value->id_item_compra ?>"><i
                                                class='fas fa-ban fa-lg' style='color: red;'></i></a>
                                </li>
                            <?php } ?>
                            <li class="list-group-item active"><?= "R$ " . number_format($somaValor, 2, ',', '.') ?></li>
                        </ul>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


        <div class="col-md-12 mt-3">
            <!-- general form elements -->

            <div class="card card-green">
                <?php
                require_once('../../back/controllers/CompraController.php');
                $c = new CompraController();
                $compra = $c->verOrdem($_GET['ordem']);
                foreach ($compra as $v) {
                    ?>
                    <div class="card-header">
                        <h3 class="card-title">Fornecedor: <?= $v->nome_f ?></h3>
                    </div>
                <?php } ?>


                <!-- /.card-header -->
                <!-- form start -->
                <div class="card" id="tabela" style="display: none">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr class="">
                                <th class="">Produto / Material</th>
                                <th>Qtde Un (Compra)</th>
                                <th class="">Valor Unitário</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            require_once('../../back/controllers/EstoqueController.php');
                            $view_estoque = new EstoqueController();
                            $all_estoque = $view_estoque->verEstoqueTotal();
                            foreach ($all_estoque as $v) {
                                ?>
                                <tr>
                                    <form method="POST" action="../../back/response/compra/n_prod_ordem_compra.php">
                                        <input type="hidden" name="produto_c" value="<?= $v->id_estoque ?>">
                                        <input type="hidden" name="ordem" value="<?= $_GET['ordem'] ?>">
                                        <td class="text-center"><?= $v->produto_e ?></td>
                                        <td>
                                            <input type="number" class="form-control" name="saidaqte_p"
                                                   id="inputPassword4"
                                                   placeholder="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" required name="valor_un_c"
                                                   id="inputPassword4"
                                                   placeholder="R$" value="<?= $v->valor_un_e ?>">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn roboto-condensed text-white mt-1">
                                                <i class="fas fa-file-import text-secondary"></i>
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->

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
<script src="../../dist/js/myjs.js"></script>
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
