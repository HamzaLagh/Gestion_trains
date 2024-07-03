<?php
session_start();
include 'db_connect.php'; // Assurez-vous que ce fichier inclut correctement votre connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $name = $_POST['name'];
    $longueur = $_POST['longueur'];
    $status = $_POST['status'];

    // Requête SQL pour l'insertion
    $sql = "INSERT INTO voies (name, longueur, status) VALUES ('$name', '$longueur', '$status')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['voie_message'] = "Nouvelle voie ajoutée avec succès";
    } else {
        $_SESSION['voie_message'] = "Erreur lors de l'ajout de la voie : " . $conn->error;
    }

    // Redirection vers la page principale après traitement
    header("Location: ../gestion.php");
    exit();
}
?>
