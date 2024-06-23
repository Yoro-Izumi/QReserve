<?php
include "connect_database.php";
include "src/get_data_from_database/get_reservation_info.php";
include "src/get_data_from_database/get_walk_in.php";

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
?>
