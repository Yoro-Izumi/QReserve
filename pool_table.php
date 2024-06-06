<?php 
include "connect_database.php";
include "encodeDecode.php";
include "src/get_data_from_database/get_pool_table_info.php";
include "src/get_data_from_database/get_reservation_info.php";
include "src/get_data_from_database/get_walk_in.php";
include "src/get_data_from_database/get_customer_information.php";

$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');

echo "<thead>
        <tr>
          <th>Name</th>
          <th>Pool Table</th>
          <th>Time Started</th>
          <th>Expected End Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>";

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

foreach($arrayPoolTables as $poolTables) {
    if($poolTables['customerName'] == NULL) {
        $customerName = "None";
    } else {
        $customerName = $poolTables['customerName'];
    }

    $poolTableStatus = $poolTables['poolTableStatus'];
    $poolTableNumber = $poolTables['poolTableNumber'];
    $timeStarted = explode(' ', $poolTables['timeStarted']);
    $timeEnd = explode(' ', $poolTables['timeEnd']);

    // Default status and times
    $poolStatus = "Available";
    $insertTimeEnd = $currentDate . " 00:00:00";
    $insertTimeStart = $currentDate . " 00:00:00";

    // Check if the pool table is reserved and update status accordingly
    foreach($arrayReservationInfo as $reservation) {
        if($reservation['reservationDate'] === $currentDate && 
           $reservation['reservationTimeStart'] <= $currentTime && 
           $reservation['reservationTimeEnd'] >= $currentTime && 
           $poolTables['poolTableID'] == $reservation['tableID']
          ) {
            $poolStatus = "Playing";
            $insertTimeEnd = $currentDate . " " . $reservation['reservationTimeEnd'];
            $insertTimeStart = $currentDate . " " . $reservation['reservationTimeStart'];
            break; // No need to check further reservations
        }
    }
   // foreach($arrayWalkinDetails as $walkin){

   // }

    // Update the database with the new status and times
    $qryUpdatePoolTable = "UPDATE `pool_tables` SET poolTableStatus = ?, timeStarted = ?, timeEnd = ? WHERE poolTableID = ?";
    $stmt = mysqli_prepare($conn, $qryUpdatePoolTable);
    mysqli_stmt_bind_param($stmt, "sssi", $poolStatus, $insertTimeStart, $insertTimeEnd, $poolTables['poolTableID']);
    mysqli_stmt_execute($stmt);

    // Determine status badge
    if($poolTableStatus == "Done" || $poolTableStatus == "Available") {
        $status = "badge bg-success";
    } else if($poolTableStatus == "Reserved" || $poolTableStatus == "Waiting") {
        $status = "badge bg-warning";
    } else {
        $status = "badge bg-danger";
    }

    // Output table row
    echo "<tr>
            <td>".$customerName."</td>
            <td>".$poolTableNumber."</td>
            <td>".$timeStarted[1]."</td>
            <td>".$timeEnd[1]."</td>
            <td><span class='".$status."'>".$poolStatus."</span></td>
          </tr>";
}

echo "</tbody>";
?>
