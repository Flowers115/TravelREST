<?php
require_once __DIR__ . '/../models/country.php';

class CountryController {
    private $country;

    public function __construct() {        
        // Crea una nuova istanza del modello Country
        $this->country = new Country(Database::getConnection());
    }

    // Mostra tutti i paesi (Read All)
    public function index() {
        // Ottieni la connessione al database
        $database = new Database();
        $db = $database->getConnection();

        // Crea un oggetto Country e chiama il metodo getAll() passando la connessione
        $country = new Country($db);
        $stmt = $country->getAll($db);  // Passa $db come parametro

        // Verifica che ci siano risultati
        if($stmt->rowCount() > 0) {
            $countries_arr = array();
            $countries_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $country_item = array(
                    "idCountry" => $idCountry,
                    "Country" => $Country
                );
                array_push($countries_arr["records"], $country_item);
            }

            // Restituisci i dati in formato JSON
            echo json_encode($countries_arr);
        } else {
            echo json_encode(array("message" => "Nessun paese trovato."));
        }
    }

    // Mostra un singolo paese (Read One)
    public function read($id) {
        // Ottieni la connessione al database
        $database = new Database();
        $db = $database->getConnection();

        // Crea un oggetto Country e chiama il metodo read() per un singolo paese
        $country = new Country($db);
        $country->idCountry = $id;
        $stmt = $country->read();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $country_item = array(
                "idCountry" => $idCountry,
                "Country" => $Country
            );

            // Restituisci i dati in formato JSON
            echo json_encode($country_item);
        } else {
            echo json_encode(array("message" => "Paese non trovato."));
        }
    }

    // Aggiunge un nuovo paese (Create)
    public function create($data) {
        // Decodifica i dati in caso di formato JSON
        $data = json_decode(file_get_contents("php://input"), true);
            
        if (!isset($data['Country']) || empty($data['Country'])) {
            echo json_encode(["message" => "Paese richiesto."]);
            return;
        }
    
        $country = new Country(Database::getConnection());
        $country->Country = $data['Country'];
    
        if ($country->create()) {
            echo json_encode(["message" => "Paese creato."]);
        } else {
            echo json_encode(["message" => "Impossibile creare un paese."]);
        }
    }

    // Aggiornamento un paese esistente (Update)
    public function update($id, $data) {
        // Decodifica i dati in caso di formato JSON
    
        if (!isset($data['Country']) || empty($data['Country'])) {
            echo json_encode(["message" => "Paese richiesto."]);
            return;
        }
    
        // Crea l'oggetto Country
        $country = new Country(Database::getConnection());
        $country->idCountry = $id;
        $country->Country = $data['Country'];

        // Prova ad aggiornare il paese
        if ($country->update()) {
            echo json_encode(["message" => "Paese aggiornato."]);
        } else {
            echo json_encode(["message" => "Impossibile aggiornare il paese."]);
        }
    }   

    // Elimina un paese (Delete)
    public function delete($id) {
        $country = new Country(Database::getConnection());
        $country->idCountry = $id;
        
        if ($country->delete()) {
            echo json_encode(["message" => "Paese cancellato con successo."]);
        } else {
            echo json_encode(["message" => "Fallimento nella cancellazione del paese."]);
        }
    }
    
    
}
?>
