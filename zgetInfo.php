<?php
include "connect_database.php";
include "src/get_data_from_database/get_reservation_info.php";
include "src/get_data_from_database/get_qr_info.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";
$reservationID = "";

// Retrieve the ID from the GET request
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null) {
    echo json_encode(array("error" => "No ID provided"));
    exit();
}


// Ensure $arrayReservationInfo is defined and not empty
if (!isset($arrayReservationInfo) || empty($arrayReservationInfo)) {
    echo json_encode(array("error" => "No reservation data available"));
    exit();
}

//check if reservation code exist
foreach($arrayQrInfo as $qrInfo){
     if($qrInfo['codeQR'] == $id){
        $reservationID = $qrInfo['reservationID'];
     }
}


// Initialize an empty array to store the reservation information
$info = null;

// Iterate through the array to find the matching reservation
foreach ($arrayReservationInfo as $reservation) {
    if ($reservation['reservationID'] == $reservationID) {
        $info = array(
            "reservationID" => $id,
            "memberID" => decryptData($reservation['membershipID'], $key),
            "tableNumber" => $reservation['poolTableNumber'],
            "reservationStatus" => $reservation['reservationStatus'],
            "reservationDate" => $reservation['reservationDate'],
            "reservationTimeStart" => $reservation['reservationTimeStart'],
            "reservationTimeEnd" => $reservation['reservationTimeEnd']
        );
        break;
    }
}

// Check if reservation information was found
if ($info === null) {
    echo json_encode(array("error" => "Reservation not found"));
} else {
    // Return the information as JSON
    echo json_encode(array("info" => $info));
}
?>
