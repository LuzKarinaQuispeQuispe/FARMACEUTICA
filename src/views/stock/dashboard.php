<?php
include '../../../config/conection.php';
session_start();
if (!isset($_SESSION['rol_2'])) {
    header('location: ../login.php');
    exit();
}

echo "Bienvenido Empleado Stock";

$conn = null;
?>
