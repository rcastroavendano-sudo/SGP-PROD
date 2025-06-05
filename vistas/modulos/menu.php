<?php
    $isSuperAdmin = (isset($_SESSION['perfil']) && strcasecmp($_SESSION['perfil'], 'SuperAdministrador') == 0);
    $isAdmin = (isset($_SESSION['perfil']) && strcasecmp($_SESSION['perfil'], 'Administrador') == 0);
?>

<aside class="main-sidebar">
    <!-- Sección de la barra lateral -->
    <section class="sidebar">
        <!-- Lista de menús de la barra lateral -->
        <ul class="sidebar-menu">
            
            <!-- Menú desplegable para la gestión de proveedores -->
            <li class="treeview">
                <a href="#">
                    <!-- Icono de usuario -->
                    <i class="fa fa-user"></i>
                    <span>Gestión Proveedor</span>
                    <!-- Contenedor para el icono de la flecha que indica un menú desplegable -->
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <!-- Submenú desplegable de gestión de proveedores -->
                <ul class="treeview-menu">
                    <!-- Opción activa: Proveedores -->
                    <li class="active">
                        <a href="proveedores">
                            <i class="fa fa-circle-o"></i>
                            <span>Proveedores</span>
                        </a>
                    </li>
                    <!-- Opción: Marcas -->
                    <li>
                        <a href="marcas">
                            <i class="fa fa-circle-o"></i>
                            <span>Marcas</span>
                        </a>
                    </li>
                    <!-- Opción: Empresas -->
                    <li>
                        <a href="empresas">
                            <i class="fa fa-circle-o"></i>
                            <span>Empresas</span>
                        </a>
                    </li>
                </ul>
            </li>
            

            <?php if ($isSuperAdmin): ?>
            <!-- Opción: Usuarios (solo visible para el superadministrador (YO)) -->
            <li>
                <a href="usuarios">
                    <i class="fa fa-user-secret"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </section>
</aside>
