<?php
session_start();
if ($_SESSION['usuario'] == null || $_SESSION['password'] == null) {
    header("location: ../usuario/login.php");
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

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../dist/css/mycss.css">
    <style>
        #tabela {
            display: none;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini roboto-condensed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include '../componentes-exames/nav.php'?>
    <!-- /.navbar -->
    <?php include '../componentes-exames/sidebar.php'?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="col-md-12 mt-3">
            <!-- general form elements -->
                <div class="card card-olive">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-notes-medical"></i>
                            Cadastro de Exames Anatapatológicos
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <!--<form role="form" id="cadastro-anatomo" method="post" enctype="multipart/form-data">-->
                    <form role="form" method="post" action="../../../back/response/exame/anatomopatologia/post-exame.php" enctype="multipart/form-data">
                        <input type="hidden" name="usuario" value="<?=$_SESSION['usuario']?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Nome Animal</label>
                                    <input type="text" name="n_animal" class="form-control" id="inputEmail3">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-normal"  for="exampleInputEmail1">Nome Proprietário</label>
                                    <input type='text' class='form-control' name='n_proprietario' placeholder='' required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-normal"  for="exampleInputEmail1">Raça</label>
                                    <input type='text' class='form-control ' name='raca' placeholder=''>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-normal"  for="exampleInputEmail1">Entrada da Amostra</label>
                                    <input type="date" class="form-control" name="data_amostra" id="inputEmail4"
                                           placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-normal"  for="exampleInputEmail1">Código Identificação</label>
                                    <input type="text" class="form-control" name="cod_anatomo" id="inputEmail4"
                                           placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="avatar">Insira o exame em pdf</label><br>
                                    <input type="file" accept=".pdf" name="examepdf[]" multiple="multiple">
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn bg-gradient-teal col-md-2 elevation-2">Enviar</button>
                        </div>
                    </form>
                </div>
            <!-- /.card -->

        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include '../componentes-exames/footer.php';?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
<script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../../dist/js/dataTableCustom.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- RequestAJAX -->
<script src="../../../requests/exames-ajax/post-exames.js"></script>
</body>
</html>
