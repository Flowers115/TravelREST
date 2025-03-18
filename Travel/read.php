<?php
// Impostazione degli header HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Inclusione dei file necessari
include_once '../config/database.php';
include_once '../models/country_travel.php';
include_once '../models/country.php';
include_once '../models/travel.php';

// Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

// Creazione dell'oggetto country_travel
$country_travel = new Country_Travel($db);

// Esecuzione della query per leggere i country_travel
$stmt = $country_travel->read();
$num = $stmt->rowCount();

// Verifica se sono stati trovati country_travel
if($num > 0) {
    // Array per i country_travel
    $country_travel_arr = array();
    $country_travel_arr["records"] = array();

    // Recupero dei dati dei country_travel
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row); // Debug: controlla i dati
        echo "<br>";
    
        $country_travel_item = array(
            "country_travel" => $row["country_travel"] ?? "N/A", // Controlla se esiste
        );
        array_push($country_travel_arr["records"], $country_travel_item);
    }

    // Conversione in formato JSON e restituzione al client
    echo json_encode($country_travel_arr);
} else {
    // Nessun country_travel trovato
    echo json_encode(
        array("message" => "Nessun Paese o Viaggio Trovato.")
    );
}

// Creazione dell'oggetto travel
$travel = new Travel($db);

// Esecuzione della query per leggere i travel
$stmt = $travel->read();
$num = $stmt->rowCount();

// Verifica se sono stati trovati travel
if($num > 0) {
    // Array per i travel
    $travel_arr = array();
    $travel_arr["records"] = array();

    // Recupero dei dati dei travel
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row); // Debug: controlla i dati
        echo "<br>";
    
        $travel_item = array(
            "travel" => $row["Travel"] ?? "N/A",
            "places_available" => $row["Places_Avables"] ?? "N/A"
        );
        array_push($travel_arr["records"], $travel_item);
    }

    // Conversione in formato JSON e restituzione al client
    echo json_encode($travel_arr);
} else {
    // Nessun travel trovato
    echo json_encode(
        array("message" => "Nessun Viaggio Trovato.")
    );
}

// Creazione dell'oggetto country
$country = new Country($db);

// Esecuzione della query per leggere i country
$stmt = $country->read();
$num = $stmt->rowCount();

// Verifica se sono stati trovati country
if($num > 0) {
    // Array per i country
    $country_arr = array();
    $country_arr["records"] = array();

    // Recupero dei dati dei country
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row); // Debug: controlla i dati
        echo "<br>";
    
        $country_item = array(
            "country" => $row["Country"] ?? "N/A", // Controlla se esiste
        );
        array_push($country_arr["records"], $country_item);
    }

    // Conversione in formato JSON e restituzione al client
    echo json_encode($country_arr);
} else {
    // Nessun country trovato
    echo json_encode(
        array("message" => "Nessun Paese Trovato.")
    );
}
?>