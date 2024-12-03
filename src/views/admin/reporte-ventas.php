<?php
/*include '../../../config/conection.php';*/
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
$cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : '';

// Consulta SQL con filtros
$sql = "SELECT v.idVentas, v.codigo, v.fecha_venta, c.nombre_cliente, v.Debe 
        FROM ventas v
        JOIN cliente c ON v.Cliente_idCliente = c.idCliente
        WHERE 1=1"; // Se aplica un WHERE que será modificado por los filtros

// Filtro por fecha
if ($fecha_inicio && $fecha_fin) {
    $sql .= " AND v.fecha_venta BETWEEN :fecha_inicio AND :fecha_fin";
}
// Filtro por cliente
if ($cliente_id) {
    $sql .= " AND v.Cliente_idCliente = :cliente_id";
}

$stmt = $conn->prepare($sql);

// Vincular parámetros
if ($fecha_inicio && $fecha_fin) {
    $stmt->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt->bindParam(':fecha_fin', $fecha_fin);
}
if ($cliente_id) {
    $stmt->bindParam(':cliente_id', $cliente_id);
}

$stmt->execute();
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Reporte de Ventas</title>
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
                    <h1 class="mt-4">Reporte de Ventas</h1>
                    
                    <!-- Formulario de Filtros -->
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
            <label for="cliente_id" class="sr-only">Cliente:</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Todos</option>
                <?php
                // Cargar los clientes disponibles
                $cliente_query = "SELECT idCliente, nombre_cliente FROM cliente";
                $cliente_result = $conn->query($cliente_query);
                while ($cliente = $cliente_result->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($cliente['idCliente'] == $cliente_id) ? 'selected' : '';
                    echo "<option value='{$cliente['idCliente']}' {$selected}>{$cliente['nombre_cliente']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <button type="submit" class="btn-filter">Filtrar</button>
        </div>
    </div>
</form>


                    <!-- Tabla de Ventas -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Código</th>
                                    <th>Fecha de Venta</th>
                                    <th>Cliente</th>
                                    <th>Debe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($ventas) > 0) {
                                    foreach ($ventas as $venta) {
                                        echo "<tr>
                                                <td>{$venta['idVentas']}</td>
                                                <td>{$venta['codigo']}</td>
                                                <td>{$venta['fecha_venta']}</td>
                                                <td>{$venta['nombre_cliente']}</td>
                                                <td>{$venta['Debe']}</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No se encontraron ventas.</td></tr>";
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
