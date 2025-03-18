<?php

// Impostazione degli header HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Inclusione dei file necessari
include_once '../config/database.php';
include_once '../models/country_travel.php';
include_once '../models/travel.php';
include_once '../models/country.php';

// Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

// Recupero dei dati inviati con il POST
$input = file_get_contents("php://input");
$data = json_decode($input, true); // Usa array associativo

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(array("error" => json_last_error_msg())); 
    exit();
}

// Creazione dell'oggetto Travel
if(isset($data["Travel"]) && isset($data["Places_Avables"])) {
    $travel = new Travel($db);
    $travel->Travel = $data["Travel"];
    $travel->Places_Avables = $data["Places_Avables"];

    if($travel->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Viaggio creato correttamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare il Viaggio."));
    }
} 

// Creazione dell'oggetto Country
if(isset($data["Country"])) {
    $country = new Country($db);
    $country->Country = $data["Country"];

    if($country->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Paese creato correttamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare il Paese."));
    }
}

// Creazione dell'oggetto Country_Travel
if(isset($data["idTravel"]) && isset($data["idCountry"])) {
    $country_travel = new Country_Travel($db);
    $country_travel->idTravel = $data["idTravel"];
    $country_travel->idCountry = $data["idCountry"];

    if($country_travel->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Paese_Viaggio creato correttamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare il Paese_Viaggio."));
    }
}

?>
