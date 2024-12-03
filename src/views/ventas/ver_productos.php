<?php

// Incluir el archivo de conexión
include('../../../config/conection.php');

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Consulta para obtener los datos de los productos junto con la categoría y medicamento asociados
$query = "
    SELECT 
        p.id,
        p.Nombreproducto,
        p.precio,
        p.cantidad_de_cajas,
        p.cantidad_por_caja,
        p.ubicacion_farmacia,
        p.fecha_ingreso,
        p.fecha_vencimiento,
        c.nombre AS categoria,
        p.medicamentos_id
    FROM productos p
    LEFT JOIN categorias c ON p.Categorias_idCategorias = c.idCategorias
";

$stmt = $conn->prepare($query);
$stmt->execute();

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si se recibe una solicitud para eliminar un producto
if (isset($_GET['eliminar_id'])) {
    $eliminar_id = intval($_GET['eliminar_id']);
    $delete_query = "DELETE FROM productos WHERE id = :id";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bindParam(':id', $eliminar_id, PDO::PARAM_INT);
    if ($delete_stmt->execute()) {
        echo "<script>alert('Producto eliminado correctamente.'); window.location.href = 'ver_productos.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto.');</script>";
    }
}
?>

<?php
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
    <title>Lista de Productos</title>
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
                    <h1 class="text-center">Lista de Productos</h1>
                    <table class="table table-striped table-bordered mt-4">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Producto</th>
                                <th>Precio</th>
                                <th>Cajas</th>
                                <th>Cantidad por Caja</th>
                                <th>Ubicación</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Vencimiento</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($productos)): ?>
                                <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($producto['id']) ?></td>
                                        <td><?= htmlspecialchars($producto['Nombreproducto']) ?></td>
                                        <td>S/ <?= number_format($producto['precio'], 2) ?></td>
                                        <td><?= htmlspecialchars($producto['cantidad_de_cajas']) ?></td>
                                        <td><?= htmlspecialchars($producto['cantidad_por_caja']) ?></td>
                                        <td><?= htmlspecialchars($producto['ubicacion_farmacia']) ?></td>
                                        <td><?= htmlspecialchars($producto['fecha_ingreso']) ?></td>
                                        <td><?= htmlspecialchars($producto['fecha_vencimiento']) ?></td>
                                        <td><?= htmlspecialchars($producto['categoria']) ?></td>
                                        <td class="text-center">
                                            <a href="ver_productos.php?eliminar_id=<?= htmlspecialchars($producto['id']) ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                               Eliminar
                                            </a>
                                            <a href="detalle_medicamento.php?id=<?= htmlspecialchars($producto['medicamentos_id']) ?>" 
                                               class="btn btn-info btn-sm">
                                               Ver más
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">No hay productos registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
