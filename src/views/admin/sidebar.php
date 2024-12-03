<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="../../../public/css/sidebar2.css">
    <!-- Agregar Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <!-- Botón de menú -->
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>

        <!-- Logo -->
        <div class="logo">
            <img src="../../../public/img/logo/logo_azul.jpg" alt="Logo">
        </div>

        <!-- Perfil -->
        <div class="profile">
            <img src="../../../public/img/profile/usuario.png" alt="Perfil">
            <p>Administrador</p>
        </div>

        <!-- Menú -->
        <ul class="menu">
            <li>
                <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>&nbspDashboard</span></a>
            </li>
            <li>
                <a href="#usuarios" class="menudesplegable-btn"><i class="fas fa-users"></i><span>&nbspUsuarios</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="agregar_personal.php"><i class="fas fa-user-plus"></i><span>&nbspAgregar Usuario</span></a></li>
                    <li><a href="personal.php"><i class="fas fa-user-edit"></i><span>&nbspGestionar Usuario</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#productos" class="menudesplegable-btn"><i class="fas fa-boxes"></i><span>&nbspProductos</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="agregar_productos.php"><i class="fas fa-box"></i><span>&nbspAgregar Productos</span></a></li>
                    <li><a href="ver_productos.php"><i class="fas fa-clipboard-list"></i><span>&nbspGestionar Productos</span></a></li>
                    <li><a href="ver_productos.php"><i class="fas fa-search"></i><span>&nbspBuscar Productos</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#stock" class="menudesplegable-btn"><i class="fas fa-warehouse"></i><span>&nbspStock</span></a>
                <ul class="menudesplegable-content">
                    
                    <li><a href="producto_vencido.php"><i class="fas fa-times-circle"></i><span>&nbspProductos Vencidos</span></a></li>
                    <li><a href="producto_novencido.php"><i class="fas fa-check-circle"></i><span>&nbspProductos No Vencidos</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#proveedores" class="menudesplegable-btn"><i class="fas fa-truck"></i><span>&nbspProveedores</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="crear_proveedor.php"><i class="fas fa-user-tie"></i><span>&nbspAgregar Proveedores</span></a></li>
                    <li><a href="mostrar_proveedores.php"><i class="fas fa-clipboard-check"></i><span>&nbspGestionar Proveedores</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#categorias" class="menudesplegable-btn"><i class="fas fa-tags"></i><span>&nbspCategorías</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="crear_categoria.php"><i class="fas fa-tag"></i><span>&nbspAgregar Categorías</span></a></li>
                    <li><a href="mostrar_categorias.php"><i class="fas fa-edit"></i><span>&nbspGestionar Categorías</span></a></li>
                </ul>
            </li>
        
            <li>
                <a href="#facturas" class="menudesplegable-btn"><i class="fas fa-file-invoice"></i><span>&nbspFacturas</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="agregar_facturas.php"><i class="fas fa-plus"></i><span>&nbspAgregar Facturas</span></a></li>
                    <li><a href="gestionar_facturas.php"><i class="fas fa-edit"></i><span>&nbspGestionar Facturas</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#reportes" class="menudesplegable-btn"><i class="fas fa-chart-pie"></i><span>&nbspReportes</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="reporte-ventas.php"><i class="fas fa-chart-line"></i><span>&nbspReporte Ventas</span></a></li>
                    <li><a href="reporte-productos.php"><i class="fas fa-clipboard-list"></i><span>&nbspReporte Productos</span></a></li>
                    <li><a href="reporte-stock.php"><i class="fas fa-boxes"></i><span>&nbspReporte Stock</span></a></li>
                    <li><a href="reporte-clientes.php"><i class="fas fa-user-check"></i><span>&nbspReporte Clientes</span></a></li>
                    <li><a href="reporte-categorias.php"><i class="fas fa-tag"></i><span>&nbspReporte Categorías</span></a></li>
                    <li><a href="reporte-usuarios.php"><i class="fas fa-users-cog"></i><span>&nbspReporte Usuarios</span></a></li>
                </ul>
            </li>
        </ul>
    </div>

    <script>
        // Funcionalidad del botón de menú
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // menudesplegable functionality
        document.querySelectorAll('.menudesplegable-btn').forEach(button => {
            button.addEventListener('click', () => {
                const menudesplegableContent = button.nextElementSibling;
                menudesplegableContent.classList.toggle('show');
            });
        });

        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar_c1').classList.toggle('collapsed');
        });
    </script>
</body>
</html>

