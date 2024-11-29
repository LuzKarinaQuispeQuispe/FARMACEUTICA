<?php

class Usuario {
    private $conn;
    private $table_name = "usuario";

    public $idUsuario;
    public $Usua;
    public $Contraseña;
    public $Nombre;
    public $TipoUsuario_id;
    public $logUsuario;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorUsuario($usua) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Usua = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $usua);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
