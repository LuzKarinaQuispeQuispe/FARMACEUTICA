<?php

class Database {
    private $host = "localhost";
    private $dsn = "mysql:host=localhost;dbname=farmacia_esis";
    private $db_name = "farmacia_esis";
    private $username = "root";
    private $password = "73008057";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
           
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>
