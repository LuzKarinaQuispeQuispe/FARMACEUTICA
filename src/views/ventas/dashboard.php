<?php
include '../../../config/conection.php';

session_start();
if (!isset($_SESSION['rol_3'])) {
    header('location: ../login.php');
    exit();
}

echo "Bienvenido Empleado ventas";

$conn = null;
?>
