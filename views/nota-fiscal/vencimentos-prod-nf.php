<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../usuario/login.php");
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
            <?php
            require_once('../../back/controllers/NotaFiscalController.php');
            $dados_nf = new NotaFiscalController();
            $nf = $dados_nf->listUniqueNF($_GET['idnf']);
            $textNFNE = "";
            foreach ($nf as $v) {
                $textNFNE = ($v->nota_entrega == 1) ? 'Nota de Entrega ' : 'Nota Fiscal';
            } ?>
            <div class="card">
                <div class="card-header text-muted border-bottom-0 bg-olive"><i class="fas fa-file"></i>
                    <?= $textNFNE ?>
                    <a href="edit-nf-view.php?idnf=<?= $_GET['idnf'] ?>">
                        <i class='fas fa-edit fa-1x color-icon-nf float-right'></i></a>
                </div>
                <div class="card-body pt-0 mt-3">
                    <div class="row">
                        <?php
                        foreach ($nf as $v) {
                            ?>
                            <div class="col-7 text-gray">
                                <h2 class="lead"><b><?= $v->fornecedor ?></b> - <i
                                            class="fas fa-money-bill-wave"></i></i> Valor:
                                    R$ <?= $v->valor_total ?></h2>
                                <p class="">Data de
                                        Emissão: </b> <?= date("d/m/Y", strtotime($v->data_emissao)) ?>
                                    <br>
                                     Data de Lançamento: <?= date("d/m/Y", strtotime($v->data_lancamento)) ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <div class="p-3">
                    <form method="POST" action="../../back/model/notaf/post-vencimento-parcela.php">
                        <input type="hidden" name="new" value="1">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label font-weight-normal">Data de vencimento</label>
                            <div class="col-sm-8">
                                <input type="date" name="d_vencimento" class="form-control" id="inputEmail3">
                                <input type="hidden" name="idnf" value="<?= $_GET['idnf'] ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-success col-sm-2">Cadastrar<i
                                    class="fas fa-plus ml-2"></i></button>
                    </form>
                </div>

            </div>
            <div class="card">
                <div class="card-header bg-olive">
                    <h3 class="card-title">Vencimentos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                        require_once('../../back/controllers/NotaFiscalController.php');
                        $notaf = new NotaFiscalController();
                        $notas = $notaf->listVencimento($_GET['idnf']);

                        foreach ($notas as $value) {
                            $data = date_create($value->vencimento);
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-olive">
                                <?= date_format($data, "d/m/Y") ?>
                                <a href="../../back/model/notaf/delete-parcelas-vencimento.php?idv=<?= $value->id ?>">
                                    <span class="badge badge-pill far fa-window-close text-danger float-right"> </span>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
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
