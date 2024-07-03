<?php
session_start();
include 'db_connect.php'; // Assurez-vous que ce fichier inclut correctement votre connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $name = $_POST['name'];
    $location = $_POST['location'];

    // Requête SQL pour l'insertion
    $sql = "INSERT INTO gares (name, location) VALUES ('$name', '$location')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['gare_message'] = "Nouvelle gare ajoutée avec succès";
    } else {
        $_SESSION['gare_message'] = "Erreur lors de l'ajout de la gare : " . $conn->error;
    }

    // Redirection vers la page principale après traitement
    header("Location: ../gestion.php");
    exit();
}
?>
