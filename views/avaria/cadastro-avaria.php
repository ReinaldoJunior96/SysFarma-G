<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../usuario/login.php");
}
require_once('../../back/controllers/EstoqueController.php');
$estoqueClass = new EstoqueController();
$produtos = $estoqueClass->verEstoqueTotal();

require_once('../../back/controllers/AvariaController.php');
$avariaClass = new AvariaController();
$produtosAvariados = $avariaClass->listPA();
function text_limiter_caracter($str, $limit, $suffix = '...')
{

    if (strlen($str) <= $limit) return $str;
    $limit = strpos($str, ' ', $limit);
    return substr($str, 0, $limit + 1) . $suffix;

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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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
                    <h3 class="card-title"><i class="fas fa-dumpster-fire nav-icon"></i> Avaria & Vencidos </h3>
                </div>
                <form role="form" id="avariaform" method="POST" action="../../back/response/avaria/post-avaria.php">
                    <input type="hidden" value="<?= $_SESSION['usuario'] ?>" name="usuario">
                    <div class="card-body">
                        <div class="form-group col-md-12 mx-auto">
                            <label class="font-weight-normal">Produtos</label>
                            <select class="form-control select2 col-md-12" name="produtoavaria" required>
                                <option selected></option>
                                <?php foreach ($produtos as $values): ?>
                                    <option value="<?= $values->id_estoque ?>"><?= $values->produto_e ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4" class="font-weight-normal">Quantidade</label>
                                <input type="number" class="form-control"
                                       name="quantidadeavaria" id="inputEmail4" placeholder="" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="font-weight-normal">Lote</label>
                                <input type="text" class="form-control"
                                       name="loteavaria" id="inputPassword4" placeholder="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4" class="font-weight-normal">Validade</label>
                                <input type="date" class="form-control"
                                       name="validadeavaria" id="inputPassword4" placeholder="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                <label class="font-weight-normal" for="exampleFormControlTextarea1">Observação</label>
                                <textarea class="form-control" name="obsavaria" id="exampleFormControlTextarea1"
                                          rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 w-100 bd-highlight">
                                <button type="submit" class="btn bg-gradient-teal col-md-2 elevation-2">Cadastrar
                                </button>

                            </div>
                            <div class="p-2 flex-shrink-1 bd-highlight">
                                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sucesso!!</strong> Avaria Registrada.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'fail'): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Erro!</strong> Quantidade avariada é maior que a quantidade existente no
                                        sistema.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                </form>

                <hr>
                <div class="p-3" id="tabela">
                    <table id="example1" class="table table-bordered table-striped text-olive">
                        <thead>
                        <tr>
                            <td class="bg-teal">Produto</td>
                            <td class="bg-teal">Quantidade</td>
                            <td class="bg-teal">Lote</td>
                            <td class="bg-teal">Vencimento</td>
                            <td class="bg-teal">Observação</td>
                            <td class="bg-teal"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($produtosAvariados as $v) {
                            ?>
                            <tr>
                                <td class="font-weight-lighter"><?= $v->produto_e ?></td>
                                <td class="font-weight-lighter"><?= $v->quantidade_avaria ?></td>
                                <td class="font-weight-lighter"><?= $v->lote_avaria ?></td>
                                <td class="font-weight-lighter"><?= $v->vencimento_avaria ?></td>
                                <td class="font-weight-lighter"><?= text_limiter_caracter($v->obs_avaria, 30) ?></td>
                                <td class="text-center"><a
                                            href=../../back/response/avaria/delete-avaria.php?usuario=<?= $_SESSION['usuario'] ?>&avaria=<?= $v->id_avaria ?>><i
                                                class="fas fa-minus-circle text-danger"></i></a></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include('../componentes/footer.php'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

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
