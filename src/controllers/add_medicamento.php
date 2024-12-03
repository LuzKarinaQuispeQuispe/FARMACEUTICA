<?php
require_once(realpath(__DIR__ . '/../../config/conection.php')); // Incluir el archivo de conexión
$database = new Database();
$pdo = $database->getConnection(); 

$data = json_decode(file_get_contents("php://input"), true);

// Verificamos si todos los campos necesarios están presentes, incluido el id (que ahora es 'codigo')
if (isset($data['id']) && isset($data['nombre']) && isset($data['cantidad']) && isset($data['via_suministro'])) {
    $id = $data['id'];  // 'id' ahora es 'codigo'
    $nombre = $data['nombre'];
    $cantidad = $data['cantidad'];
    $via_suministro = $data['via_suministro'];

    // Usamos el 'id' manual para la inserción
    $sql = "INSERT INTO medicamentos (id, nombre, cantidad, via_suministro) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$id, $nombre, $cantidad, $via_suministro])) {
        echo json_encode(['success' => true, 'message' => 'Medicamento agregado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el medicamento.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
}
?>


