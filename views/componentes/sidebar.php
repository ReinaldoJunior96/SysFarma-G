<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-info elevation-2">
    <!-- Brand Logo -->
    <a href="../user/dashboard.php" class="brand-link">
        <img src="../../dist/img/logo-single-branco.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
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
                <?php if ($_SESSION['user'] == 'compras.hvu' or $_SESSION['user'] == 'admin'): ?>
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
                                <a href="../ordem/compra.php" class="nav-link">
                                    <i class="fas fa-shopping-bag nav-icon"></i>
                                    <p>Ordem de compra</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../notaFiscal/notaF.php" class="nav-link">
                                    <i class="far fa-file-alt nav-icon"></i>
                                    <p>Nota Fiscal</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="nav-item has-treeview">
                    <a href="../estoque" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Estoque
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../estoque/farmacia.php" class="nav-link">
                                <i class="fas fa-prescription-bottle-alt nav-icon"></i>
                                <p>Fármacia</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../estoque/almoxarifado.php" class="nav-link">
                                <i class="fas fa-box-open nav-icon"></i>
                                <p>Almoxarifado</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="../saida/iniciar.php" class="nav-link">
                        <i class="fas fa-bezier-curve nav-icon"></i>
                        <p>Saída</p>
                    </a>
                </li>
                <?php if ($_SESSION['user'] == 'compras.hvu' or $_SESSION['user'] == 'admin'): ?>
                    <li class="nav-item">
                        <a href="../fornecedor/fornecedores.php" class="nav-link">
                            <i class="fas fa-people-arrows nav-icon"></i>
                            <p>Fornecedores</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="../setor/setores.php" class="nav-link">
                        <i class="fas fa-share-alt-square nav-icon"></i>
                        <p>Setores</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-import"></i>
                        <p>
                            Relatórios
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../relatorio/estoquefarma.php" class="nav-link">
                                <i class="fas fa-notes-medical"></i>
                                <p>Estoque Farmácia</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../relatorio/estoquealmoxarifado.php" class="nav-link">
                                <i class="fas fa-inbox"></i>
                                <p>Estoque Almoxarifado</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../relatorio/relatorio.php" class="nav-link">
                                <i class="fas fa-file-export"></i>
                                <p>Consumo</p>
                            </a>
                        </li>
                    </ul>
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