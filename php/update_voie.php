<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $status = $_POST['status'];

    $sql = "UPDATE voies SET name = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $name, $status, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Voie mise à jour avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la mise à jour: " . $stmt->error;
    }

    header("Location: ../modifier_supprimer.php");
    exit();
}
?>
