<?php
session_start();
if ($_SESSION['user'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../../user/login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="../../../dist/img/logo-single.png" type="image/x-icon">
    <title>g-stock</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../../dist/css/mycss.css">
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
                    <span>Usuário: <?= $_SESSION['user'] ?></span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-2">
        <!-- Brand Logo -->
        <a disabled="" class="brand-link">
            <img src="../../../dist/img/logo-single-branco.png" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light text-white">G-Stock</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <?php if ($_SESSION['user'] == 'compras.hvu' OR $_SESSION['user'] == 'admin'): ?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-truck-loading nav-icon"></i>
                                <p>
                                    Entrada
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../../ordem/compra.php" class="nav-link">
                                        <i class="fas fa-shopping-bag nav-icon"></i>
                                        <p>Ordem de compra</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../../notaFiscal/notaF.php" class="nav-link">
                                        <i class="far fa-file-alt nav-icon"></i>
                                        <p>Nota Fiscal</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                Estoque
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../farmacia.php" class="nav-link">
                                    <i class="fas fa-prescription-bottle-alt nav-icon"></i>
                                    <p>Fármacia</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../almoxarifado.php" class="nav-link">
                                    <i class="fas fa-box-open nav-icon"></i>
                                    <p>Almoxarifado</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="../../saida/iniciar.php" class="nav-link">
                            <i class="fas fa-bezier-curve nav-icon"></i>
                            <p>Saída</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../relatorio/relatorio.php" class="nav-link">
                            <i class="fas fa-file-invoice nav-icon"></i>
                            <p>Relatório</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../setor/setores.php" class="nav-link">
                            <i class="fas fa-share-alt-square nav-icon"></i>
                            <p>Setores</p>
                        </a>
                    </li>
                    <?php if ($_SESSION['user'] == 'compras.hvu' OR $_SESSION['user'] == 'admin'): ?>
                        <li class="nav-item">
                            <a href="../../fornecedor/fornecedores.php" class="nav-link">
                                <i class="fas fa-people-arrows nav-icon"></i>
                                <p>Fornecedores</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="../../../back/response/user/destroy_sessao.php" class="nav-link">
                            <i class="fas fa-power-off nav-icon"></i>
                            <p>Sair</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="col-md-12 mt-3">
            <!-- general form elements -->
            <div class="card card-olive">
                <?php
                require_once '../../../back/controllers/EstoqueController.php';
                $p = new EstoqueController();
                $produtos = $p->estoqueID($_GET['idp']);
                foreach ($produtos as $v) {
                    ?>
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i>
                            Produto: <?= $v->produto_e ?>
                        </h3>
                    </div>
                <?php } ?>
                <!-- /.card-header -->
                <!-- form start -->
                <ul class="nav nav-tabs mt-2">
                    <li class="nav-item">
                        <a class="nav-link text-olive" href="editEstoque.php?idp=<?= $_GET['idp'] ?>">Infomações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-olive " href="lote.php?idp=<?= $_GET['idp'] ?>">Lote / Validade</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-olive active" href="fornecedores.php?idp=<?= $_GET['idp'] ?>">Fornecedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-olive" href="compras.php?idp=<?= $_GET['idp'] ?>">Compras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-olive" href="transacoes.php?idp=<?= $_GET['idp'] ?>">Transações</a>
                    </li>
                </ul>

                <form role="form" method="POST" action="../../../back/response/estoque/n_prod_fornecedor.php">
                    <input type="hidden" value="<?= $_GET['idp'] ?>" name="produto">
                    <div class="card-body">
                        <?php if ($_SESSION['user'] == 'compras.hvu' or $_SESSION['user'] == 'admin'): ?>
                        <div class="row">
                            <div class="form-group col-md-9">
                                <label class="font-weight-normal">Fornecedor</label>
                                <select class="form-control select2" name="fornecedor">
                                    <option selected></option>
                                    <?php
                                    require_once('../../../back/controllers/FornecedorController.php');
                                    $f = new FornecedorController();
                                    $fornecedores = $f->verFornecedores();
                                    foreach ($fornecedores as $listf) {
                                        ?>
                                        <option value="<?= $listf->id_fornecedor ?>"><?= $listf->nome_fornecedor ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-success col-md-2">Cadastrar</button>
                    </div>
                    <?php endif; ?>
                </form>

                <?php if ($_SESSION['user'] == 'compras.hvu' or $_SESSION['user'] == 'admin'): ?>
                    <div class="mt-3 p-3">
                        <?php
                        require_once('../../../back/controllers/EstoqueController.php');
                        $forProdutor = new EstoqueController();
                        $for = $forProdutor->searchFornecedorProduto($_GET['idp']);

                        foreach ($for as $value) {
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-olive">
                                <?= $value->nome_fornecedor ?>
                                <a href="../../../back/response/estoque/d_fornecedor_prod.php?idpf=<?= $value->idfp ?>">
                                    <span class="badge badge-pill far fa-window-close text-danger float-right"> </span>
                                </a>
                            </li>
                        <?php } ?>
                    </div>
                <?php endif; ?>


            </div>

        </div>
    </div>
    <!-- /.content-wrapper -->
    <?php include('../../componentes/footer.php'); ?>
</div>
<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../../plugins/moment/moment.min.js"></script>
<script src="../../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../dist/js/demo.js"></script>
<!-- Page script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function (event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })
</script>
</body>
</html>
