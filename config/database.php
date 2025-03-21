<?php
class Database {
    // Credenziali del database
    private $host = "localhost";
    private $db_name = "OrizonTravel";
    private $username = "root";
    private $password = "root";
    public $conn;

    // Connessione al database
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Errore di connessione: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>