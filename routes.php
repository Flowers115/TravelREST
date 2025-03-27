<?php

// Includi i controller
require_once 'controllers/countryController.php';
require_once 'controllers/travelController.php';

// Ottieni il metodo HTTP (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Ottieni l'azione dalla URL
$action = isset($_GET['action']) ? $_GET['action'] : 'index';  // Default to 'index'

// Gestisci la richiesta per i paesi (country)
if (strpos($_SERVER['REQUEST_URI'], 'country') !== false) {
    // Routing per i paesi
    switch ($action) {
        case 'index':
            // Mostra tutti i paesi
            if ($method === 'GET') {
                $controller = new CountryController();
                $controller->index();
            }
            break;

        case 'read':
            // Mostra un singolo paese
            if ($method === 'GET' && isset($_GET['id'])) {
                $controller = new CountryController();
                $controller->read($_GET['id']);
            }
            break;

        case 'create':
            // Crea un paese
            if ($method === 'POST') {
                $controller = new CountryController();
                $controller->create($_POST);
            }
            break;

        case 'update':
            // Aggiorna un paese
            if ($method === 'POST' && isset($_POST['id'])) {
                $controller = new CountryController();
                $controller->update($_POST['id'], $_POST);
            }
            break;

        case 'delete':
            // Elimina un paese
            if ($method === 'GET' && isset($_GET['id'])) {
                $controller = new CountryController();
                $controller->delete($_GET['id']);
            }
            break;

        default:
            echo "Azione non trovata per i paesi!";
    }
}

// Gestisci le richieste per i viaggi (travel)
else if (strpos($_SERVER['REQUEST_URI'], 'travel') !== false) {
    // Routing per i viaggi
    switch ($action) {
        case 'index':
            if ($method === 'GET') {
                $controller = new TravelController();
                $controller->index();
            }
            break;

        case 'read':
            if ($method === 'GET' && isset($_GET['id'])) {
                $controller = new TravelController();
                $controller->read($_GET['id']);
            }
            break;

        case 'create':
            if ($method === 'POST') {
                $controller = new TravelController();
                $controller->create($_POST);
            }
            break;

        case 'update':
            if ($method === 'POST' && isset($_POST['id'])) {
                $controller = new TravelController();
                $controller->update($_POST['id'], $_POST);
            }
            break;

        case 'delete':
            if ($method === 'GET' && isset($_GET['id'])) {
                $controller = new TravelController();
                $controller->delete($_GET['id']);
            }
            break;

        default:
            echo "Azione non trovata per i viaggi!";
    }
} 

// Se non viene trovata nessuna azione valida
else {
    echo "Azione non valida!";
}
