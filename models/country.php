<?php
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

    // Leggere i paesi dal database
    function read() {
        // Query per selezionare tutti i paesi
        $query = "SELECT idCountry, Country FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    // Metodo per creare un nuovo paese
    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET Country = :country";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione degli input
        $this->Country = htmlspecialchars(strip_tags($this->Country));

        // Binding dei parametri
        $stmt->bindParam(":country", $this->Country);

        // Esecuzione della query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Metodo per aggiornare un paese esistente
    function update() {
        $query = "UPDATE " . $this->table_name . " SET Country = :country WHERE IdCountry = :idcountry";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione degli input
        $this->idCountry = isset($this->idCountry) ? strip_tags($this->idCountry) : '';
        $this->Country = isset($this->Country) ? strip_tags($this->Country) : '';

        // Binding dei parametri
        $stmt->bindParam(":idcountry", $this->idCountry);
        $stmt->bindParam(":country", $this->Country);

        // Esecuzione della query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Metodo per cancellare un paese
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE Country = ?";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione dell'input
        $this->Country = htmlspecialchars(strip_tags($this->Country));

        // Binding del parametro
        $stmt->bindParam(1, $this->Country);

        // Esecuzione della query
        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>