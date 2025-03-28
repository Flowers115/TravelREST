<?php

require_once 'config/database.php';

class Country_Travel {
    private $conn;
    private $table_name = "Travel_Country";

    // Proprietà di un Viaggio_Paese
    public $idTravel;
    public $idCountry;

    // Costruttore
    public function __construct($db) {
        $this->conn = $db;
    }

    // Leggere i Viaggio_Paese dal database
    function read() {
        // Query per selezionare tutti i Viaggio_Paese
        $query = "SELECT idTravel, idCountry FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Metodo per creare un nuovo Viaggio_Paese
    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET idTravel=:idtravel, idCountry=:idcountry";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione degli input
        $this->idTravel = htmlspecialchars(strip_tags($this->idTravel));
        $this->idCountry = htmlspecialchars(strip_tags($this->idCountry));

        // Binding dei parametri
        $stmt->bindParam(":idtravel", $this->idTravel);
        $stmt->bindParam(":idcountry", $this->idCountry);

        // Esecuzione della query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Metodo per aggiornare un Viaggio_Paese esistente
    function update() {
        $query = "UPDATE " . $this->table_name . " SET idCountry = :idcountry WHERE idTravel = :idtravel";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione degli input
        $this->idTravel = htmlspecialchars(strip_tags($this->idTravel));
        $this->idCountry = htmlspecialchars(strip_tags($this->idCountry));

        // Binding dei parametri
        $stmt->bindParam(":idtravel", $this->idTravel);
        $stmt->bindParam(":idcountry", $this->idCountry);

        // Esecuzione della query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Metodo per cancellare un Viaggio_Paese
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTravel = ?";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione dell'input
        $this->idTravel = htmlspecialchars(strip_tags($this->idTravel));

        // Binding del parametro
        $stmt->bindParam(1, $this->idTravel);

        // Esecuzione della query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>