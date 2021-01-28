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
                            <li class="breadcrumb-item active"><a href="ordempdf.php?id_ordem=<?= $_GET['ordem'] ?>">Imprimir</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

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

                <form role="form" method="POST" action="../../back/response/compra/n_prod_ordem_compra.php">
                    <input type="hidden" name="ordem" value="<?= $_GET['ordem'] ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label>Setor</label>
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
                                <label>Quantiade(Unitária)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="" name="saidaqte_p" id="saidaqte_p">
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Valor Unitário</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="valor_un_c" value="" id="valor_un_c">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary col-md-2">Adicionar</button>
                    </div>
                </form>
                <hr>
                <?php
                require_once('../../back/controllers/CompraController.php');
                $dados = new CompraController();
                $dadosOrdem = $dados->verOrdemTotal($_GET['ordem']);
                $somaValor = 0;
                foreach ($dadosOrdem as $value) {
                    $valorTotalProduto = $value->valor_un_c * $value->qtde_compra;
                    $valorUnCompra = floatval($value->valor_un_c);
                    ?>
                    <form method="post" action="../../back/response/compra/updateitem.php" id="alterarproduto">
                        <input type="hidden" value="<?=$value->id_item_compra?>" name="idcompra">
                        <input type="hidden" value="<?=$value->item_compra?>" name="idproditem">
                        <input type="hidden" value="<?=$value->ordem_compra_id?>" name="idordem">
                        <input type="hidden" value="<?=$value->valor_un_c?>" name="valoruni">
                        <div class="d-flex bd-highlight align-items-center">
                            <div class="p-2 bd-highlight">
                                <a href=../../back/response/compra/d_prod_compra.php?deleteprod=<?= $value->id_item_compra ?>>
                                    <i class="fas fa-minus-circle text-danger"></i>
                                </a>
                            </div>
                            <div class="p-2 flex-grow-1 bd-highlight"><?= $value->produto_e ?></div>
                            <div class="p-2 bd-highlight">
                                <input type="number" placeholder="Quantidade"
                                       class="form-control text-center"
                                       name="qtdecomprada" id="qtdecomprada" value="<?= $value->qtde_compra ?>">
                            </div>

                            <div class="p-2 bd-highlight col-2">
                                <strong>Valor Unitário: </strong>
                                <span><?=$valorUnCompra?> </span>
                            </div>
                            <div class="p-2 bd-highlight">
                                <strong>Valor total:</strong> <span><?= $valorTotalProduto ?></span>
                            </div>
                            <div class="p-2 bd-highlight">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save text-white"></i>
                                </button>
                            </div>
                        </div>
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
<script src="../../dist/js/myjs.js"></script>
<script src="alterarprodutos.js"></script>
<script src="searchproduto.js"></script>
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
