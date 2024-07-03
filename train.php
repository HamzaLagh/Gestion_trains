<?php
session_start();
include 'php/db_connect.php'; // Assurez-vous d'inclure votre fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $train_number = $_POST['number'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $nature_id = $_POST['nature_id'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $track = $_POST['track'];
    $option = $_POST['option'];

    // Vérifier si le numéro de train est unique
    $sql_check_number = "SELECT id FROM trains WHERE number = '$train_number'";
    $result_check_number = $conn->query($sql_check_number);

    if ($result_check_number->num_rows > 0) {
        $_SESSION['train_message'] = 'Le numéro du train est déjà utilisé.';
    } else {
        // Vérifier l'état de la voie
        $sql_check_track_status = "SELECT status FROM voies WHERE id = '$track'";
        $result_check_track_status = $conn->query($sql_check_track_status);
        $track_status = $result_check_track_status->fetch_assoc()['status'];

        if ($track_status == 'maintenance' || $track_status == 'out-of-service') {
            $_SESSION['train_message'] = 'Cette voie est en maintenance ou hors service.';
        } else {
            // Vérifier si une entrée existe déjà pour la même voie et le même intervalle de temps
            $sql_check = "
                SELECT * FROM trains
                WHERE track = '$track'
                AND (
                    (departure_time >= '$departure_time' AND departure_time < '$arrival_time')
                    OR (arrival_time > '$departure_time' AND arrival_time <= '$arrival_time')
                    OR ('$departure_time' >= departure_time AND '$departure_time' < arrival_time)
                )";

            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                // Si une entrée est trouvée, renvoyer une erreur
                $_SESSION['train_message'] = 'Cette voie est déjà occupée par un train pendant cet intervalle de temps.';
            } else {
                // Sinon, insérez le nouveau train
                $sql_insert = "
                    INSERT INTO trains (number, departure_time, arrival_time, nature_id, origin, destination, track, `option`)
                    VALUES ('$train_number', '$departure_time', '$arrival_time', '$nature_id', '$origin', '$destination', '$track', '$option')";

                if ($conn->query($sql_insert) === TRUE) {
                    $_SESSION['train_message'] = "Train ajouté avec succès.";
                } else {
                    $_SESSION['train_message'] = "Erreur lors de l'ajout du train : " . $conn->error;
                }
            }
        }
    }

    $conn->close();

    header("Location: /index.php");
    exit();
}
?>
