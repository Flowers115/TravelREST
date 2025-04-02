<?php

require_once 'config/database.php';

class Travel {
    private $conn;
    private $table_name = "Travel";

    // Proprietà di un viaggio
    public $idTravel;
    public $Travel;
    public $Places_Avables;

    // Costruttore
    public function __construct($db) {
        $this->conn = $db;
    }

    //Metodo per leggere tutti i viaggi
    public function getAll($country = null) {
        $query = "SELECT idTravel, Travel, Places_Avables FROM " . $this->table_name;
        
        if ($country) {
            $query .= " WHERE Travel LIKE :country";
        }
    
        $stmt = $this->conn->prepare($query);
    
        if ($country) {
            $country = "%" . $country . "%"; // Per cercare il paese in qualsiasi parte della stringa
            $stmt->bindParam(':country', $country);
        }
    
        $stmt->execute();
        return $stmt;
    }    

    // Metodo per leggere un singolo viaggio
    public function read() {
        $query = "SELECT idTravel, Travel, Places_Avables FROM " . $this->table_name . " WHERE idTravel = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->idTravel);
        $stmt->execute();
        return $stmt;
    }

    // Metodo per creare un nuovo viaggio
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (Travel, Places_Avables) VALUES (:travel, :places_avables)";
        $stmt = $this->conn->prepare($query);
    
        // Sanitizzazione degli input
        $this->Travel = isset($this->Travel) ? htmlspecialchars(strip_tags($this->Travel)) : '';
        $this->Places_Avables = isset($this->Places_Avables) ? htmlspecialchars(strip_tags($this->Places_Avables)) : 0;
    
        // Binding dei parametri
        $stmt->bindParam(":travel", $this->Travel);
        $stmt->bindParam(":places_avables", $this->Places_Avables, PDO::PARAM_INT);
    
        // Esecuzione della query
        if ($stmt->execute()) {
            return true;
        }   
        return false;
    }    

    // Metodo per aggiornare un viaggio esistente
    function update() {
        $query = "UPDATE " . $this->table_name . " 
        SET Travel = :travel, Places_Avables = :places_avables 
        WHERE idTravel = :idTravel";
        $stmt = $this->conn->prepare($query);
    
        // Sanitizzazione degli input
        $this->idTravel = htmlspecialchars(strip_tags($this->idTravel));
        $this->Travel = htmlspecialchars(strip_tags($this->Travel));
        $this->Places_Avables = isset($this->Places_Avables) ? htmlspecialchars(strip_tags($this->Places_Avables)) : 0;


        // Binding dei parametri
        $stmt->bindParam(":idTravel", $this->idTravel);
        $stmt->bindParam(":travel", $this->Travel);
        $stmt->bindParam(":places_avables", $this->Places_Avables, PDO::PARAM_INT);


        // Esecuzione della query e controllo errore
        if ($stmt->execute()) {
            return true;
        } else {
            // Recupero dell'errore SQL
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["message" => "Impossibile aggiornare il Viaggio.", "error" => $errorInfo]);
            return false;
        }
    }    

    // Metodo per cancellare un viaggio
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTravel = :idTravel";
        $stmt = $this->conn->prepare($query);
    
        $this->idTravel = htmlspecialchars(strip_tags($this->idTravel));
        $stmt->bindParam(":idTravel", $this->idTravel, PDO::PARAM_INT);
    
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
