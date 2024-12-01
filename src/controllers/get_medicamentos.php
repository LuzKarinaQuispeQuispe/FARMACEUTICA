<?php

require_once(realpath(__DIR__ . '/../../config/conection.php'));
$database = new Database();
$pdo = $database->getConnection(); 

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM medicamentos WHERE nombre LIKE ?";
$stmt = $pdo->prepare($sql);  

$stmt->execute(['%' . $search . '%']); 

$medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);  

echo json_encode($medicamentos);
?>
