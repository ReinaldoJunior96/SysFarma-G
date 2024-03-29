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
                                        Emissão:  <?= date("d/m/Y", strtotime($v->data_emissao)) ?>
                                    <br>
                                    Data de Lançamento:  <?= date("d/m/Y", strtotime($v->data_lancamento)) ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-left">
                        <a href="cadastro-lote.php?idnf=<?= $_GET['idnf'] ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-calendar-day"></i> Lotes & Validades
                        </a>
                        <?php
                        require_once('../../back/controllers/NotaFiscalController.php');
                        $n = new NotaFiscalController();
                        $attNota = $n->verificarStatusNF($_GET['idnf']);
                        if ($attNota >= 1) {
                            $text = "Adicione a quantidade comprada ao estoque";
                            $class = "";
                            $link = "../../back/model/ordem-compra/import-prod-estoque.php?idnf=" . $_GET['idnf'];
                        } else {
                            $text = "Quantidade já foi lançada";
                            $class = "disabled";
                            $link = "#";
                        }
                        ?>
                        <div class="float-right">
                            <?= $text ?>
                            <a href="<?= $link ?>" class="btn btn-sm bg-teal <?= $class ?>">
                                <i class="fas fa-calendar-day"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.card -->
            <div class="card" id="tabela" style="display: none">
                <div class="card-header bg-olive">
                    <h3 class="card-title">Produtos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr class="text-gray">
                            <th class="">Produto / Material</th>
                            <th class="">Quantidade</th>
                            <th class="">Valor Unitário</th>
                            <th class="">Valor Total</th>
                        </tr>
                        </thead>
                        <tbody class="text-olive">
                        <?php
                        require_once('../../back/controllers/NotaFiscalController.php');
                        $nf = new NotaFiscalController();
                        $ver_nf = $nf->listProdNF($_GET['idnf']);
                        foreach ($ver_nf as $v) {
                            ?>
                            <tr>
                                <td><?= $v->produto_e ?></td>
                                <td><?= $v->qtde_compra ?></td>
                                <td>R$ <?= $v->valor_un_c ?></td>
                                <td>R$ <?= $v->qtde_compra * $v->valor_un_c ?></td>
                                <!--                                    --><?php //echo "<td><a href=../../back/response/notaf/delete-prod-nf.php?id_prod_nf=" . $v->id_itens . "&item_estoque=" . $v->item_nf . "&qtde_nf=" . $v->qtde_nf . "><i class='fas fa-trash text-danger'></i></a></td>" ?>
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
