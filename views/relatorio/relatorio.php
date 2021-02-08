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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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
                    <h3 class="card-title"><i class="fas fa-file-invoice"></i> Relatório
                    </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="GET" action="">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-normal">Setor</label>
                                <select class="form-control select2" name="setor">
                                    <option selected></option>
                                    <option value="todos">Todos os Setores</option>
                                    <?php
                                    require_once('../../back/controllers/configCRUD.php');
                                    $s = new ConfigCRUD();
                                    $setores = $s->ver_setores();
                                    foreach ($setores as $v) {
                                        ?>
                                        <option value="<?= $v->setor_s ?>"><?= str_replace("-", " ", $v->setor_s) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-normal">Data Inicial</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-olive border-0"><i
                                                    class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" data-inputmask-alias="datetime"
                                           data-inputmask-inputformat="dd/mm/yyyy" name="dataI" data-mask>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="font-weight-normal">Data Final</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-olive border-0"><i
                                                    class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" data-inputmask-alias="datetime"
                                           data-inputmask-inputformat="dd/mm/yyyy" name="dataF" data-mask>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-success col-md-2">Gerar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
            <?php if (isset($_GET['setor']) && isset($_GET['dataI']) && isset($_GET['dataF'])): ?>
                <?php $dataI = date_create($_GET['dataI']); ?>
                <?php $dataF = date_create($_GET['dataF']); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Setor: <?= @$_GET['setor'] ?> / Data
                            Inicial: <?= date_format($dataI, "d/m/Y"); ?> / Data
                            Final: <?= date_format($dataF, "d/m/Y"); ?> </h3>
                    </div>
                    <!-- /.card-header -->


                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Produto</th>
                                <th style="width: 40px">Quanitdade</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($_GET['setor']) && isset($_GET['dataI']) && isset($_GET['dataF'])): ?>
                                <?php
                                require_once('../../back/controllers/EstoqueController.php');
                                $produto = new EstoqueController();
                                $todosProdutos = $produto->verEstoqueTotal();
                                if (isset($_GET['setor']) && isset($_GET['dataI']) && isset($_GET['dataF'])):
                                    $seguraItem = array(
                                        'produto' => array(),
                                        'quantidade' => array()
                                    );
                                    foreach ($todosProdutos as $v) {
                                        $soma = 0;
                                        $saidasDoProduto = $produto->relatorioConsumo($_GET['setor'], $_GET['dataI'], $_GET['dataF'], $v->id_estoque);

                                        foreach ($saidasDoProduto as $s) {
                                            $soma += $s->quantidade_s;
                                        }
                                        if ($soma != 0):
                                            array_push($seguraItem['produto'], $v->produto_e);
                                            array_push($seguraItem['quantidade'], $soma);
                                        endif;


                                    }
                                    for ($i = 0;
                                         $i < count($seguraItem['produto']);
                                         $i++):
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $seguraItem['produto'][$i] ?></td>
                                            <td class="bg-olive text-white text-center"><?= $seguraItem['quantidade'][$i] ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <?php include('../componentes/footer.php'); ?>
</div>
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
<!-- Page script -->
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
