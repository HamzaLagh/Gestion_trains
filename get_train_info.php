<?php
// get_train_info.php

header('Content-Type: application/json');

// Vérifiez si l'ID du train est passé en paramètre GET
if(isset($_GET['id'])) {
    $trainId = $_GET['id'];
    
    // Connectez-vous à la base de données et récupérez les informations du train
    include 'php/db_connect.php';

    // Exemple de requête SQL pour récupérer les détails d'un train en fonction de son ID
    $sql = "SELECT * FROM trains WHERE id = $trainId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Récupérez les informations du train
        $train = $result->fetch_assoc();
        // Encodez les informations du train en JSON
        echo json_encode($train);
    } else {
        echo json_encode(['error' => 'Aucune information trouvée pour ce train.']);
    }

    $conn->close();
} else {
    echo json_encode(['error' => 'ID de train non spécifié.']);
}
?>
