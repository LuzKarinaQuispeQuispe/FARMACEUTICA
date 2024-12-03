<?php

class Database {
    private $host = "161.35.224.168";
    private $dsn = "mysql:host=161.35.224.168;dbname=esis-farmacia";
    private $db_name = "esis-farmacia";
    private $username = "dev1";
    private $password = "ESIS_2024_dev1";
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
