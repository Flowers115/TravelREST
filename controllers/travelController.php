<?php
require_once __DIR__ . '/../models/travel.php';

class TravelController {
    private $travel;

    public function __construct() {        
        // Crea una nuova istanza del modello Travel
        $this->travel = new Travel(Database::getConnection());
    }

    // Mostra tutti i Viaggi (Read All)
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
    
        $travel = new Travel($db);
    
        // Controlla se è stato fornito un parametro "country"
        $country = isset($_GET['country']) ? $_GET['country'] : null;
    
        $stmt = $travel->getAll($country);
    
        if ($stmt->rowCount() > 0) {
            $travels_arr = array();
            $travels_arr["records"] = array();
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $travel_item = array(
                    "idTravel" => $idTravel,
                    "Travel" => $Travel,
                    "Places_Avables" => $Places_Avables
                );
                array_push($travels_arr["records"], $travel_item);
            }
    
            echo json_encode($travels_arr);
        } else {
            echo json_encode(array("message" => "Nessun viaggio trovato."));
        }
    }
    // Mostra un singolo viaggio (Read One)
    public function read($id) {
        // Ottieni la connessione al database
        $database = new Database();
        $db = $database->getConnection();

        // Crea un oggetto Travel e chiama il metodo read() per un singolo viaggio
        $travel = new Travel($db);
        $travel->idTravel = $id;
        $stmt = $travel->read();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $travels_item = array(
                "idTravel" => $idTravel,
                "Travel" => $Travel,
                "Places_Avables" => $Places_Avables
            );

            // Restituisci i dati in formato JSON
            echo json_encode($travels_item);
        } else {
            echo json_encode(array("message" => "Viaggio non trovato."));
        }
    }

    // Aggiunge un nuovo Viaggio (Create)
    public function create($data) {
        // Decodifica i dati in caso di formato JSON
        $data = json_decode(file_get_contents("php://input"), true);
            
        if (!isset($data['Travel']) || empty($data['Travel'])) {
            echo json_encode(["message" => "Viaggio richiesto."]);
            return;
        }
    
        $travel = new Travel(Database::getConnection());
        $travel->Travel = $data['Travel'];
        $travel->Places_Avables = isset($data['Places_Avables']) ? $data['Places_Avables'] : 0;
    
        if ($travel->create()) {
            echo json_encode(["message" => "Viaggio creato."]);
        } else {
            echo json_encode(["message" => "Impossibile creare il viaggio."]);
        }
    }

    // Aggiornamento di un viaggio esistente (Update)
    public function update($id, $data) {
        // Decodifica i dati in caso di formato JSON
    
        if (!isset($data['Travel']) || empty($data['Travel'])) {
            echo json_encode(["message" => "Viaggio richiesto."]);
            return;
        }
    
        // Crea l'oggetto Travel
        $travel = new Travel(Database::getConnection());
        $travel->idTravel = $id;
        $travel->Travel = $data['Travel'];

        // Prova ad aggiornare il viaggio
        if ($travel->update()) {
            echo json_encode(["message" => "Viaggio aggiornato."]);
        } else {
            echo json_encode(["message" => "Impossibile aggiornare il viaggio."]);
        }
    }   

    // Elimina un viaggio (Delete)
    public function delete($id) {
        $travel = new Travel(Database::getConnection());
        $travel->idTravel = $id;
        
        if ($travel->delete()) {
            echo json_encode(["message" => "Viaggio cancellato con successo."]);
        } else {
            echo json_encode(["message" => "Impossibile camcellare il viaggio."]);
        }
    }  
}
?>
