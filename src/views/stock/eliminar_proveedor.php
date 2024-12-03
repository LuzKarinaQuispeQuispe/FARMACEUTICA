<?php
include '../../../config/conection.php';

if (isset($_GET['id'])) {
    $idProveedor = $_GET['id'];

    // Crear una instancia de la clase Database
    $database = new Database();
    $db = $database->getConnection();

    // Consulta para eliminar el proveedor
    $query = "DELETE FROM proveedores WHERE idproveedores = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $idProveedor);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Proveedor eliminado exitosamente'); window.location.href = 'mostrar_proveedores.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el proveedor'); window.location.href = 'mostrar_proveedores.php';</script>";
    }
}
?>
