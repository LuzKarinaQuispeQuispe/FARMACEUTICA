<?php
include '../../../config/conection.php';

// Crear una instancia de la clase Database
$database = new Database();
$db = $database->getConnection();

// Verificar si se pasa un ID de categoría por la URL
if (isset($_GET['id'])) {
    $idCategoria = $_GET['id'];

    // Consulta para eliminar la categoría
    $query = "DELETE FROM categorias WHERE idCategorias = :idCategoria";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':idCategoria', $idCategoria);

    // Ejecutar la eliminación
    if ($stmt->execute()) {
        echo "Categoría eliminada correctamente.";
        // Redirigir al listado de categorías
        header('Location: mostrar_categorias.php');
        exit();
    } else {
        echo "Error al eliminar la categoría.";
    }
}
?>
