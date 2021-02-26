<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../user/login.php");
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

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
            <?php if (isset($_GET['status'])): ?>
                <div class="alert alert-success" role="alert">
                    Sucesso! Devolução realizada.
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header bg-olive">
                    <h3 class="card-title"><i class="fas fa-share-alt-square"></i> Histórico de Saída</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="form-group row">
                            <label>Setor</label>
                            <div class="col-sm-5">
                                <select class="form-control select2" name="filtro" id="exampleFormControlSelect1"
                                        onChange="this.form.submit()">
                                    <option selected></option>
                                    <?php
                                    include_once '../../back/controllers/setoresController.php';
                                    $s = new SetorController();
                                    $setores = $s->verSetores();
                                    foreach ($setores as $values) {
                                        ?>
                                        <option value="<?= $values->setor_s ?>"><?= str_replace("-", " ", $values->setor_s) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                    </form>

                    <div class="p-2" id="tabela" style="display: none">
                        <div class="" id="tabela">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="bg-shadow-it bg-nav">
                                <tr class="bg-teal">
                                    <th class="">Produto / Meterial</th>
                                    <th class="">Quantidade</th>
                                    <th class="">Setor</th>
                                    <th class="">Data / Hora</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                require_once('../../back/controllers/EstoqueController.php');
                                $view_historico = new EstoqueController();
                                $historico = 0;
                                if (empty($_GET['filtro'])) {
                                    $historico = $view_historico->historicoSaida();
                                } elseif (!empty($_GET['filtro'])) {
                                    $historico = $view_historico->filtroHistorico($_GET['filtro']);
                                }
                                foreach ($historico as $v) {
                                    ?>
                                    <tr class="">
                                        <td><?= $v->produto_e ?></td>
                                        <td><?= $v->quantidade_s ?></td>
                                        <td><?= str_replace("-", " ", $v->setor_s) ?></td>
                                        <td><?= ($v->data_s == '0000-00-00 00:00:00') ? date("d/m/Y H:i:s", strtotime($v->data_dia_s)) : date("d/m/Y H:i:s", strtotime($v->data_s)) ?></td>
                                        <td class="text-center"><a href=registrar-devolucao.php?idsaida=<?= $v->id_saida ?>><i
                                                        class="fas fa-exchange-alt text-teal"></i></a></td>
                                        <?php echo "<td class='text-center'><a href=../../back/response/saidasetor/d_saida_r.php?idsaida=" . $v->id_saida . "&prod=" . $v->item_s . "&qtde=" . $v->quantidade_s . "&user=" . $_SESSION['user'] . "><i class='fas fa-backspace text-danger'></i></a></td>" ?>

                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

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
