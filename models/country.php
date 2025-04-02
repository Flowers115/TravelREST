<?php

require_once 'config/database.php';

class Country {
    private $conn;
    private $table_name = "Country";

    // Proprietà di un paese
    public $idCountry;
    public $Country;

    // Costruttore
    public function __construct($db) {
        $this->conn = $db;
    }

    //Metodo per leggere tutti i paesi
    public function getAll() {
        $query = "SELECT idCountry, Country FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Metodo per leggere un singolo paese
    public function read() {
        $query = "SELECT idCountry, Country FROM " . $this->table_name . " WHERE idCountry = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->idCountry);
        $stmt->execute();
        return $stmt;
    }

    // Metodo per creare un nuovo paese
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET Country = :country";
        $stmt = $this->conn->prepare($query);
    
        // Sanitizzazione degli input
        $this->Country = isset($this->Country) ? htmlspecialchars(strip_tags($this->Country)) : '';
    
        // Binding del parametro
        $stmt->bindParam(":country", $this->Country);
    
        // Esecuzione della query
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }    

    // Metodo per aggiornare un paese esistente
    function update() {
        $query = "UPDATE " . $this->table_name . " SET Country = :country WHERE idCountry = :idcountry";
        $stmt = $this->conn->prepare($query);
    
        // Sanitizzazione degli input
        $this->idCountry = htmlspecialchars(strip_tags($this->idCountry));
        $this->Country = htmlspecialchars(strip_tags($this->Country));

        // Binding dei parametri
        $stmt->bindParam(":idcountry", $this->idCountry);
        $stmt->bindParam(":country", $this->Country);
    
        // Esecuzione della query e controllo errore
        if ($stmt->execute()) {
            return true;
        } else {
            // Recupero dell'errore SQL
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["message" => "Impossibile aggiornare il paese.", "error" => $errorInfo]);
            return false;
        }
    }    

    // Metodo per cancellare un paese
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idCountry = :idCountry";
        $stmt = $this->conn->prepare($query);
    
        $this->idCountry = htmlspecialchars(strip_tags($this->idCountry));
        $stmt->bindParam(":idCountry", $this->idCountry, PDO::PARAM_INT);
    
        // Esegui la query
        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["message" => "Cancellazione fallita", "error" => $errorInfo]);
            return false;
        }
    }  
}
?>