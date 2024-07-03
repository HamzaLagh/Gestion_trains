<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $sql = "DELETE FROM gares WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Gare supprimée avec succès";
    } else {
        $_SESSION['message'] = "Erreur: " . $sql . "<br>" . $conn->error;
    }
    header("Location: /../gestion.php");  // Redirection vers la page de gestion après suppression
    exit();
}
$conn->close();
?>
