<?php
include_once 'connection.php';

// Obtener los datos de la venta
$codigo = $_POST['codigo'];
$cliente_id = $_POST['cliente_id'];  // Este debe ser el idCliente de la tabla cliente
$fecha_venta = $_POST['fecha_venta'];

// Crear una instancia de la clase Database
$database = new Database();
$db = $database->getConnection();

// Consulta para insertar la venta
$query = "INSERT INTO ventas (codigo, fecha_venta, Cliente_idCliente) VALUES (:codigo, :fecha_venta, :cliente_id)";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar los valores a los parámetros de la consulta
$stmt->bindParam(':codigo', $codigo);
$stmt->bindParam(':fecha_venta', $fecha_venta);
$stmt->bindParam(':cliente_id', $cliente_id);

// Ejecutar la consulta y verificar si se insertó correctamente
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Venta registrada correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al registrar la venta"]);
}
?>
