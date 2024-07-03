<?php
session_start();
include 'php/db_connect.php'; // Assurez-vous d'inclure votre fichier de connexion à la base de données

// Vérifie si l'ID du train à supprimer est présent dans la requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $trainId = $_POST['id'];

    // Requête SQL pour supprimer le train en fonction de son ID
    $sql = "DELETE FROM trains WHERE id = $trainId";

    if ($conn->query($sql) === TRUE) {
        $response['success'] = "Train supprimé avec succès !";
    } else {
        $response['error'] = "Erreur lors de la suppression du train : " . $conn->error;
    }

    $conn->close();
} else {
    $response['error'] = "ID du train à supprimer non spécifié.";
}

echo json_encode($response); // Retourner la réponse JSON
?>
