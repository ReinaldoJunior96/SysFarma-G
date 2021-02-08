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
    <?php include('../componentes/nav.php') ?>
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
                <div class="card-header text-muted border-bottom-0 bg-olive"><i class="fas fa-file"></i>
                    <?= $textNFNE ?>
                </div>
                <div class="card-body pt-0 mt-3">
                    <?php
                    foreach ($nf as $v) {
                        ?>
                        <div class="col-7 text-gray">
                            <h2 class="lead"><b><?= $v->fornecedor ?></b> - <i
                                        class="fas fa-money-bill-wave"></i></i> Valor:
                                R$ <?= $v->valor_total ?></h2>
                            <p class="">Data de
                                    Emissão: <?= date("d/m/Y", strtotime($v->data_emissao)) ?>
                                <br>
                                Data de Lançamento: <?= date("d/m/Y", strtotime($v->data_lancamento)) ?>
                            </p>
                        </div>
                    <?php } ?>
                </div>
                <hr>
                <div class="p-3">
                    <?php
                    require_once('../../back/controllers/NotaFiscalController.php');
                    $new_nf = new NotaFiscalController();
                    $ver_nf = $new_nf->verNF($_GET['idnf']);
                    foreach ($ver_nf as $v) {
                        ?>
                        <form role="form" id="nfform" method="post">
                            <input type="hidden" name="tipo" value="edit">
                            <input type="hidden" name="idnf" value="<?= $_GET['idnf'] ?>">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4" class="font-weight-normal">Número NE/NF</label>
                                    <input type="text" class="form-control" value="<?= $v->numero_nf ?>"
                                           name="numero_nf" id="inputEmail4" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4" class="font-weight-normal">Data de Emissão</label>
                                    <input type="date" class="form-control" value="<?= $v->data_emissao ?>"
                                           name="datae_nf" id="inputEmail4" placeholder="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4" class="font-weight-normal">Data de Lançamento</label>
                                    <input type="date" class="form-control" value="<?= $v->data_lancamento ?>"
                                           name="datal_nf" id="inputPassword4" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputEmail4" class="font-weight-normal">Fornecedor</label>
                                    <select class="form-control" name="fornecedor_nf">
                                        <option value="<?= $v->fornecedor ?>"><?= $v->fornecedor ?></option>
                                        <?php
                                        require_once('../../back/controllers/FornecedorController.php');
                                        $f = new FornecedorController();
                                        $fornecedores = $f->verFornecedores();
                                        foreach ($fornecedores as $listf) {
                                            ?>
                                            <option value="<?= $listf->nome_fornecedor ?>"><?= $listf->nome_fornecedor ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputEmail4" class="font-weight-normal">Valor total dos produtos R$</label>
                                    <input type="text" class="form-control" value="<?= $v->valor_nf ?>"
                                           name="valor_nf" id=""
                                           placeholder="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4" class="font-weight-normal">Desconto</label>
                                    <input type="text" class="form-control" value="<?= $v->desconto ?>"
                                           name="desconto" id=""
                                           placeholder="">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4" class="font-weight-normal">Frete R$</label>
                                    <input type="text" class="form-control"
                                           name="frete" value="<?= $v->frete ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputEmail4" class="font-weight-normal">Valor Total R$</label>
                                    <input type="text" class="form-control"
                                           name="valor_total" value="<?= $v->valor_total ?>">
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-12">
                                    <label class="font-weight-normal" for="exampleFormControlTextarea1">Observação</label>
                                    <textarea class="form-control" name="obs_nf" id="exampleFormControlTextarea1"
                                              rows="3"><?= $v->obs_nf ?></textarea>
                                </div>
                            </div>
                            <div class="form-inline mt-3">
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="radio"
                                           class="form-check-input" <?= ($v->nota_entrega == 0) ? 'checked' : '' ?>
                                           name="info_ne" value="0" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Nota Fiscal</label>
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <input type="radio"
                                           class="form-check-input" <?= ($v->nota_entrega == 1) ? 'checked' : '' ?>
                                           name="info_ne" value="1" id="exampleCheck2">
                                    <label class="form-check-label" for="exampleCheck2">Nota de Entrega</label>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-outline-success col-sm-2 mt-1">
                                Alterar
                            </button>
                            <a href="vencimentos.php?idnf=<?= $_GET['idnf'] ?>"
                            <button class="btn btn-outline-dark float-right">Vencimentos
                                <i class="fas fa-calendar-week"></i>
                            </button>
                            </a>
                            <hr>
                        </form>


                    <?php } ?>

                </div>

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
<script src="editNF.js"></script>
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
