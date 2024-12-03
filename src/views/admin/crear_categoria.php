<?php
/*include '../../../config/conection.php';*/
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

include '../../../config/conection.php';
// Crear una instancia de la clase Database
$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombreCategoria = $_POST['nombre_categoria'];

    // Consulta para insertar una nueva categoría
    $query = "INSERT INTO categorias (nombre) VALUES (:nombre_categoria)";
    $stmt = $db->prepare($query);

    // Vincular parámetros
    $stmt->bindParam(':nombre_categoria', $nombreCategoria);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Categoría agregada correctamente.";
    } else {
        echo "Error al agregar la categoría.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Crear Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../public/css/principal.css" rel="stylesheet" />
    <link href="../../../public/css/form.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php include('../head1.php'); ?>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="sidebar_c1">
            <?php include('sidebar.php'); ?>
        </div>
        <div id="layoutSidenav_content">
            
                
                    
 <!-- Formulario para crear una categoría -->
 <form action="crear_categoria.php" method="POST">
                    <h2>Crear Nueva Categoría</h2>
                        <label for="nombre_categoria">Nombre de la Categoría:</label>
                        <input type="text" id="nombre_categoria" name="nombre_categoria" required><br><br>

                        <button type="submit">Guardar Categoría</button>
                        <a href="mostrar_categorias.php">
                        <button>Ver Categorías</button>
                    </a>
                    </form>


                

                    
               
            
        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
