<?php
// Incluir el archivo de conexión
include '../../../config/conection.php';

// Crear una instancia de la clase Database
$database = new Database();
$db = $database->getConnection();

// Consulta para obtener todas las categorías
$query = "SELECT * FROM categorias";
$stmt = $db->prepare($query);
$stmt->execute();

// Obtener todas las categorías
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verificar sesión
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link href="../../../public/css/form.css" rel="stylesheet" />
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
                    <h2>Listado de Categorías</h2>

                    <!-- Enlace para crear una nueva categoría -->
                    <a href="crear_categoria.php">
                        <button>Crear Nueva Categoría</button>
                    </a>

                    <br><br>

                    <!-- Tabla de categorías -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de la Categoría</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><?php echo $categoria['idCategorias']; ?></td>
                                    <td><?php echo $categoria['nombre']; ?></td>
                                    <td><?php echo $categoria['estado'] == 1 ? 'Activo' : 'Desactivo'; ?></td>
                                    <td>
                                        <!-- Botón de editar -->
                                        <a href="editar_categoria.php?id=<?php echo $categoria['idCategorias']; ?>">
                                            <button>Editar</button>
                                        </a>
                                        
                                        <!-- Botón de eliminar -->
                                        <a href="eliminar_categoria.php?id=<?php echo $categoria['idCategorias']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                            <button>Eliminar</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
