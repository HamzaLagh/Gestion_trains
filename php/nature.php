<?php
session_start();
include 'db_connect.php'; // Assurez-vous que ce fichier inclut correctement votre connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $sql = "INSERT INTO natures (name) VALUES ('$name')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['nature_message'] = "Nouvelle nature ajoutée avec succès";
    } else {
        $_SESSION['nature_message'] = "Erreur lors de l'ajout de la nature : " . $conn->error;
    }

    header("Location: ../gestion.php");
    exit();
}
?>

