<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-olive">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown ">
            <a class="nav-link text-white" data-toggle="dropdown" href="#">
                <i class="fas fa-user"></i>
                <span>Usuário: <?= $_SESSION['user'] ?></span>
            </a>
        </li>
    </ul>
</nav>