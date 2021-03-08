<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../usuario/login.php");
}
require_once('../../back/controllers/CompraController.php');
require_once('../../back/controllers/NotaFiscalController.php');
$nfController = new NotaFiscalController();
$dados = new CompraController();
$dadosOrdem = $dados->listOCwithEstoque($_GET['idordem']);
$idenNF = 0;
$statusNF = 0;
foreach ($dadosOrdem as $p) {
    $idenNF = $p->id_fk_nf;
}
foreach ($nfController->listUniqueNF($idenNF) as $status) {
    $statusNF = $status->status_nf;
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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active ">
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="col-md-12">
            <!-- general form elements -->

            <div class="card card-olive">
                <?php
                require_once('../../back/controllers/CompraController.php');
                $c = new CompraController();
                $compra = $c->listUniqueOC($_GET['idordem']);
                foreach ($compra as $v) {
                    ?>

                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-people-arrows nav-icon"></i>
                            Fornecedor: <?= $v->nome_f ?></h3><a class="text-white float-lg-right"
                                                                 target="_blank"
                                                                 href="ordem-compra-pdf.php?id_ordem=<?= $_GET['idordem'] ?>">
                            <i class="fas fa-print"></i> Imprimir</a>
                    </div>
                <?php } ?>

                <!--<form role="form" method="POST" action="../../back/response/compra/n_prod_ordem_compra.php">-->
                <form role="form" id="cadatrar-prod-compra">
                    <input type="hidden" name="ordem" value="<?= $_GET['idordem'] ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label class="font-weight-normal">Produto</label>
                                <select class="form-control select2" name="selectprodid" id="selectprodid"
                                        onchange="getValores();">
                                    <option selected></option>
                                    <?php
                                    require_once('../../back/controllers/EstoqueController.php');
                                    $view_estoque = new EstoqueController();
                                    $all_estoque = $view_estoque->verEstoqueTotal();
                                    foreach ($all_estoque as $values) {
                                        ?>
                                        <option value="<?= $values->id_estoque ?>"><?= $values->produto_e ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="font-weight-normal">Quantidade(Unitária)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-olive"><i
                                                    class="fas fa-sort-numeric-up-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="" name="saidaqte_p" id="saidaqte_p">
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="font-weight-normal">Valor Unitário</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-olive"><i
                                                    class="far fa-calendar-alt "></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="valor_un_c" value="" id="valor_un_c">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <?php if ($statusNF == 0): ?>
                        <div class="card-footer">
                            <button type="submit" class="btn bg-gradient-teal col-md-2 elevation-2">Adicionar</button>
                        </div>
                    <?php endif; ?>
                </form>
                <hr>
                <?php
                foreach ($dadosOrdem as $value) {
                    $valorTotalProduto = $value->valor_un_c * $value->qtde_compra;
                    $valorUnCompra = floatval($value->valor_un_c);
                    ?>
                    <form method="post" action="../../back/response/ordem-compra/update-prod-compra.php"
                          id="alterarproduto">
                        <input type="hidden" value="<?= $value->id_item_compra ?>" name="idcompra">
                        <input type="hidden" value="<?= $value->item_compra ?>" name="idproditem">
                        <input type="hidden" value="<?= $value->ordem_compra_id ?>" name="idordem">
                        <input type="hidden" value="<?= $value->valor_un_c ?>" name="valoruni">
                        <div class="container p-2">
                            <div class="row mt-1">
                                <?php if ($statusNF == 0): ?>
                                    <div class="col-md-1">
                                        <a href=../../back/response/ordem-compra/delete-prod-compra.php?deleteprod=<?= $value->id_item_compra ?>>
                                            <i class="fas fa-minus-circle text-danger"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if ($statusNF == 0): ?>
                                    <div class="col-md-4 text-olive">
                                        <span><?= $value->produto_e ?></span>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-6 text-olive">
                                        <span><?= $value->produto_e ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($statusNF == 0): ?>
                                    <div class="col-md-2 ">
                                        <input type="number" placeholder="Quantidade"
                                               class="form-control text-center"
                                               name="qtdecomprada" id="qtdecomprada" value="<?= $value->qtde_compra ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-2 ">
                                        <span class="text-gray"><?= $value->qtde_compra ?> </span>
                                    </div>

                                <?php endif; ?>
                                <div class="col-md-2">
                                    <span class="text-gray">Unitário: R$ <?= $valorUnCompra ?> </span>
                                </div>
                                <div class="col-md-2">
                                    <span class="text-gray">Total: R$ <?= $valorTotalProduto ?></span>
                                </div>
                                <?php if ($statusNF == 0): ?>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                    </form>
                <?php } ?>
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
<script src="../../requests/ordem-compra-ajax/buscar-produtos.js"></script>
<script src="../../requests/ordem-compra-ajax/cadastrar-produto.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
