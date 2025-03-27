<?php
require_once __DIR__ . '/../models/country.php';

class CountryController {

    // Mostra tutti i paesi (Read All)
    public function index() {
        $destinations = Country::getAll(); //Country è la classe in models/country.php
        echo json_encode($destinations); // Restituisce i dati come JSON
    }    

    // Mostra un singolo paese (Read One)
    public function read($id) {
        $destination = Country::getById($id); 
        echo json_encode($destination); // Restituisce i dati come JSON
    }    

    // Aggiunge un nuovo paese (Create)
    public function create($data) {
        $result = Country::insert($data); 
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Paese aggiunto con successo']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'aggiunta del paese']);
        }
    }    

    // Modifica un paese esistente (Update)
    public function update($id, $data) {
        $result = Country::updateById($id, $data);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Paese aggiornato con successo']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'aggiornamento del paese']);
        }
    }    

    // Elimina un paese (Delete)
    public function delete($id) {
        $result = Country::deleteById($id);
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Destinazione eliminata con successo']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Errore durante l\'eliminazione della destinazione']);
        }
    }    
}
?>
