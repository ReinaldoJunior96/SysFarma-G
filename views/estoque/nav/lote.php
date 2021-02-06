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
                    <span>Usuário: <?=$_SESSION['user']?></span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <?php include('sidebarestoque.php')?>


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
                    <!-- /.card-header -->
                    <!-- form start -->
                    <ul class="nav nav-tabs mt-2">
                        <li class="nav-item">
                            <a class="nav-link text-olive" href="editEstoque.php?idp=<?= $_GET['idp'] ?>">Infomações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-olive active" href="lote.php?idp=<?= $_GET['idp'] ?>">Lote / Validade</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-olive" href="fornecedores.php?idp=<?= $_GET['idp'] ?>">Fornecedores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-olive" href="compras.php?idp=<?= $_GET['idp'] ?>">Compras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-olive" href="transacoes.php?idp=<?= $_GET['idp'] ?>">Transações</a>
                        </li>
                    </ul>
                    <div class="mt-3 p-3">
                        <table id="example1" class="table table-bordered table-striped text-olive">
                            <thead>
                            <tr>
                                <th scope="col">Lote</th>
                                <th scope="col">Validade</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $lotes = new EstoqueController();
                            $histLotes = $lotes->historicoLote($_GET['idp']);
                            foreach ($histLotes as $lotes):
                                $data = date_create($lotes->validade)
                                ?>
                                <tr>
                                    <td><?= $lotes->lote ?></td>
                                    <td><?= date_format($data, 'd/m/Y') ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                <?php } ?>
            </div>

        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include('../../componentes/footer.php'); ?>
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
<script src="../../../dist/js/myjs.js"></script>
</body>
</html>
