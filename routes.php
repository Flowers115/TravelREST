<?php


// Includi i controller
require_once 'controllers/countryController.php';
require_once 'controllers/travelController.php';

// Ottieni il metodo HTTP (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Debugging: verifica il metodo e i parametri ricevuti
// var_dump($method, $_GET);
// exit;

// Ottieni l'azione dalla URL
$action = isset($_GET['action']) ? $_GET['action'] : null; 

// Controlliamo che l'azione sia stata fornita
if (!$action) {
    echo json_encode(["message" => "Azione non valida!"]);
    exit;
}

// Gestisci la richiesta per i paesi (country)
if (isset($_GET['action'])) {
    $countryController = new CountryController();

    switch ($action) {
        case 'index':
            if ($method === 'GET') {
                $countryController->index();
            }
            break;

        case 'read':
            if ($method === 'GET' && isset($_GET['id'])) {
                $countryController->read($_GET['id']);
            }
            break;

        case 'create':
            if ($method === 'POST') {
                $countryController->create($_POST);
            }
            break;

        case 'update':
            if ($method === 'PUT' && isset($_GET['id'])) {
                // Leggi i dati JSON dal body della richiesta
                $data = json_decode(file_get_contents("php://input"), true);
                if (!$data) {
                    echo json_encode(["message" => "Dati non validi o mancanti nel corpo della richiesta."]);
                    exit;
                }
                $countryController->update($_GET['id'], $data);
            }
            break;

        case 'delete':
            case 'delete':
                if ($method === 'DELETE' && isset($_GET['id'])) {
                    
                    $countryController = new CountryController();
                    $countryController->delete($_GET['id']);
                }
                break;
            }            
}
// Gestisci le richieste per i viaggi (travel)
else if (isset($_GET['action']) && $_GET['action'] === 'travel') {
    // Routing per i viaggi
    switch ($action) {
        case 'index':
            if ($method === 'GET') {
                $travelController = new TravelController();
                $travelController->index();
            }
            break;

        case 'read':
            if ($method === 'GET' && isset($_GET['id'])) {
                $travelController = new TravelController();
                $travelController->read($_GET['id']);
            }
            break;

        case 'create':
            if ($method === 'POST') {
                $travelController = new TravelController();
                $travelController->create($_POST);
            }
            break;

        case 'update':
            if ($method === 'PUT' && isset($_GET['id'])) {
                $travelController = new TravelController();
                parse_str(file_get_contents("php://input"), $data);  // Leggi i dati dalla richiesta PUT
                $travelController->update($_GET['id'], $data);  // Passa l'ID e i dati per l'aggiornamento
            }
            break;

        case 'delete':
            if ($method === 'DELETE' && isset($_GET['id'])) {
                $travelController = new TravelController();
                $travelController->delete($_GET['id']);
            }
            break;

        default:
            echo json_encode(["message" => "Azione non trovata per i viaggi!"]);
    }
} 
// Se non viene trovata nessuna azione valida
else {
    echo json_encode(["message" => "Azione non valida!"]);
}
