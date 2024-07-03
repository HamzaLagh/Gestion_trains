<?php
session_start(); 
include 'php/db_connect.php'; // Assurez-vous d'inclure votre fichier de connexion à la base de données

header('Content-Type: application/json'); // Définir l'en-tête de la réponse comme JSON

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['train_id'])) {
    $trainId = $_POST['train_id'];
    $trainNumber = $_POST['train_number'];
    $departureTime = $_POST['departure_time'];
    $arrivalTime = $_POST['arrival_time'];
    $nature_id = $_POST['nature_id'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $track = $_POST['track'];
    $option = $_POST['option'];

    // Vérifier si le numéro de train est unique
    $sql_check_number = "SELECT id FROM trains WHERE number = '$trainNumber' AND id != '$trainId'";
    $result_check_number = $conn->query($sql_check_number);

    if ($result_check_number->num_rows > 0) {
        $response['error'] = 'Le numéro du train est déjà utilisé.';
    } else {
        // Vérifier si une entrée existe déjà pour la même voie et le même intervalle de temps, sauf pour le train actuel
        $sql_check = "
            SELECT * FROM trains
            WHERE track = '$track'
            AND id != '$trainId'
            AND (
                (departure_time >= '$departureTime' AND departure_time < '$arrivalTime')
                OR (arrival_time > '$departureTime' AND arrival_time <= '$arrivalTime')
                OR ('$departureTime' >= departure_time AND '$departureTime' < arrival_time)
            )";
        
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $response['error'] = 'Cette voie est déjà occupée par un train pendant cet intervalle de temps.';
        } else {
            // Sinon, mettez à jour le train
            $sql_update = "
                UPDATE trains SET 
                    number = '$trainNumber', 
                    departure_time = '$departureTime', 
                    arrival_time = '$arrivalTime', 
                    nature_id = '$nature_id', 
                    origin = '$origin', 
                    destination = '$destination', 
                    track = '$track', 
                    option = '$option'
                WHERE id = $trainId";
            
            if ($conn->query($sql_update) === TRUE) {
                $response['success'] = 'Train mis à jour avec succès.';
            } else {
                $response['error'] = 'Erreur lors de la mise à jour du train : ' . $conn->error;
            }
        }
    }

    $conn->close();
} else {
    $response['error'] = 'Erreur : Données de mise à jour du train non reçues.';
}

echo json_encode($response);
?>
