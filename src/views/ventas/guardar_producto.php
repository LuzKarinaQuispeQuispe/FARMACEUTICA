<?php
// Incluir la conexión a la base de datos
include('../../../config/conection.php');

// Crear una instancia de la clase Database
$database = new Database();
$conn = $database->getConnection();

// Verificar si se enviaron los datos necesarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreProducto = $_POST['Nombreproducto'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $cantidadCajas = $_POST['cantidad_de_cajas'] ?? 0;
    $cantidadPorCaja = $_POST['cantidad_por_caja'] ?? 0;
    $ubicacion = $_POST['ubicacion_farmacia'] ?? '';
    $categoria = $_POST['Categorias_idCategorias'] ?? 0;
    $fechaVencimiento = $_POST['fecha_vencimiento'] ?? null;
    $fechaIngreso = $_POST['fecha_ingreso'] ?? date('Y-m-d H:i:s');

    // Insertar los datos en la base de datos
    $query = "
        INSERT INTO productos (
            Nombreproducto, precio, cantidad_de_cajas, cantidad_por_caja,
            ubicacion_farmacia, Categorias_idCategorias, fecha_vencimiento, fecha_ingreso
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        $nombreProducto, $precio, $cantidadCajas, $cantidadPorCaja,
        $ubicacion, $categoria, $fechaVencimiento, $fechaIngreso
    ]);
}
