<?php
session_start();
if (!isset($_SESSION['rol_1'])) {
    header('location: ../login.php');
    exit();
}

// Incluir la conexión a la base de datos
include('../../../config/conection.php');

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();
// Procesar datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];
    $categoria = $_POST['categoria'];

    // Validar que las contraseñas coincidan
    if ($contraseña !== $confirmar_contraseña) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Hash de la contraseña
        $hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

        // Insertar usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuario (Nombre, Usua, Contraseña, TipoUsuario_id) VALUES (?, ?, ?, ?)");
        // Utilizando bindValue para PDO
        $stmt->bindValue(1, $nombre, PDO::PARAM_STR);
        $stmt->bindValue(2, $usuario, PDO::PARAM_STR);
        $stmt->bindValue(3, $hashed_password, PDO::PARAM_STR);
        $stmt->bindValue(4, $categoria, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $success = "Usuario agregado correctamente.";
        } else {
            $error = "Error al agregar el usuario: " . $conn->errorInfo()[2]; // Mostrar detalles del error en PDO
        }
        $stmt->closeCursor(); // Cerrar el cursor de la consulta
    }
}

$query = "SELECT Nombre, Usua, TipoUsuario_id FROM usuario";
$stmt = $conn->prepare($query);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Agregar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../public/css/principal.css" rel="stylesheet" />
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
            <main>
        <div class="main-content">
            <div class="content-container">
                <!-- Sección de Agregar Nuevo Usuario -->
                <div class="add-user">
                    <h4>Agregar Nuevo Usuario</h4>

                    <!-- Mostrar errores o mensajes de éxito -->
                    <?php if (isset($error)): ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <p style="color: green;"><?php echo $success; ?></p>
                    <?php endif; ?>

                    <!-- Formulario para agregar usuario -->
                    <form method="POST" action="" class="form-agregar-usuario">
                    <label for="nombre">Nombre Completo:</label>
                    <input type="text" id="nombre" name="nombre" required><br><br>

                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required><br><br>

                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" required><br><br>

                    <label for="confirmar_contraseña">Confirmar Contraseña:</label>
                    <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" required><br><br>

                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="1">Administrador</option>
                        <option value="2">Stock</option>
                        <option value="3">Ventas</option>
                    </select><br><br>

                    <button type="submit">Agregar Usuario</button>
                </form>

                </div>

                <!-- Sección de Usuarios Registrados -->
                <div class="registered-users">
                    <h4>Usuarios Registrados</h4>
                    
                    <?php
                    echo "<table border='1'>";
                    echo "<tr><th>Nombre Completo</th><th>Usuario</th><th>Categoría</th></tr>";

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // Asignar el nombre de la categoría basado en el TipoUsuario_id
                        $categoria = '';
                        if ($row['TipoUsuario_id'] == 1) {
                            $categoria = 'Administrador';
                        } elseif ($row['TipoUsuario_id'] == 2) {
                            $categoria = 'Stock';
                        } elseif ($row['TipoUsuario_id'] == 3) {
                            $categoria = 'Ventas';
                        }

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Usua']) . "</td>";
                        echo "<td>" . htmlspecialchars($categoria) . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                    ?>
                </div>
            </div>
        </div>
    </main>

        </div>
    </div>

    <script src="../../../public/js/medicina.js"></script>
</body>
</html>
