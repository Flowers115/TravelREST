<?php

// Impostazione degli header HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Inclusione dei file necessari
include_once '../config/database.php';
include_once '../models/country_travel.php';
include_once '../models/country.php';
include_once '../models/travel.php';

// Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

// Recupero dei dati inviati con DELETE
$input = file_get_contents("php://input");
$data = json_decode($input, true); // Usa array associativo

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => json_last_error_msg()]);
    exit();
}

// Eliminazione di una relazione tra Paese e Viaggio
if (!empty($data["idTravel"]) && !empty($data["idCountry"])) {
    $country_travel = new Country_Travel($db);
    $country_travel->idTravel = $data["idTravel"];
    $country_travel->idCountry = $data["idCountry"];

    if ($country_travel->delete()) {
        echo json_encode(["risposta" => "Relazione Paese-Viaggio eliminata"]);
    } else {
        echo json_encode(["risposta" => "Impossibile eliminare la relazione"]);
    }
    exit;
}

// Eliminazione di un Paese
if (!empty($data["Country"])) {
    $country = new Country($db);
    $country->Country = $data["Country"];

    if ($country->delete()) {
        echo json_encode(["risposta" => "Paese eliminato"]);
    } else {
        echo json_encode(["risposta" => "Impossibile eliminare il Paese"]);
    }
    exit;
}

// Eliminazione di un Viaggio
if (!empty($data["Travel"])) {
    $travel = new Travel($db);
    $travel->Travel = $data["Travel"];

    if ($travel->delete()) {
        echo json_encode(["risposta" => "Viaggio eliminato"]);
    } else {
        echo json_encode(["risposta" => "Impossibile eliminare il Viaggio"]);
    }
    exit;
}

// Se nessun dato valido è stato fornito
http_response_code(400);
echo json_encode(["errore" => "Dati insufficienti per eliminare un Paese, Viaggio o Relazione"]);

?>
