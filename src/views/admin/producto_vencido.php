<?php
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

// Incluir el archivo de conexión
include '../../../config/conection.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Obtener todos los productos vencidos
$query = "SELECT p.*, c.nombre AS categoria_nombre
          FROM productos p
          LEFT JOIN categorias c ON p.Categorias_idCategorias = c.idCategorias
          WHERE p.fecha_vencimiento < NOW()";

$stmt = $conn->prepare($query);
$stmt->execute();
$productos_vencidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener total de productos en inventario
$query_total = "SELECT COUNT(*) FROM productos";
$stmt_total = $conn->prepare($query_total);
$stmt_total->execute();
$total_productos = $stmt_total->fetchColumn();

// Lógica para eliminar todos los productos vencidos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_todos'])) {
    $delete_query = "DELETE FROM productos WHERE fecha_vencimiento < NOW()";
    $delete_stmt = $conn->prepare($delete_query);
    if ($delete_stmt->execute()) {
        echo "<script>alert('Todos los productos vencidos han sido eliminados.'); window.location.href = '';</script>";
    } else {
        echo "<script>alert('Error al eliminar los productos vencidos.');</script>";
    }
}

// Filtros de búsqueda (por categoría, fecha)
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';  // Evitar el error de clave no definida
$fecha_vencimiento = isset($_GET['fecha_vencimiento']) ? $_GET['fecha_vencimiento'] : '';

// Consulta filtrada
$filter_query = "SELECT p.*, c.nombre AS categoria_nombre
                 FROM productos p
                 LEFT JOIN categorias c ON p.Categorias_idCategorias = c.idCategorias
                 WHERE p.fecha_vencimiento < NOW()";

if ($categoria !== '') {
    $filter_query .= " AND p.Categorias_idCategorias = :categoria";
}
if ($fecha_vencimiento !== '') {
    $filter_query .= " AND p.fecha_vencimiento = :fecha_vencimiento";
}

$filter_stmt = $conn->prepare($filter_query);
if ($categoria !== '') {
    $filter_stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
}
if ($fecha_vencimiento !== '') {
    $filter_stmt->bindParam(':fecha_vencimiento', $fecha_vencimiento);
}
$filter_stmt->execute();
$productos_vencidos_filtrados = $filter_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicamentos</title>
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link href="../../../public/css/vencido.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php include('../head1.php'); ?>
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="sidebar_c1">
            <?php include('sidebar.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="main-content">
                    <h1>Productos Vencidos</h1>

                    <!-- Resumen de Productos Vencidos -->
                    <div class="summary">
                        <h3>Resumen de Productos Vencidos</h3>
                        <p><strong>Total de Productos Vencidos:</strong> <?= count($productos_vencidos) ?></p>
                        <p><strong>Valor Total de los Productos:</strong> S/ <?= number_format(array_sum(array_column($productos_vencidos, 'precio')), 2) ?></p>
                    </div>

                    <!-- Filtros de Búsqueda -->
                    <div class="filters">
    <h3>Filtrar Productos Vencidos</h3>
    <form method="get" action="">
        <div class="filters-row">
            <div class="filter-item">
                <label for="categoria">Categoría</label>
                <select name="categoria" id="categoria" class="form-control">
                    <option value="">Todas</option>
                    <?php
                    $categorias_query = "SELECT * FROM categorias";
                    $categorias_stmt = $conn->prepare($categorias_query);
                    $categorias_stmt->execute();
                    $categorias = $categorias_stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($categorias as $categoria_item) {
                        $selected = ($categoria_item['idCategorias'] == $categoria) ? 'selected' : '';
                        echo "<option value='{$categoria_item['idCategorias']}' {$selected}>{$categoria_item['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="filter-item">
                <label for="fecha_vencimiento">Fecha y Hora de Vencimiento</label>
                <input type="datetime-local" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control">
            </div>
        </div>

        <button type="submit" class="filter-button">Filtrar</button>
    </form>
</div>


                    <!-- Tabla de Productos Vencidos -->
                    <div class="table-container">
                        <h3>Lista de Productos Vencidos</h3>
                        <table class="producto-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Fecha de Vencimiento</th>
                                    <th>Categoría</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($productos_vencidos_filtrados)): ?>
                                    <?php foreach ($productos_vencidos_filtrados as $producto): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($producto['id']) ?></td>
                                            <td><?= htmlspecialchars($producto['Nombreproducto']) ?></td>
                                            <td>S/ <?= number_format($producto['precio'], 2) ?></td>
                                            <td><?= htmlspecialchars($producto['cantidad_de_cajas']) ?></td>
                                            <td><?= htmlspecialchars($producto['fecha_vencimiento']) ?></td>
                                            <td><?= htmlspecialchars($producto['categoria_nombre']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">No hay productos vencidos</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Acción Masiva: Eliminar todos los productos vencidos -->
                    <div class="delete-action">
                        <form method="post" action="">
                            <button type="submit" name="eliminar_todos">Eliminar Todos los Productos Vencidos</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
