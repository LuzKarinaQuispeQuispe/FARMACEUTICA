<?php 
include '../../../config/conection.php';

// Crear una instancia de la clase Database
$database = new Database();
$conn = $database->getConnection();

// Obtener los medicamentos desde la base de datos
$query = "SELECT id, nombre, cantidad FROM medicamentos";
$stmt = $conn->prepare($query);
$stmt->execute();
$medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Medicamento</title>
    <link rel="stylesheet" href="../../../public/css/selectmedi.css">
    <script>
        function seleccionar(nombre, cantidad, id) {
            const nombreCantidad = `${nombre} (${cantidad})`;
            window.opener.seleccionarMedicamento(nombreCantidad, id);
            window.close();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="title">Seleccionar Medicamento</h1>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicamentos as $medicamento): ?>
                    <tr>
                        <td><?= $medicamento['nombre'] ?></td>
                        <td><?= $medicamento['cantidad'] ?></td>
                        <td>
                            <button class="select-btn" onclick="seleccionar('<?= $medicamento['nombre'] ?>', '<?= $medicamento['cantidad'] ?>', <?= $medicamento['id'] ?>)">Seleccionar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
