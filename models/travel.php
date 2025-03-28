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

    // Leggere i viaggi dal database
    function read() {
        // Query per selezionare tutti i viaggi
        $query = "SELECT idTravel, Travel, Places_Avables FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Metodo getAll()
    public static function getAll($db) {
        // Crea un'istanza della classe Travel
        $travel = new Travel($db);
    
        // Richiama il metodo read() per ottenere i dati
        $stmt = $travel->read();
            
        $travel = [];
            
        // Itera sui risultati e restituisci un array di viaggi
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $travel_item = [
                'idTravel' => $idTravel,
                'Travel' => $Travel,
                'Places_Avables' => $Places_Avables
            ];
            array_push($travels, $travel_item);
        }
    
        return $travels;
    }

    // Metodo per creare un nuovo viaggio
    function create() {
        $query = "INSERT INTO " . $this->table_name . " (Travel, Places_Avables) VALUES (:travel, :places_avables)";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione degli input
        if (isset($this->Travel)) {
            $this->Travel = htmlspecialchars(strip_tags($this->Travel));
        }
        if (isset($this->Places_Avables)) {
            $this->Places_Avables = htmlspecialchars(strip_tags($this->Places_Avables));
        }

        // Binding dei parametri
        $stmt->bindParam(":travel", $this->Travel);
        $stmt->bindParam(":places_avables", $this->Places_Avables);

        // Esecuzione della query
        return $stmt->execute();
    }

    // Metodo per aggiornare un viaggio esistente
    function update() {
        $query = "UPDATE " . $this->table_name . " SET Travel = :travel, Places_Avables = :places_avables WHERE idTravel = :idtravel";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione degli input
        if (isset($this->idTravel)) {
            $this->idTravel = htmlspecialchars(strip_tags($this->idTravel));
        }
        if (isset($this->Travel)) {
            $this->Travel = htmlspecialchars(strip_tags($this->Travel));
        }
        if (isset($this->Places_Avables)) {
            $this->Places_Avables = htmlspecialchars(strip_tags($this->Places_Avables));
        }

        // Binding dei parametri
        $stmt->bindParam(":idtravel", $this->idTravel, PDO::PARAM_INT);
        $stmt->bindParam(":travel", $this->Travel);
        $stmt->bindParam(":places_avables", $this->Places_Avables);

        // Esecuzione della query
        return $stmt->execute();
    }

    // Metodo per cancellare un viaggio
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idTravel = :idtravel";
        $stmt = $this->conn->prepare($query);

        // Sanitizzazione dell'input
        if (isset($this->idTravel)) {
            $this->idTravel = htmlspecialchars(strip_tags($this->idTravel));
        }

        // Binding del parametro
        $stmt->bindParam(":idtravel", $this->idTravel, PDO::PARAM_INT);

        // Esecuzione della query
        return $stmt->execute();
    }
}
?>
