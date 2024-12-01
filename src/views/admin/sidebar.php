<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="../../../public/css/sidebar.css">
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
            <p>Nombre del Usuario</p>
        </div>

        <!-- Menú -->
        <ul class="menu">
            <li>
                <a href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            </li>
            <li>
                <a href="#usuarios" class="dropdown-btn"><i class="fas fa-user"></i><span>Usuarios</span></a>
                <ul class="dropdown-content">
                    <li><a href="agregar_usuario.php"><i class="fas fa-user-plus"></i><span>Agregar Usuario</span></a></li>
                    <li><a href="gestionar_usuario.php"><i class="fas fa-user-cog"></i><span>Gestionar Usuario</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#proveedores" class="dropdown-btn"><i class="fas fa-truck"></i><span>Proveedores</span></a>
                <ul class="dropdown-content">
                    <li><a href="agregar_proveedor.php"><i class="fas fa-truck-loading"></i><span>Agregar Proveedor</span></a></li>
                    <li><a href="gestionar_proveedor.php"><i class="fas fa-tools"></i><span>Gestionar Proveedor</span></a></li>
                    <li><a href="buscar_proveedor.php"><i class="fas fa-search"></i><span>Buscar Proveedor</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#medicina" class="dropdown-btn"><i class="fas fa-pills"></i><span>Medicina</span></a>
                <ul class="dropdown-content">
                    <li><a href="agregar_medicina.php"><i class="fas fa-plus-circle"></i><span>Agregar Medicina</span></a></li>
                    <li><a href="buscar_medicina.php"><i class="fas fa-search-plus"></i><span>Buscar Medicina</span></a></li>
                    <li><a href="gestionar_medicina.php"><i class="fas fa-cogs"></i><span>Gestionar Medicina</span></a></li>
                </ul>
            </li>
            <li><a href="facturas.php"><i class="fas fa-file-invoice"></i><span>Facturas</span></a></li>
            <li><a href="reportes.php"><i class="fas fa-chart-line"></i><span>Reportes</span></a></li>
        </ul>
    </div>

    <script>
        // Funcionalidad del botón de menú
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // Dropdown functionality
        document.querySelectorAll('.dropdown-btn').forEach(button => {
            button.addEventListener('click', () => {
                const dropdownContent = button.nextElementSibling;
                dropdownContent.classList.toggle('show');
            });
        });
        
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.getElementById('sidebar_c1').classList.toggle('collapsed');
        });

    </script>
</body>
</html>
