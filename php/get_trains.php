<?php
include 'db_connect.php';

$sql = "SELECT trains.*, voies.name AS voie_name FROM trains JOIN voies ON trains.voie_id = voies.id";
$result = $conn->query($sql);

$trains = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $trains[] = $row;
    }
}

echo json_encode($trains);

$conn->close();
?>
