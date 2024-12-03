<?php
include '../../../config/conection.php';

// Obtener el ID de la categoría a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Consulta para obtener la categoría por ID
    $query = "SELECT * FROM categorias WHERE idCategorias = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Obtener los datos de la categoría
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$categoria) {
        die("Categoría no encontrada.");
    }

    // Procesar la actualización del formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $estado = $_POST['estado'];

        // Consulta para actualizar la categoría
        $updateQuery = "UPDATE categorias SET nombre = :nombre, estado = :estado WHERE idCategorias = :id";
        $updateStmt = $db->prepare($updateQuery);

        // Vincular parámetros
        $updateStmt->bindParam(':nombre', $nombre);
        $updateStmt->bindParam(':estado', $estado);
        $updateStmt->bindParam(':id', $id);

        // Ejecutar la consulta
        if ($updateStmt->execute()) {
            echo "Categoría actualizada exitosamente.";
        } else {
            echo "Error al actualizar la categoría.";
        }
    }
} else {
    die("ID de categoría no proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
</head>
<body>
    <h2>Editar Categoría</h2>

    <form action="editar_categoria.php?id=<?php echo $categoria['idCategorias']; ?>" method="POST">
        <label for="nombre">Nombre de la Categoría:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $categoria['nombre']; ?>" required><br><br>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="1" <?php if ($categoria['estado'] == 1) echo 'selected'; ?>>Activo</option>
            <option value="0" <?php if ($categoria['estado'] == 0) echo 'selected'; ?>>Desactivo</option>
        </select><br><br>

        <input type="submit" value="Actualizar Categoría">
    </form>
</body>
</html>
