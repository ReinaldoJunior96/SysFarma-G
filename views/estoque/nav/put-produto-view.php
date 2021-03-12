<?php
session_start();
if ($_SESSION['usuario'] == NULL || $_SESSION['password'] == NULL) {
    header("location: ../../usuario/login.php");
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
                    <span>Usuário: <?=$_SESSION['usuario']?></span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <?php include('menu-estoque.php') ?>


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
                            <a class="nav-link active text-olive" href="put-produto-view.php?idp=<?= $_GET['idp'] ?>">Infomações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-olive" href="lote-produto.php?idp=<?= $_GET['idp'] ?>">Lote / Validade</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-olive" href="fornecedores-produto.php?idp=<?= $_GET['idp'] ?>">Fornecedores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-olive" href="historico-compra-produto.php?idp=<?= $_GET['idp'] ?>">Compras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-olive" href="transacao-produto.php?idp=<?= $_GET['idp'] ?>">Transações</a>
                        </li>
                    </ul>

                    <form role="form" id="estoqueform" method="post">
                        <input type="hidden" name="edit" value="1">
                        <input type="hidden" name="usuario" value="<?= $_SESSION['usuario'] ?>">
                        <input type="hidden" name="id" value="<?= $_GET['idp'] ?>">

                        <div class="card-body">
                    <?php if ($_SESSION['usuario'] == 'compras.hvu' or $_SESSION['usuario'] == 'admin'): ?>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Principio Ativo</label>
                                    <?php if ($v->tipo == '0') { ?>
                                        <input type="text" name="p_ativo" value="<?= $v->principio_ativo ?>"
                                               class="form-control" id="inputEmail3">
                                    <?php } else { ?>
                                        <input type="text" name="p_ativo" value="<?= $v->principio_ativo ?>"
                                               class="form-control" id="inputEmail3" disabled>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Nome Comercial</label>
                                    <input type='text' class='form-control' value="<?= $v->produto_e ?>"
                                           name='produto_e' placeholder=''>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Apresentação</label>
                                    <input type='text' class='form-control' value="<?= $v->apresentacao ?>"
                                           name='apresentacao' placeholder=''>
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Forma Farmacêutica</label>
                                    <?php if ($v->tipo == '0') { ?>
                                        <input type="text" class="form-control" value="<?= $v->forma_farmaceutica ?>"
                                               name="forma_farmaceutica" id="inputEmail4"
                                               placeholder="">
                                    <?php } else { ?>
                                        <input type="text" class="form-control" value="<?= $v->forma_farmaceutica ?>"
                                               name="forma_farmaceutica" id="inputEmail4"
                                               placeholder="" disabled>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Concentração</label>
                                    <?php if ($v->tipo == '0') { ?>
                                        <input type="text" class="form-control" name="concentracao" id="inputEmail4"
                                               placeholder="">
                                    <?php } else { ?>
                                        <input type="text" class="form-control" name="concentracao" id="inputEmail4"
                                               placeholder="" disabled>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Estoque Mínimo</label>
                                    <input type="number" class="form-control" value="<?= $v->estoque_minimo_e ?>"
                                           name="estoque_minimo_e" id="inputEmail4"
                                           placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Quantidade</label>
                                        <input type="number" class="form-control" value="<?= $v->quantidade_e ?>"
                                               name="quantidade_e" id="inputEmail4">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-normal" for="exampleInputEmail1">Valor Unitário (R$)</label>
                                        <input type='text' class='form-control' value="<?= $v->valor_un_e ?>"
                                               name='valor_un' placeholder='R$'>
                                        <small class="roboto-condensed">Ex: 24.23 / 1253.65 / 14256.25</small>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-outline-success col-md-2">Alterar</button>
                        </div>
                    </form>
                    <?php endif; ?>
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
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- RequestAJAX -->
<script src="../../../requests/produtos-ajax/put-produtos.js"></script>
</body>
</html>
