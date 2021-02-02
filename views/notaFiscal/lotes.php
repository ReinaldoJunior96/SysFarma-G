<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../user/login.php");
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
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user"></i>
                    <span>Usuário: <?=$_SESSION['user']?></span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <?php include('../componentes/sidebar.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="col-md-12 mt-3">
            <?php
            require_once('../../back/controllers/NotaFiscalController.php');
            $dados_nf = new NotaFiscalController();
            $nf = $dados_nf->verNF($_GET['idnf']);
            $textNFNE = "";
            foreach ($nf as $v) {
                $textNFNE = ($v->nota_entrega == 1) ? 'Nota de Entrega ' : 'Nota Fiscal';
            } ?>
            <div class="card">
                <div class="card-header text-muted border-bottom-0">
                    <?= $textNFNE ?>
                    <a href="editNF.php?idnf=<?= $_GET['idnf'] ?>">
                        <i class='fas fa-edit fa-1x color-icon-nf text-black-50 float-right'></i></a>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <?php
                        foreach ($nf as $v) {
                            ?>
                            <div class="col-7">
                                <h2 class="lead"><b><?= $v->fornecedor ?></b> - <i
                                            class="fas fa-money-bill-wave"></i></i> Valor:
                                    R$ <?= $v->valor_total ?></h2>
                                <p class="text-muted text-sm"><b>Data de
                                        Emissão: </b> <?= date("d/m/Y", strtotime($v->data_emissao)) ?>
                                    <br>
                                    <b> Data de Lançamento: </b> <?= date("d/m/Y", strtotime($v->data_lancamento)) ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <div class="p-3">
                    <form role="form" id="lotesform" method="post">
                        <input type='hidden' class='form-control ' name='idnf' value="<?= $_GET['idnf'] ?>"
                               placeholder=''>
                        <div class="form-group row">
                            <label for="inputEmail3"
                                   class="col-sm-1 col-form-label">Produto</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="prod_nf" required>
                                    <option selected></option>
                                    <?php
                                    require_once('../../back/controllers/NotaFiscalController.php');
                                    $produtos = new NotaFiscalController();
                                    $ver_produtos = $produtos->verProdNF($_GET['idnf']);
                                    foreach ($ver_produtos as $v):?>
                                        <option value="<?= $v->id_estoque ?>"><?= $v->produto_e ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-1 col-form-label">Lote</label>
                            <div class="col-sm-3">
                                <input type='text' class='form-control ' name='lote_prod_nf' placeholder=''>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-1 col-form-label">Validade</label>
                            <div class="col-sm-3">
                                <input type='date' class='form-control ' name='validade_prof_nf' placeholder=''>
                            </div>
                        </div>
                        <button type="submit" class="btn bg-primary shadow col-sm-2 exo mt-1 text-white">Adicionar <i
                                    class="fas fa-plus ml-2"></i></button>
                    </form>
                </div>

            </div>
            <div class="card" id="tabela" style="display: none">
                <div class="card-header">
                    <h3 class="card-title">Lotes & Validades</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Lote</th>
                            <th scope="col">Validade</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        require_once '../../back/controllers/NotaFiscalController.php';
                        $nfProd = new NotaFiscalController();
                        $nfLotes = $nfProd->buscarLote($_GET['idnf']);

                        foreach ($nfLotes as $prodLotes):
                            $data = date_create($prodLotes->validade);
                            ?>
                            <tr>
                                <td><?= $prodLotes->produto_e ?></td>
                                <td> <?= $prodLotes->lote ?></td>
                                <td> <?= date_format($data, "d/m/Y") ?></td>
                                <td>
                                    <a href="../../back/response/notaf/d_lotes.php?idl=<?= $prodLotes->id_nf_lote ?>">
                                        <span class="badge badge-pill far fa-window-close text-danger float-right"> </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
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
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- RequestAJAX -->
<script src="requestLote.js"></script>
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
