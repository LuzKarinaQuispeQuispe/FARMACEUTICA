<?php
include '../../../config/conection.php';

if (isset($_GET['id'])) {
    $idProveedor = $_GET['id'];

    // Crear una instancia de la clase Database
    $database = new Database();
    $db = $database->getConnection();

    // Consulta para obtener el proveedor por ID
    $query = "SELECT * FROM proveedores WHERE idproveedores = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $idProveedor);
    $stmt->execute();
    $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Actualizar los datos del proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreproveedor = $_POST['nombreproveedor'];
    $direccion = $_POST['direccion'];
    $contacto = $_POST['contacto'];
    $estado = $_POST['estado']; // 1 = Activo, 0 = Desactivo
    $productodescripcion = $_POST['productodescripcion'];

    // Crear una instancia de la clase Database
    $database = new Database();
    $db = $database->getConnection();

    // Consulta para actualizar el proveedor
    $query = "UPDATE proveedores SET nombreproveedor = :nombreproveedor, direccion = :direccion, 
              contacto = :contacto, estado = :estado, productodescripcion = :productodescripcion
              WHERE idproveedores = :id";

    // Preparar la consulta
    $stmt = $db->prepare($query);

    // Asignar los valores a los parámetros
    $stmt->bindParam(':nombreproveedor', $nombreproveedor);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':contacto', $contacto);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':productodescripcion', $productodescripcion);
    $stmt->bindParam(':id', $idProveedor);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Proveedor actualizado exitosamente'); window.location.href = 'mostrar_proveedores.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el proveedor');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
</head>
<body>
    <h2>Editar Proveedor</h2>
    <form method="POST" action="editar_proveedor.php?id=<?php echo $proveedor['idproveedores']; ?>">
        <label for="nombreproveedor">Nombre del Proveedor:</label>
        <input type="text" id="nombreproveedor" name="nombreproveedor" value="<?php echo $proveedor['nombreproveedor']; ?>" required><br><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo $proveedor['direccion']; ?>" required><br><br>

        <label for="contacto">Contacto:</label>
        <input type="text" id="contacto" name="contacto" value="<?php echo $proveedor['contacto']; ?>" required><br><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="1" <?php echo ($proveedor['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
            <option value="0" <?php echo ($proveedor['estado'] == 0) ? 'selected' : ''; ?>>Desactivo</option>
        </select><br><br>

        <label for="productodescripcion">Descripción del Producto:</label>
        <input type="text" id="productodescripcion" name="productodescripcion" value="<?php echo $proveedor['productodescripcion']; ?>" required><br><br>

        <button type="submit">Actualizar Proveedor</button>
    </form>
</body>
</html>
