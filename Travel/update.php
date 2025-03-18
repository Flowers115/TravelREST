<?php
// Headers per la gestione delle richieste HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

ob_start(); // Avvia l'output buffering

include_once '../config/database.php';
include_once '../models/country_travel.php';
include_once '../models/country.php';
include_once '../models/travel.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();

// Recupero dei dati inviati con il POST
$input = file_get_contents("php://input");
$data = json_decode($input, true); // Usa array associativo

if (json_last_error() !== JSON_ERROR_NONE) {
    ob_end_clean();
    echo json_encode(["error" => json_last_error_msg()]);
    exit;
}

// Aggiornamento di Country_Travel
if (isset($data["idTravel"], $data["idCountry"])) {
    $country_travel = new Country_Travel($db);
    $country_travel->idTravel = $data["idTravel"];
    $country_travel->idCountry = $data["idCountry"];

    ob_end_clean();
    if ($country_travel->update()) {
        echo json_encode(["risposta" => "Paese_Viaggio aggiornato"]);
    } else {
        echo json_encode(["risposta" => "Impossibile aggiornare il Paese_Viaggio"]);
    }
    exit;
}

// Aggiornamento di Country
if (!empty($data["Country"])) { // Controlla che il campo esista e non sia vuoto
    $country = new Country($db);
    $country->Country = strip_tags($data["Country"]); // Sanitizza il dato

    ob_end_clean();
    if ($country->update()) {
        echo json_encode(["risposta" => "Paese aggiornato"]);
    } else {
        echo json_encode(["risposta" => "Impossibile aggiornare il Paese"]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["errore" => "Il campo 'Country' è vuoto o mancante"]);
}
exit;


// Aggiornamento di Travel
if (!empty($data["Travel"])) { // Controlla che il campo esista e non sia vuoto
    $travel = new Travel($db);
    $travel->Travel = strip_tags($data["Travel"]); // Sanitizza il dato

    ob_end_clean();
    if ($travel->update()) {
        echo json_encode(["risposta" => "Viaggio aggiornato"]);
    } else {
        echo json_encode(["risposta" => "Impossibile aggiornare il Viaggio"]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["errore" => "Il campo 'Travel' è vuoto o mancante"]);
}
exit;


// Se nessun aggiornamento è stato eseguito
ob_end_clean();
http_response_code(400);
echo json_encode(["risposta" => "Dati mancanti o errati per l'aggiornamento"]);
exit;

?>
