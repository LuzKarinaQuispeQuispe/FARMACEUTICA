<?php
require_once(realpath(__DIR__ . '/../../config/conection.php'));
require_once(realpath(__DIR__ . '/../models/usuario.php'));

class UsuarioLogin {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function autenticarUsuario($jsonCredenciales) {
        $credenciales = json_decode($jsonCredenciales, true);

        if (!$credenciales) {
            return [
                'success' => false,
                'message' => 'Invalid JSON'
            ];
        }

        $usua = $credenciales['username'];
        $contraseña = $credenciales['password'];

        $usuarioData = $this->usuario->obtenerPorUsuario($usua);
        if ($usuarioData && password_verify($contraseña, $usuarioData['Contraseña'])) {
            $this->usuario->idUsuario = $usuarioData['idUsuario'];
            $this->usuario->logUsuario = 1;
            $this->usuario->actualizarLogUsuario();
            
            return [
                'success' => true,
                'idUsuario' => $this->usuario->idUsuario,
                'Nombre' => $usua,
                'TipoUsuario_id' => $usuarioData['TipoUsuario_id']
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Usuario o contraseña incorrectos'
            ];
        }
    }

    public function autenticarUsuario2($username, $password) {
        $usuarioData = $this->usuario->obtenerPorUsuario($username);
    
        if ($usuarioData && password_verify($password, $usuarioData['Contraseña'])) {

            $this->usuario->idUsuario = $usuarioData['idUsuario'];
            $this->usuario->logUsuario = 1;

            return [
                'success' => true,
                'idUsuario' => $this->usuario->idUsuario,
                'Nombre' => $username,
                'TipoUsuario_id' => $usuarioData['TipoUsuario_id']
            ];
        } else {
            return [
                'success' => false,
            ];
        }
    }
}
