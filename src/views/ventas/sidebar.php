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
                <a href="#ventas" class="menudesplegable-btn"><i class="fas fa-shopping-cart"></i><span>&nbspVentas</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="agregar_facturas.php"><i class="fas fa-cash-register"></i><span>&nbspRealizar Ventas</span></a></li>
                    <li><a href="gestionar_facturas.php"><i class="fas fa-edit"></i><span>&nbspGestionar Ventas</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#productos" class="menudesplegable-btn"><i class="fas fa-boxes"></i><span>&nbspProductos</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="ver_productos.php"><i class="fas fa-eye"></i><span>&nbspVer Productos</span></a></li>
                </ul>
            </li>
        
            <li>
                <a href="#reportes" class="menudesplegable-btn"><i class="fas fa-chart-pie"></i><span>&nbspReportes</span></a>
                <ul class="menudesplegable-content">
                    <li><a href="reporte-clientes.php"><i class="fas fa-user-check"></i><span>&nbspReporte de Clientes</span></a></li>
                    <li><a href="reporte-ventas.php"><i class="fas fa-file-invoice-dollar"></i><span>&nbspReporte de Ventas</span></a></li>
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


