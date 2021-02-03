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
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a disabled="" class="nav-link"></a>
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
    <?php include('../componentes/sidebar.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper p-3">
        <div class="col-md-12 mt-3">
            <!-- general form elements -->
            <?php if (isset($_GET['status'])): ?>
                <div class="alert alert-success" role="alert">
                    Sucesso! Devolução realizada.
                </div>
            <?php endif; ?>
            <div class="card card-olive">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-share-alt-square"></i> Histórico de Saída</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="p-4">
                    <form method="GET" action="">
                        <div class="form-group row">
                            <label>Setor</label>
                            <div class="col-sm-5">
                                <select class="form-control select2" name="filtro" id="exampleFormControlSelect1"
                                        onChange="this.form.submit()">
                                    <
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
                    </form>

                </div>
                <hr>
                <!-- /.card -->
                <div class="p-2" id="tabela" style="display: none">
                    <div class="" id="tabela">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="bg-shadow-it bg-nav">
                            <tr class="">
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
                                    <td class="text-center"><a href=devolucao.php?idsaida=<?= $v->id_saida ?>><i
                                                    class="fas fa-exchange-alt text-teal"></i></a></td>
                                    <?php echo "<td class='text-center'><a href=../../back/response/saidasetor/d_saida_r.php?idsaida=" . $v->id_saida . "&prod=" . $v->item_s . "&qtde=" . $v->quantidade_s . "&user=" . $_SESSION['user'] . "><i class='fas fa-backspace text-danger'></i></a></td>" ?>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
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
