<?php
include "connect_database.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = array();

foreach ($arrayReservationInfo as $reservation) {
    $data[] = array('date' => $reservation['reservationDate']);
}
foreach ($arrayWalkinDetails as $walkin) {
    $data[] = array('date' => $walkin['walkinDate']);
}

$conn->close();

file_put_contents('data.json', json_encode($data));

echo "Data has been saved to data.json";
?>
