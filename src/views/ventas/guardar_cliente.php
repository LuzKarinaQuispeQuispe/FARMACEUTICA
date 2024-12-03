<?php
include '../../../config/conection.php';

// Obtener los datos del cliente
$nombre_cliente = $_POST['nombre_cliente'];
$celular = $_POST['celular'];
$dni = $_POST['dni'];

// Crear una instancia de la clase Database
$database = new Database();
$db = $database->getConnection();

// Consulta para insertar el cliente
$query = "INSERT INTO cliente (nombre_cliente, DNI, contacto) VALUES (:nombre_cliente, :dni, :celular)";

// Preparar la consulta
$stmt = $db->prepare($query);

// Asignar los valores a los parámetros de la consulta
$stmt->bindParam(':nombre_cliente', $nombre_cliente);
$stmt->bindParam(':dni', $dni);
$stmt->bindParam(':celular', $celular);

// Ejecutar la consulta y verificar si se insertó correctamente
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Cliente guardado correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al guardar el cliente"]);
}
?>
