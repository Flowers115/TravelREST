<?php
require_once __DIR__ . '/../models/travel_country.php';

class TravelCountryController {
    private $Travel_Country;

    public function __construct() {
        $this->Travel_Country = new TravelCountry(Database::getConnection());
    }

    // Aggiungere un paese a un viaggio
    public function create($data) {
        if (!isset($data['idTravel']) || !isset($data['idCountry'])) {
            echo json_encode(["message" => "ID viaggio e ID paese sono richiesti."]);
            return;
        }

        $this->Travel_Country->idTravel = $data['idTravel'];
        $this->Travel_Country->idCountry = $data['idCountry'];

        if ($this->Travel_Country->create()) {
            echo json_encode(["message" => "Associazione creata."]);
        } else {
            echo json_encode(["message" => "Errore nella creazione dell'associazione."]);
        }
    }

    // Eliminare un'associazione
    public function delete($data) {
        if (!isset($data['idTravel']) || !isset($data['idCountry'])) {
            echo json_encode(["message" => "ID viaggio e ID paese sono richiesti."]);
            return;
        }

        $this->Travel_Country->idTravel = $data['idTravel'];
        $this->Travel_Country->idCountry = $data['idCountry'];

        if ($this->Travel_Country->delete()) {
            echo json_encode(["message" => "Associazione eliminata."]);
        } else {
            echo json_encode(["message" => "Errore nella cancellazione dell'associazione."]);
        }
    }

    // Ottenere tutti i paesi per un viaggio
    public function getCountriesByTravel($idTravel) {
        $this->Travel_Country->idTravel = $idTravel;
        $stmt = $this->Travel_Country->getCountriesByTravel();

        if ($stmt->rowCount() > 0) {
            $countries = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $countries[] = $row;
            }
            echo json_encode($countries);
        } else {
            echo json_encode(["message" => "Nessun paese associato a questo viaggio."]);
        }
    }
}
?>
