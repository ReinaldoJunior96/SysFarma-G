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
    <link rel="shortcut icon" href="../../dist/img/logo-single.png" type="image/x-icon">
    <title>GStock</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- MeuCSS -->
    <link rel="stylesheet" href="../../dist/css/mycss.css">
</head>
<body class="hold-transition sidebar-mini roboto-condensed">
<div class="wrapper">
    <!-- Navbar -->
    <?php include '../componentes/nav.php'?>
    <!-- /.navbar -->
    <?php include '../componentes/sidebar.php'?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="col-md-12 mt-3">
            <!-- general form elements -->
            <div class="card card-olive">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-people-arrows nav-icon"></i> Fornecedores</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->

                <form role="form" id="fornecedorform" method="post">
                    <input type="hidden" name="new" value="1">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-normal" for="exampleInputEmail1">Nome</label>
                            <input type="text" class="form-control"
                                   placeholder="Qual nome do forncedor?" name="fornecedor" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="font-weight-normal">Telefone</label>
                                    <input type="text" class="form-control" placeholder="Número p/ contato"
                                           name="telefone_fornecedor" id="telefone" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="font-weight-normal">E-mail</label>
                                    <input type="email" class="form-control" placeholder="E-mail p/ contato"
                                           name="email_fornecedor">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="font-weight-normal">CPF/CNPJ</label>
                                    <input type="text" class="form-control" placeholder="Identificação do fornecedor"
                                           name="cnpj_fornecedor" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-normal">Endereço</label>
                            <textarea class="form-control" rows="3" placeholder="Onde ele se localiza?"
                                      name="endereco_fornecedor"></textarea>
                        </div>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-teal col-md-2 elevation-2">Cadastrar</button>
                    </div>
                </form>
                <hr>
                <!-- /.card -->
                <div class="" id="tabela" style="display: none">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr class="bg-teal ">
                                <th class="font-weight-light">Fornecedores Cadastrados</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                require_once '../../back/controllers/FornecedorController.php';
                                $f = new FornecedorController();
                                $fornecedores = $f->listFornecedores();
                                foreach ($fornecedores as $v) {
                                    ?>
                                <tr>
                                    <td class="text-olive"><?=$v->nome_fornecedor?></td>
                                    <td class="text-center">
                                        <a href="edit-fornecedor-view.php?idfornecedor=<?=$v->id_fornecedor?>"><i
                                                    class='fas fa-pen fa-1x color-icon-nf text-green'></i></a>
                                    </td>
                                    <td class="text-center"><a
                                                href="../../back/model/fornecedores/delete-fornecedor.php?idfornecedor=<?=$v->id_fornecedor?>"
                                        <i class="fas fa-window-close text-danger"></i></a>
                                    </td>
                                </tr>
                            <?php }?>
                        </table>
                    </div>
                    <div class="fixed-bottom position-sticky">
                        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                            <div class="alert alert-success alert-dismissible fade show w-25 ml-3" role="alert">
                                <strong>Sucesso!!</strong> Operação realizada.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'fail'): ?>
                            <div class="alert alert-danger alert-dismissible fade show w-25" role="alert">
                                <strong>Erro!</strong> Erro ao realizar operação.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../componentes/footer.php';?>
</div>
<!-- ./wrapper -->


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- DataTable -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../dist/js/dataTableCustom.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- RequestAJAX -->
<script src="../../requests/fornecedores-ajax/post-fornecedores.js"></script>

</body>
</html>
