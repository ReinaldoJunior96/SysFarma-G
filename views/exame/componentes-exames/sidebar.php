<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-info elevation-2">
    <!-- Brand Logo -->
    <a href="../usuario/dashboard.php" class="brand-link">
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
                    <i class="fas fa-vials"></i>
                        <p>
                            Patologia Clínica
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../patologia/cadastro.php" class="nav-link">
                                <i class="fas fa-prescription-bottle-alt nav-icon"></i>
                                <p>Cadastro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../patologia/buscar.php" class="nav-link">
                            <i class="fas fa-search nav-icon"></i>
                                <p>Buscar</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                    <i class="fas fa-toolbox"></i>
                        <p>
                        Anatomopatologia
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../anatomopatologia/cadastro.php" class="nav-link">
                                <i class="fas fa-notes-medical  nav-icon"></i>
                                <p>Cadastro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../anatomopatologia/buscar.php" class="nav-link">
                            <i class="fas fa-search nav-icon"></i>
                                <p>Buscar</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="../../back/response/usuario/destruir-sessao.php" class="nav-link">
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