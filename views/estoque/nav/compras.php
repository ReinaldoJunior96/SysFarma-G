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
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-2">
        <!-- Brand Logo -->
        <a disabled="" class="brand-link">
            <img src="../../../dist/img/logo-single-branco.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
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
                    <li class="nav-item">
                        <a href="../../fornecedor/fornecedores.php" class="nav-link">
                            <i class="fas fa-people-arrows nav-icon"></i>
                            <p>Fornecedores</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../back/response/user/destroy_sessao.php" class="nav-link">
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
            <div class="card card-primary">
                <?php
                require_once '../../../back/controllers/EstoqueController.php';
                $p = new EstoqueController();
                $produtos = $p->estoqueID($_GET['idp']);
                foreach ($produtos as $v) {
                    ?>
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-invoice"></i>
                            Produto: <?= $v->produto_e ?>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <ul class="nav nav-tabs mt-2">
                        <li class="nav-item">
                            <a class="nav-link " href="editEstoque.php?idp=<?= $_GET['idp'] ?>">Infomações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="lote.php?idp=<?= $_GET['idp'] ?>">Lote / Validade</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="fornecedores.php?idp=<?= $_GET['idp'] ?>">Fornecedores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="compras.php?idp=<?= $_GET['idp'] ?>">Compras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="transacoes.php?idp=<?= $_GET['idp'] ?>">Transações</a>
                        </li>
                    </ul>
                    <div class="mt-3 p-3">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Ordem</th>
                                <th scope="col">Emissão</th>
                                <th scope="col">Fornecedor</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Valor Un</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            require_once '../../../back/controllers/EstoqueController.php';
                            $p = new EstoqueController();
                            $hist = $p->historicoProd($_GET['idp']);
                            foreach ($hist as $historico) {
                                $data = date_create($historico->data_emissao)
                                ?>
                                <tr>
                                    <th scope="row"><a
                                                href="../../notafiscal/produtosnf.php?idnf=<?= $historico->id_nf ?>"><?= $historico->numero_nf ?></a>
                                    </th>
                                    <td><?= date_format($data, 'd/m/Y') ?></td>
                                    <td><?= $historico->fornecedor ?></td>
                                    <td><?= $historico->qtde_compra ?></td>
                                    <td><?= 'R$ ' . number_format($historico->valor_un_c, '2', ',', '') ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                <?php } ?>
            </div>

        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include('../componentes/footer.php'); ?>
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
