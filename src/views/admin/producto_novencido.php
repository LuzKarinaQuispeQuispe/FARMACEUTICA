<?php
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

// Incluir el archivo de conexión a la base de datos
include '../../../config/conection.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Consulta para obtener los productos no vencidos
$query = "SELECT p.id, p.Nombreproducto, p.precio, p.cantidad_de_cajas, p.cantidad_por_caja, p.ubicacion_farmacia, p.fecha_ingreso, p.fecha_vencimiento, c.nombre AS categoria
          FROM productos p
          JOIN categorias c ON p.Categorias_idCategorias = c.idCategorias
          WHERE p.fecha_vencimiento > NOW()"; // Solo productos no vencidos

$stmt = $conn->prepare($query);
$stmt->execute();

// Obtener los resultados
$productos_no_vencidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <div class="container mt-5">
                    <h2 class="text-center">Productos No Vencidos</h2>
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Producto</th>
                                <th>Precio</th>
                                <th>Cantidad por Caja</th>
                                <th>Cantidad de Cajas</th>
                                <th>Ubicación en Farmacia</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Vencimiento</th>
                                <th>Categoría</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos_no_vencidos as $producto): ?>
                                <tr>
                                    <td><?= htmlspecialchars($producto['id']) ?></td>
                                    <td><?= htmlspecialchars($producto['Nombreproducto']) ?></td>
                                    <td><?= htmlspecialchars($producto['precio']) ?></td>
                                    <td><?= htmlspecialchars($producto['cantidad_por_caja']) ?></td>
                                    <td><?= htmlspecialchars($producto['cantidad_de_cajas']) ?></td>
                                    <td><?= htmlspecialchars($producto['ubicacion_farmacia']) ?></td>
                                    <td><?= htmlspecialchars($producto['fecha_ingreso']) ?></td>
                                    <td><?= htmlspecialchars($producto['fecha_vencimiento']) ?></td>
                                    <td><?= htmlspecialchars($producto['categoria']) ?></td>
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
