<?php
include_once '../../config/conection.php';
include_once '../../src/controllers/LoginController.php';
session_start();

if (isset($_GET['cerrar_sesion'])) {
    $rol_to_close = $_GET['cerrar_sesion'];
    if (isset($_SESSION[$rol_to_close])) {
        unset($_SESSION[$rol_to_close]);
    }
    header('location: ../views/login.php');
    exit();
}

$error_message = '';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new Database();
    $conn = $db->getConnection();
    $lc = new UsuarioLogin();
    $isusuario = $lc->autenticarUsuario2($username, $password);

    if ($isusuario['success']) {
        $rol = $isusuario['TipoUsuario_id'];

        switch ($rol) {
            case 1:
                $_SESSION['rol_1'] = $rol;
                header('location: ../views/admin/dashboard.php');
                exit();
            case 2:
                $_SESSION['rol_2'] = $rol;
                header('location: ../views/stock/dashboard.php');
                exit();
            case 3:
                $_SESSION['rol_3'] = $rol;
                header('location: ../views/ventas/dashboard.php');
                exit();
        }
    } else {
        $error_message = "Usuario o contraseña incorrecta";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/login.css">
    <title>Farmaceutica</title>
</head>
<body>
    <div class="login-box">
        <div class="login-header">
            
            <img src="../../public/img/logo/logo_blanco.png" alt="Descripción de la imagen" width="80" height="50">
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="input-box">
                <input id="username" type="text" name="username" class="input-field" placeholder="Usuario" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input id="password" type="password" name="password" class="input-field" placeholder="Contraseña" autocomplete="off" required>
            </div>
            <?php if (!empty($error_message)): ?>
            <div id="error-message" class="error-message"><?= $error_message ?></div>
            <?php endif; ?>
            <div class="input-submit">
                <button class="submit-btn" type="submit">Ingresar</button>
            </div>
        </form>
    </div>
</body>
</html>
