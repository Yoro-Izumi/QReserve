<?php
include "../../connect_database.php";
include "get_pool_table_info.php"; // Adjusted to use __DIR__
include "get_walk_in.php"; // Adjusted to use __DIR__
include "get_reservation_info.php";
date_default_timezone_set('Asia/Manila');

// $options = [];
$tempHold = "";

if (isset($_POST['startTime']) && isset($_POST['endTime']) && isset($_POST['date'])) {
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $date = $_POST['date'];

    // Available tables initially include all tables
    $availableTables = array_column($arrayPoolTables, 'poolTableID');

    // Function to check if a time range overlaps with another time range
    function isOverlapping($start1, $end1, $start2, $end2) {
        return $start1 < $end2 && $start2 < $end1;
        //$start1  == $startTime
        //$end1 == $endTime
        //$start2 == $reservation/walkin Start Time
        //$end2 == $reservation/walkin End Time
    }

    // Check reservations for overlap
    if (!empty($arrayReservationInfo)) {
        foreach ($arrayReservationInfo as $reservation) {
            $reservationTimeStart = $reservation['reservationTimeStart'];
            $reservationTimeEnd = $reservation['reservationTimeEnd'];
            $reservationDate = $reservation['reservationDate'];

            if ($reservationDate == $date && isOverlapping($startTime, $endTime, $reservationTimeStart, $reservationTimeEnd)) {
                $reservationPoolTableID = $reservation['tableID'];
                    $index = array_search($reservationPoolTableID, $availableTables);
                    unset($availableTables[$index]); // Removes the element with key index
                    $availableTables = array_values($availableTables); // Re-indexes the array

                //$availableTables = array_diff($availableTables, [$reservation['poolTableID']]);
            }
        }
    }

    // Check walk-ins for overlap
    if (!empty($arrayWalkinDetails)) {
        foreach ($arrayWalkinDetails as $walkin) {
            $walkinsTimeStart = $walkin['walkinTimeStart'];
            $walkinsTimeEnd = $walkin['walkinTimeEnd'];
            $walkinsDate = $walkin['walkinDate'];

            if ($walkinsDate == $date && isOverlapping($startTime, $endTime, $walkinsTimeStart, $walkinsTimeEnd)) {
                $walkinPoolTableID = $walkin['tableID'];   
                    $index = array_search($walkinPoolTableID, $availableTables);
                    unset($availableTables[$index]); // Removes the element with key index
                    $availableTables = array_values($availableTables); // Re-indexes the array
                //$availableTables = array_diff($availableTables, [$walkin['poolTableID']]);
            }
        }
    }

    // Generate the options for available tables
    echo "<option value='' selected disabled>Select table</option>";
    if (!empty($availableTables)) {
        foreach ($arrayPoolTables as $table) {
            if (in_array($table['poolTableID'], $availableTables)) {
                echo "<option value='" . $table['poolTableID'] . "'>Table " . $table['poolTableNumber'] . "</option>";
            }
        }
    } else {
        echo "<option value='' disabled>No tables available</option>";
    }
}
?>
