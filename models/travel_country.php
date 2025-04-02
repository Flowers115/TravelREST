<?php
require_once 'config/database.php';

class TravelCountry {
    private $conn;
    private $table_name = "Travel_Country";

    public $idTravel;
    public $idCountry;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Associare un paese a un viaggio
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (idTravel, idCountry) VALUES (:idTravel, :idCountry)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idTravel", $this->idTravel);
        $stmt->bindParam(":idCountry", $this->idCountry);

        return $stmt->execute();
    }

    // Rimuovere un paese da un viaggio
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTravel = :idTravel AND idCountry = :idCountry";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idTravel", $this->idTravel);
        $stmt->bindParam(":idCountry", $this->idCountry);

        return $stmt->execute();
    }

    // Ottenere tutti i paesi di un viaggio
    public function getCountriesByTravel() {
        $query = "SELECT c.idCountry, c.Country 
                  FROM Travel_Country ct
                  JOIN Country c ON ct.idCountry = c.idCountry
                  WHERE ct.idTravel = :idTravel";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":idTravel", $this->idTravel);
        $stmt->execute();
        return $stmt;
    }
}
?>
