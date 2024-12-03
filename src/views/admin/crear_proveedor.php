<?php
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

// Incluir el archivo de conexión a la base de datos
include '../../../config/conection.php';

// Crear nuevo proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreproveedor = $_POST['nombreproveedor'];
    $direccion = $_POST['direccion'];
    $contacto = $_POST['contacto'];
    $estado = $_POST['estado']; // 1 = Activo, 0 = Desactivo
    $productodescripcion = $_POST['productodescripcion'];

    // Crear una instancia de la clase Database
    $database = new Database();
    $db = $database->getConnection();

    // Consulta para insertar el nuevo proveedor
    $query = "INSERT INTO proveedores (nombreproveedor, direccion, contacto, estado, productodescripcion) 
              VALUES (:nombreproveedor, :direccion, :contacto, :estado, :productodescripcion)";

    // Preparar la consulta
    $stmt = $db->prepare($query);

    // Asignar los valores a los parámetros
    $stmt->bindParam(':nombreproveedor', $nombreproveedor);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':contacto', $contacto);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':productodescripcion', $productodescripcion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Proveedor creado exitosamente');</script>";
    } else {
        echo "<script>alert('Error al crear el proveedor');</script>";
    }
}

// Obtener los proveedores existentes
$database = new Database();
$db = $database->getConnection();
$query = "SELECT * FROM proveedores";
$stmt = $db->prepare($query);
$stmt->execute();
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proveedor</title>
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link href="../../../public/css/form.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php include('../head1.php'); ?>
    <style>
        .table-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="sidebar_c1">
            <?php include('sidebar.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-5">
                    <!-- Columna izquierda: Formulario para crear proveedor -->
                    <div style="float: left; width: 45%; padding-right: 1px;">
                        
                        <form method="POST" action="crear_proveedor.php">
                        <h2>Crear Proveedor</h2>
                            <div class="form-group">
                                <label for="nombreproveedor">Nombre del Proveedor:</label>
                                <input type="text" id="nombreproveedor" name="nombreproveedor" class="form-control" required><br><br>
                            </div>
                            
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>
                                <input type="text" id="direccion" name="direccion" class="form-control" required><br><br>
                            </div>

                            <div class="form-group">
                                <label for="contacto">Contacto:</label>
                                <input type="text" id="contacto" name="contacto" class="form-control" required><br><br>
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <select id="estado" name="estado" class="form-control" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Desactivo</option>
                                </select><br><br>
                            </div>

                            <div class="form-group">
                                <label for="productodescripcion">Descripción del Producto:</label>
                                <input type="text" id="productodescripcion" name="productodescripcion" class="form-control" required><br><br>
                            </div>

                            <button type="submit" class="btn btn-primary">Crear Proveedor</button>
                        </form>
                    </div>

                    <!-- Columna derecha: Listado de proveedores -->
                    <div style="float: right; width: 54%;">

                        <!-- Contenedor de la tabla con diseño aplicado -->
                        <div class="table-container">
                        <h2>Listado de Proveedores</h2>
                        <a href="crear_proveedor.php">
                            <button>Crear Nuevo Proveedor</button>
                        </a>
                            <table>
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
    <a href="editar_proveedor.php?id=<?php echo $proveedor['idproveedores']; ?>" class="button-action edit">Editar</a> |
    <a href="eliminar_proveedor.php?id=<?php echo $proveedor['idproveedores']; ?>" class="button-action delete" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</a>
</td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div style="clear: both;"></div>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
