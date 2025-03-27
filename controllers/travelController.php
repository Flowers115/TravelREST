<?php
require_once __DIR__ . '/../models/travel.php';

class TravelController {

    // Mostra tutti i viaggi (Read All)
    public function index() {
        $destinations = Travel::getAll(); //Travel è la classe presente in models/travel.php
        echo json_encode($destinations); // Restituisce i dati come JSON
    }    

    // Mostra un singol viaggio (Read One)
    public function read($id) {
        $destination = Travel::getById($id);
        echo json_encode($destination); // Restituisce i dati come JSON
    }    

    // Aggiunge un nuovo viaggio (Create)
    public function create($data) {
        $result = Travel::insert($data);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Viaggio aggiunto con successo']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'aggiunta del viaggio']);
        }
    }    

    // Modifica un viaggio esistente (Update)
    public function update($id, $data) {
        $result = Travel::updateById($id, $data);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Viaggio aggiornato con successo']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'aggiornamento del viaggio']);
        }
    }    

    // Elimina un viaggio (Delete)
    public function delete($id) {
        $result = Travel::deleteById($id);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Viaggio eliminato con successo']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'eliminazione del viaggio']);
        }
    }    
}
?>
