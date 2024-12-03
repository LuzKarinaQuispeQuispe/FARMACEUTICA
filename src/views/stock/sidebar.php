<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar - Empleado de Ventas</title>
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
            <p>Empleado de Ventas</p>
        </div>

        <!-- Menú -->
        <ul class="menu">
            <li>
                <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>&nbspDashboard</span></a>
            </li>
            <li>
                <a href="#productos" class="menudesplegable-btn"><i class="fas fa-boxes"></i><span>&nbspProductos</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="agregar_productos.php"><i class="fas fa-search"></i><span>&Gestionar Productos</span></a></li>
                    <li><a href="ver_productos.php"><i class="fas fa-eye"></i><span>&nbsp Ver Productos</span></a></li>
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
                <a href="#proveedores" class="menudesplegable-btn"><i class="fas fa-address-book"></i><span>&nbspproveedores</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="crear_proveedor.php"><i class="fas fa-user-plus"></i><span>&nbspAgregar proveedores</span></a></li>
                    <li><a href="mostrar_proveedores.php"><i class="fas fa-user-cog"></i><span>&nbspGestionar proveedores</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#reportes" class="menudesplegable-btn"><i class="fas fa-chart-pie"></i><span>&nbspReportes</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="reporte-productos.php"><i class="fas fa-file-invoice-dollar"></i><span>&nbspReporte de Productos</span></a></li>
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

        // Funcionalidad de menús desplegables
        document.querySelectorAll('.menudesplegable-btn').forEach(button => {
            button.addEventListener('click', () => {
                const menudesplegableContent = button.nextElementSibling;
                menudesplegableContent.classList.toggle('show');
            });
        });
    </script>
</body>
</html>


