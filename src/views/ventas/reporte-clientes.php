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
$nombre_cliente = isset($_POST['nombre_cliente']) ? $_POST['nombre_cliente'] : '';
$estado_cliente = isset($_POST['estado_cliente']) ? $_POST['estado_cliente'] : '';

// Consulta SQL con filtros
$sql = "SELECT idCliente, nombre_cliente, DNI, contacto, estado
        FROM cliente
        WHERE 1=1"; // Se aplica un WHERE que será modificado por los filtros

// Filtro por nombre de cliente
if ($nombre_cliente) {
    $sql .= " AND nombre_cliente LIKE :nombre_cliente";
}
// Filtro por estado
if ($estado_cliente !== '') {
    $sql .= " AND estado = :estado_cliente";
}

$stmt = $conn->prepare($sql);

// Vincular parámetros
if ($nombre_cliente) {
    $stmt->bindParam(':nombre_cliente', $nombre_cliente);
}
if ($estado_cliente !== '') {
    $stmt->bindParam(':estado_cliente', $estado_cliente);
}

$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Reporte de Clientes</title>
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
                    <h1 class="mt-4">Reporte de Clientes</h1>
                    
                    <!-- Formulario de Filtros -->
                    <form method="post">
                        <div class="form-row align-items-center">
                            <div class="col-md-3 mb-3">
                                <label for="nombre_cliente" class="sr-only">Nombre Cliente:</label>
                                <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" value="<?php echo $nombre_cliente; ?>" placeholder="Nombre Cliente">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="estado_cliente" class="sr-only">Estado:</label>
                                <select name="estado_cliente" id="estado_cliente" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1" <?php echo ($estado_cliente === '1') ? 'selected' : ''; ?>>Activo</option>
                                    <option value="0" <?php echo ($estado_cliente === '0') ? 'selected' : ''; ?>>Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" class="btn-filter">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de Clientes -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Cliente</th>
                                    <th>Nombre Cliente</th>
                                    <th>DNI</th>
                                    <th>Contacto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($clientes) > 0) {
                                    foreach ($clientes as $cliente) {
                                        $estado = $cliente['estado'] == 1 ? 'Activo' : 'Inactivo';
                                        echo "<tr>
                                                <td>{$cliente['idCliente']}</td>
                                                <td>{$cliente['nombre_cliente']}</td>
                                                <td>{$cliente['DNI']}</td>
                                                <td>{$cliente['contacto']}</td>
                                                <td>{$estado}</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No se encontraron clientes.</td></tr>";
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
