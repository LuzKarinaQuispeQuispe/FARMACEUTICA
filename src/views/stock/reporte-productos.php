<?php
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

// Conectar a la base de datos
include('../../../config/conection.php');

// Obtener conexión
$database = new Database();
$conn = $database->getConnection();

// Variables para los filtros
$fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
$fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
$categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : '';

// Consulta SQL con filtros
$sql = "SELECT p.id, p.Nombreproducto, p.precio, p.cantidad_de_cajas, p.cantidad_por_caja, 
               p.fecha_ingreso, p.fecha_vencimiento, c.nombre AS categoria
        FROM productos p
        JOIN categorias c ON p.Categorias_idCategorias = c.idCategorias
        WHERE 1=1"; // Se aplica un WHERE que será modificado por los filtros

// Filtro por fecha
if ($fecha_inicio && $fecha_fin) {
    $sql .= " AND p.fecha_ingreso BETWEEN :fecha_inicio AND :fecha_fin";
}
// Filtro por categoría
if ($categoria_id) {
    $sql .= " AND p.Categorias_idCategorias = :categoria_id";
}

$stmt = $conn->prepare($sql);

// Vincular parámetros
if ($fecha_inicio && $fecha_fin) {
    $stmt->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt->bindParam(':fecha_fin', $fecha_fin);
}
if ($categoria_id) {
    $stmt->bindParam(':categoria_id', $categoria_id);
}

$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Reporte de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link href="../../../public/css/reporte.css" rel="stylesheet" />
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
                <div class="container-fluid">
                    <h1 class="mt-4">Reporte de Productos</h1>
                    
                    <!-- Formulario de Filtros -->
                    <form method="post">
                        <div class="form-row align-items-center">
                            <div class="col-md-3 mb-3">
                                <label for="fecha_inicio" class="sr-only">Fecha Inicio:</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?php echo $fecha_inicio; ?>" placeholder="Fecha Inicio">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="fecha_fin" class="sr-only">Fecha Fin:</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?php echo $fecha_fin; ?>" placeholder="Fecha Fin">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="categoria_id" class="sr-only">Categoría:</label>
                                <select name="categoria_id" id="categoria_id" class="form-control">
                                    <option value="">Todas</option>
                                    <?php
                                    // Cargar las categorías disponibles
                                    $categoria_query = "SELECT idCategorias, nombre FROM categorias";
                                    $categoria_result = $conn->query($categoria_query);
                                    while ($categoria = $categoria_result->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = ($categoria['idCategorias'] == $categoria_id) ? 'selected' : '';
                                        echo "<option value='{$categoria['idCategorias']}' {$selected}>{$categoria['nombre']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" class="btn-filter">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de Productos -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Producto</th>
                                    <th>Nombre Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad de Cajas</th>
                                    <th>Cantidad por Caja</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Categoría</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($productos) > 0) {
                                    foreach ($productos as $producto) {
                                        echo "<tr>
                                                <td>{$producto['id']}</td>
                                                <td>{$producto['Nombreproducto']}</td>
                                                <td>{$producto['precio']}</td>
                                                <td>{$producto['cantidad_de_cajas']}</td>
                                                <td>{$producto['cantidad_por_caja']}</td>
                                                <td>{$producto['fecha_ingreso']}</td>
                                                <td>{$producto['fecha_vencimiento']}</td>
                                                <td>{$producto['categoria']}</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No se encontraron productos.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
