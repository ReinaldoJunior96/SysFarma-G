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

    <link rel="stylesheet" href="../../dist/css/mycss.css">
</head>
<body class="hold-transition login-page roboto-condensed">
<div class="login-box">

    <!-- /.login-logo -->
    <div class="card">
        <div class="login-logo p-3">
            <img src="../../dist/img/logo-hvu.jpg" width="200" alt="AdminLTE Logo" class="brand-image"
                 style="opacity: .8">
        </div>
        <div class="card-body login-card-body">
            <form method="post" action="../../back/response/user/sessao.php">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Usuário" name="user">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user text-olive"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Senha" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock text-olive"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-outline-success btn-block">Entrar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->

    </div>
    <div class="text-left"  style="opacity: .5">
        <p><img src="../../dist/img/logo-single.png" width="20" class="brand-image">Reinaldo Junior</p>
    </div>

</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

</body>
</html>
