<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "UPDATE natures SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $name, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Nature mise à jour avec succès.";
    } else {
        $_SESSION['message'] = "Erreur lors de la mise à jour: " . $stmt->error;
    }

    header("Location: ../modifier_supprimer.php");
    exit();
}
?>
