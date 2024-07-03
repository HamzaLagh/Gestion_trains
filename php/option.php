<?php
session_start();
include 'db_connect.php'; // Assurez-vous que ce fichier inclut correctement votre connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $name = $_POST['name'];

    // Requête SQL pour l'insertion
    $sql = "INSERT INTO options (name) VALUES ('$name')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['option_message'] = "Nouvelle option ajoutée avec succès";
    } else {
        $_SESSION['option_message'] = "Erreur lors de l'ajout de l'option : " . $conn->error;
    }

    // Redirection vers la page principale après traitement
    header("Location: ../gestion.php");
    exit();
}
?>
