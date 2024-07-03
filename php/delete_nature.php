<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM natures WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Nature supprimée avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression: " . $stmt->error;
    }

    header("Location: ../modifier_supprimer.php");
    exit();
}
?>
