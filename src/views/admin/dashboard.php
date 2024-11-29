<?php
include '../../../config/conection.php';


session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

echo "Bienvenido Admin";

$conn = null;
?>
