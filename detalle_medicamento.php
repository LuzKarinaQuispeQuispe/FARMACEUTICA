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

// Obtener el ID del medicamento desde la URL
$medicamento_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($medicamento_id > 0) {
    // Consulta para obtener los detalles del medicamento
    $query = "SELECT * FROM medicamentos WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $medicamento_id, PDO::PARAM_INT);
    $stmt->execute();

    $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $medicamento = null;
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
    <title>Detalles del Medicamento</title>
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
                    <h1 class="text-center">Detalles del Medicamento</h1>
                    <?php if ($medicamento): ?>
                        <table class="table table-bordered mt-4">
                            <tr>
                                <th>ID</th>
                                <td><?= htmlspecialchars($medicamento['id']) ?></td>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <td><?= htmlspecialchars($medicamento['nombre']) ?></td>
                            </tr>
                            <tr>
                                <th>Cantidad</th>
                                <td><?= htmlspecialchars($medicamento['cantidad']) ?></td>
                            </tr>
                            <tr>
                                <th>Vía de Suministro</th>
                                <td><?= htmlspecialchars($medicamento['via_suministro']) ?></td>
                            </tr>
                            <tr>
                                <th>Forma</th>
                                <td><?= htmlspecialchars($medicamento['forma']) ?></td>
                            </tr>
                            <tr>
                                <th>ATC</th>
                                <td><?= htmlspecialchars($medicamento['atc']) ?></td>
                            </tr>
                            <tr>
                                <th>Riesgo</th>
                                <td><?= htmlspecialchars($medicamento['riesgo']) ?></td>
                            </tr>
                            <tr>
                                <th>Mecanismo</th>
                                <td><?= htmlspecialchars($medicamento['mecanismo']) ?></td>
                            </tr>
                            <tr>
                                <th>Indicaciones</th>
                                <td><?= htmlspecialchars($medicamento['indicaciones']) ?></td>
                            </tr>
                            <tr>
                                <th>Posología</th>
                                <td><?= htmlspecialchars($medicamento['posologia']) ?></td>
                            </tr>
                            <tr>
                                <th>Contraindicaciones</th>
                                <td><?= htmlspecialchars($medicamento['contraindicaciones']) ?></td>
                            </tr>
                            <tr>
                                <th>Advertencias y Precauciones</th>
                                <td><?= htmlspecialchars($medicamento['advertencias_precausiones']) ?></td>
                            </tr>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-danger text-center">Medicamento no encontrado.</div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
