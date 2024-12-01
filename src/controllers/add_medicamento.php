<?php
require_once(realpath(__DIR__ . '/../../config/conection.php')); // Incluir el archivo de conexión
$database = new Database();
$pdo = $database->getConnection(); 

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nombre']) && isset($data['cantidad']) && isset($data['via_suministro'])) {
    $nombre = $data['nombre'];
    $cantidad = $data['cantidad'];
    $via_suministro = $data['via_suministro'];

    $sql = "INSERT INTO medicamentos (nombre, cantidad, via_suministro) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nombre, $cantidad, $via_suministro])) {
        echo json_encode(['success' => true, 'message' => 'Medicamento agregado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el medicamento.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
}
?>
