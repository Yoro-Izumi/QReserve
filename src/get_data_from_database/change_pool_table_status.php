<?php

$currentTime = date('H:i:s');
$date = date('Y-m-d');

// Available tables initially include all tables
$notAvailableTables = [];

// Function to check if a time range overlaps with another time range
function isOverlapping($start1, $end1, $start2, $end2) {
    return $start1 < $end2 && $start2 < $end1;
}

// Check reservations for overlap
if (!empty($arrayReservationInfo)) {
    foreach ($arrayReservationInfo as $reservation) {
        $reservationTimeStart = $reservation['reservationTimeStart'];
        $reservationTimeEnd = $reservation['reservationTimeEnd'];
        $reservationDate = $reservation['reservationDate'];

        if ($reservationDate == $date && isOverlapping($currentTime, $currentTime, $reservationTimeStart, $reservationTimeEnd)) {
            $reservationPoolTableID = $reservation['tableID'];
            $reservationStatus = "Playing";
            $notAvailableTables[] = [
                'tableID' => $reservationPoolTableID,
                'timeStart' => $reservationTimeStart,
                'timeEnd' => $reservationTimeEnd,
                'status' => $reservationStatus
            ];
        }
    }
}

// Check walk-ins for overlap
if (!empty($arrayWalkinDetails)) {
    foreach ($arrayWalkinDetails as $walkin) {
        $walkinsTimeStart = $walkin['walkinTimeStart'];
        $walkinsTimeEnd = $walkin['walkinTimeEnd'];
        $walkinsDate = $walkin['walkinDate'];

        if ($walkinsDate == $date && isOverlapping($currentTime, $currentTime, $walkinsTimeStart, $walkinsTimeEnd)) {
            $walkinPoolTableID = $walkin['tableID'];   
            $walkinStatus = "Playing";
            $notAvailableTables[] = [
                'tableID' => $walkinPoolTableID,
                'timeStart' => $walkinTimeStart,
                'timeEnd' => $walkinTimeEnd,
                'status' => $walkinStatus
            ];
        }
    }
}

// Generate the options for available tables
if (!empty($notAvailableTables)) {
    foreach ($notAvailableTables as $table) {
        $tableID = $table['tableID'];
        $tableTimeStart = $date." ".$table['timeStart'];
        $tableTimeEnd = $date." ".$table['timeEnd'];
        $tableStatus = $table['status'];

        $qryUpdatePoolTable = "UPDATE `pool_tables` SET poolTableStatus = ?, timeStarted = ?, timeEnd = ? WHERE poolTableID = ?";
        $stmt = mysqli_prepare($conn, $qryUpdatePoolTable);
        mysqli_stmt_bind_param($stmt, "sssi", $tableStatus, $tableTimeStart, $tableTimeEnd, $tableID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

?>

