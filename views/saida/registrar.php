<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: login.php");
}
require_once('../../back/controllers/configCRUD.php');
$s = new ConfigCRUD();
require_once('../../back/controllers/EstoqueController.php');
$view_estoque = new EstoqueController();
$all_estoque = $view_estoque->verEstoqueFarmaciaSaida();
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="../../dist/img/logo-single.png" type="image/x-icon">
    <title>g-stock</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
    <div class="content-wrapper mt-3 p-2">
        <div class="card">
            <div class="card-header bg-olive mb-3">
                <?php $date = date_create($_GET['data_s']); ?>
                <h3 class="card-title">Setor: <?= str_replace("-", " ", $_GET['nomesetor']) ?> -
                    Data: <?= date_format($date, 'd/m/Y') ?></h3>
            </div>
            <!-- /.card-header -->
            <form method="POST" action="../../back/response/saidasetor/n_saida_r.php">
                <input type="hidden" name="data_s" value="<?= $_GET['data_s'] ?>">
                <input type="hidden" name="setor_s" value="<?= $_GET['nomesetor'] ?>">
                <input type="hidden" name="user" value="<?= $_SESSION['user'] ?>">
                <div class="card-body table-responsive p-2" style="height: 420px; display: none" id="tabela">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="bg-shadow-it bg-nav">
                        <tr class="text-gray">
                            <th class="">Produto / Meterial</th>
                            <th class="">Quantidade</th>
                            <th class="">Setor</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        <?php foreach ($all_estoque as $value) { ?>
                            <input type="hidden" name="produto_s[]" value="<?= $value->id_estoque ?>">
                            <tr>
                                <td class="text-olive" id="produtonome"><?= $value->produto_e ?></td>
                                <td><input type="number" id="qtedesolicitada" class="form-control text-center"
                                           name="saidaqte_p[]"></td>
                                <td class="text-center"><strong>Em Estoque: <span
                                                id="valorestoque"><?= $value->quantidade_e ?></span></strong>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    <button type="submit" class="btn btn-outline-secondary col-sm-2">Registrar Saída
                    </button>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include('../componentes/footer.php'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/moment/moment.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../dist/js/dataTableCustom.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page script -->

<script>
    $(function () {
        $(document).ready(function () {
            $('#tabela').fadeIn().css("display", "block");
        });
    });
</script>
</body>
</html>
