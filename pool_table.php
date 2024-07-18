<?php 
include "connect_database.php";
include "encodeDecode.php";
include "src/get_data_from_database/get_pool_table_info.php";
include "src/get_data_from_database/get_reservation_info.php";
include "src/get_data_from_database/get_walk_in.php";
include "src/get_data_from_database/get_customer_information.php";
include "src/get_data_from_database/get_member_account.php";

$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

// Default status and times
$defaultStatus = "Available";
$defaultTimeEnd = $currentDate . " 00:00:00";
$defaultTimeStart = $currentDate . " 00:00:00";

// Function to update pool table status
function updatePoolTableStatus($conn, $status, $start, $end, $tableID) {
    $qryUpdatePoolTable = "UPDATE `pool_tables` SET poolTableStatus = ?, timeStarted = ?, timeEnd = ? WHERE poolTableID = ?";
    $stmt = mysqli_prepare($conn, $qryUpdatePoolTable);
    mysqli_stmt_bind_param($stmt, "sssi", $status, $start, $end, $tableID);
    mysqli_stmt_execute($stmt);
}

// Loop through each pool table
foreach($arrayPoolTables as $poolTable) {
    $tableID = $poolTable['poolTableID'];
    $currentStatus = $poolTable['poolTableStatus'];
    $newStatus = $defaultStatus;
    $newTimeStart = $defaultTimeStart;
    $newTimeEnd = $defaultTimeEnd;

    // Check reservations
    foreach($arrayReservationInfo as $reservation) {
        if($reservation['tableID'] == $tableID && $reservation['reservationDate'] === $currentDate && 
           $reservation['reservationTimeStart'] <= $currentTime && $reservation['reservationTimeEnd'] >= $currentTime && $reservation['reservationStatus'] === "Reserved") {
            $newStatus = "Playing";
            $newTimeStart = $currentDate . " " . $reservation['reservationTimeStart'];
            $newTimeEnd = $currentDate . " " . $reservation['reservationTimeEnd'];
            break;
        }
    }

    // Check walk-ins
    foreach($arrayWalkinDetails as $walkin) {
        if($walkin['tableID'] == $tableID && $walkin['walkinDate'] === $currentDate && 
           $walkin['walkinTimeStart'] <= $currentTime && $walkin['walkinTimeEnd'] >= $currentTime && $walkin["walkinStatus"] === "Reserved") {
            $newStatus = "Playing";
            $newTimeStart = $currentDate . " " . $walkin['walkinTimeStart'];
            $newTimeEnd = $currentDate . " " . $walkin['walkinTimeEnd'];
            break;
        }
    }

    // Update status if it has changed
    if ($currentStatus !== $newStatus) {
        updatePoolTableStatus($conn, $newStatus, $newTimeStart, $newTimeEnd, $tableID);
    }
}

// Output table rows
echo "<thead>
        <tr>
          <th>Pool Table</th>
          <th>Time Started</th>
          <th>Expected End Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>";

foreach($arrayPoolTables as $poolTable) {
    $poolTableStatus = $poolTable['poolTableStatus'];
    $poolTableNumber = $poolTable['poolTableNumber'];
    $timeStarted = $poolTableStatus == "Available" ? "--:--" : date("g:i A", strtotime($poolTable['timeStarted']));
    $timeEnd = $poolTableStatus == "Available" ? "--:--" : date("g:i A", strtotime($poolTable['timeEnd']));
    $statusClass = ($poolTableStatus == "Available" || $poolTableStatus == "Done") ? "badge bg-success" : (($poolTableStatus == "Reserved" || $poolTableStatus == "Waiting") ? "badge bg-warning" : "badge bg-danger");

    echo "<tr>
            <td>{$poolTableNumber}</td>
            <td>{$timeStarted}</td>
            <td>{$timeEnd}</td>
            <td><span class='{$statusClass}'>{$poolTableStatus}</span></td>
          </tr>";
}

echo "</tbody>";



// Path to the file that stores the last execution date
$lastExecutionFile = 'last_execution_date.txt';

// Get today's date
$today = date('Y-m-d');

// Check if the last execution date file exists
if (file_exists($lastExecutionFile)) {
    // Read the last execution date from the file
    $lastExecutionDate = file_get_contents($lastExecutionFile);
} else {
    // If the file doesn't exist, set the last execution date to a past date
    $lastExecutionDate = '';
}

// If the script hasn't been executed today, execute the code and update the file
if ($lastExecutionDate !== $today) {
    // Remove expired memberships
    foreach($arrayMemberAccount as $memberAccount) {
        $memberValidity  = $memberAccount['validityDate'];
        $validity = "Expired";
        $date = DateTime::createFromFormat('Y-m-d', $memberValidity);
        $sqlDate = $date->format('Y-m-d');
        $dateDifference  = dateDifference($sqlDate, $currentDate); //difference between two dates

        // Notify customer that their membership is about to expire
        if ($dateDifference === 5) {
            include 'src/send_email/send_advance_expiration_notification.php';
        }

            
        else if($sqlDate < $currentDate) {
            $memberID = $memberAccount['memberID'];

            $qryDeleteMembershipAccount = "UPDATE member_details SET validity = ? WHERE memberID = ?";
            $prepareDeleteMembershipAccount = mysqli_prepare($conn, $qryDeleteMembershipAccount);
            mysqli_stmt_bind_param($prepareDeleteMembershipAccount, "si", $validity, $memberID);
            mysqli_stmt_execute($prepareDeleteMembershipAccount);

            include 'src/send_email/send_expiration_notification.php';
        }
    }

    
    // Update the last execution date in the file
    file_put_contents($lastExecutionFile, $today);
}



?>
