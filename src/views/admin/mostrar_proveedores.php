<?php
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

// Incluir la conexión a la base de datos
include '../../../config/conection.php';

// Crear una instancia de la clase Database
$database = new Database();
$db = $database->getConnection();

// Consulta para obtener todos los proveedores
$query = "SELECT * FROM proveedores";
$stmt = $db->prepare($query);
$stmt->execute();

// Obtener los resultados
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Medicamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php include('../head1.php'); ?>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="sidebar_c1">
            <?php include('sidebar.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="main-content">
                    <!-- Título de la página -->
                    <h2>Listado de Proveedores</h2>

                    <!-- Botón para crear un nuevo proveedor -->
                    <a href="crear_proveedor.php">
                        <button>Crear Nuevo Proveedor</button>
                    </a>

                    <!-- Tabla de Proveedores -->
                    <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Contacto</th>
                                <th>Estado</th>
                                <th>Descripción del Producto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($proveedores as $proveedor): ?>
                                <tr>
                                    <td><?php echo $proveedor['idproveedores']; ?></td>
                                    <td><?php echo $proveedor['nombreproveedor']; ?></td>
                                    <td><?php echo $proveedor['direccion']; ?></td>
                                    <td><?php echo $proveedor['contacto']; ?></td>
                                    <td><?php echo $proveedor['estado'] == 1 ? 'Activo' : 'Desactivo'; ?></td>
                                    <td><?php echo $proveedor['productodescripcion']; ?></td>
                                    <td>
                                        <a href="editar_proveedor.php?id=<?php echo $proveedor['idproveedores']; ?>">Editar</a> |
                                        <a href="eliminar_proveedor.php?id=<?php echo $proveedor['idproveedores']; ?>" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
