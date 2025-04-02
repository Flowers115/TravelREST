<?php
require_once 'controllers/travelController.php';
require_once 'controllers/countryController.php';
require_once 'controllers/travel_countryController.php';
require_once 'config/database.php';

date_default_timezone_set('UTC');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
$resource = isset($_GET['resource']) ? $_GET['resource'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;

if (!$resource) {
    echo json_encode(["message" => "Risorsa non specificata (usa ?resource=country o ?resource=travel)."]);
    exit;
}

switch ($resource) {
    case 'travel':
        $travelController = new TravelController();
        switch ($action) {
            case 'create':
                if ($method === 'POST') {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $travelController->create($data);
                }
                break;
            case 'read':
                if ($method === 'GET') {
                    if (isset($_GET['id'])) {
                        $travelController->read($_GET['id']);
                    } else {
                        $travelController->readAll();
                    }
                }
                break;
            case 'update':
                if ($method === 'PUT') {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $travelController->update($data);
                }
                break;
            case 'delete':
                if ($method === 'DELETE' && isset($_GET['id'])) {
                    $travelController->delete($_GET['id']);
                }
                break;
        }
        break;
    
    case 'country':
        $countryController = new CountryController();
        switch ($action) {
            case 'create':
                if ($method === 'POST') {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $countryController->create($data);
                }
                break;
            case 'read':
                if ($method === 'GET') {
                    if (isset($_GET['id'])) {
                        $countryController->read($_GET['id']);
                    } else {
                        $countryController->readAll();
                    }
                }
                break;
            case 'update':
                if ($method === 'PUT') {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $countryController->update($data);
                }
                break;
            case 'delete':
                if ($method === 'DELETE' && isset($_GET['id'])) {
                    $countryController->delete($_GET['id']);
                }
                break;
        }
        break;
    
    case 'travel_country':  // Modificato da country_travel a travel_country
        $travelCountryController = new TravelCountryController();
        switch ($action) {
            case 'create':
                if ($method === 'POST') {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $travelCountryController->create($data);
                }
                break;
            case 'delete':
                if ($method === 'DELETE') {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $travelCountryController->delete($data);
                }
                break;
            case 'get_countries':
                if ($method === 'GET' && isset($_GET['idTravel'])) {
                    $travelCountryController->getCountriesByTravel($_GET['idTravel']);
                }
                break;
        }
        break;
    
    default:
        echo json_encode(["message" => "Risorsa non riconosciuta."]);
        break;
    }
?>