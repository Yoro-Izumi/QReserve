  <?php 
  include "connect_database.php";
  include "encodeDecode.php";
  include "src/get_data_from_database/get_pool_table_info.php";
  include "src/get_data_from_database/get_reservation_info.php";
  include "src/get_data_from_database/get_walk_in.php";
  include "src/get_data_from_database/get_customer_information.php";

  $key = "TheGreatestNumberIs73";
  date_default_timezone_set('Asia/Manila');


  $currentDate = date('Y-m-d');
  $currentTime = date('H:i:s');

  // Default status and times
  $defaultStatus = "Available";
  $defaultTimeEnd = $currentDate . " 00:00:00";
  $defaultTimeStart = $currentDate . " 00:00:00";


  // Check if the pool table is reserved and update status accordingly
  foreach($arrayReservationInfo as $reservation) {
      if($reservation['reservationDate'] === $currentDate && 
         $reservation['reservationTimeStart'] <= $currentTime && 
         $reservation['reservationTimeEnd'] >= $currentTime
        ) {
          $poolTableStatus = "Playing";
          $insertTimeEnd = $currentDate . " " . $reservation['reservationTimeEnd'];
          $insertTimeStart = $currentDate . " " . $reservation['reservationTimeStart'];
          break; // No need to check further reservations

      // Update the database with the new status and times
      $qryUpdatePoolTable = "UPDATE `pool_tables` SET poolTableStatus = ?, timeStarted = ?, timeEnd = ? WHERE poolTableID = ?";
      $stmt = mysqli_prepare($conn, $qryUpdatePoolTable);
      mysqli_stmt_bind_param($stmt, "sssi", $poolTableStatus, $insertTimeStart, $insertTimeEnd, $reservation['tableID']);
      mysqli_stmt_execute($stmt);
      }
  else{
      // Update the database with the new status and times
      $qryUpdatePoolTable = "UPDATE `pool_tables` SET poolTableStatus = ?, timeStarted = ?, timeEnd = ? WHERE poolTableID = ?";
      $stmt = mysqli_prepare($conn, $qryUpdatePoolTable);
      mysqli_stmt_bind_param($stmt, "sssi", $defaultStatus, $defaultTimeStart, $defaultTimeEnd, $reservation['tableID']);
      mysqli_stmt_execute($stmt);

  }
  }


  foreach($arrayWalkinDetails as $walkin){
      if($walkin['walkinDate'] === $currentDate && 
         $walkin['walkinTimeStart'] <= $currentTime && 
         $walkin['walkinTimeEnd'] >= $currentTime
        ) {
          $poolTableStatus = "Playing";
          $insertTimeEnd = $currentDate . " " . $walkin['walkinTimeEnd'];
          $insertTimeStart = $currentDate . " " . $walkin['walkinTimeStart'];
          break; // No need to check further reservations

      // Update the database with the new status and times
      $qryUpdatePoolTable = "UPDATE `pool_tables` SET poolTableStatus = ?, timeStarted = ?, timeEnd = ? WHERE poolTableID = ?";
      $stmt = mysqli_prepare($conn, $qryUpdatePoolTable);
      mysqli_stmt_bind_param($stmt, "sssi", $poolTableStatus, $insertTimeStart, $insertTimeEnd, $walkin['tableID']);
      mysqli_stmt_execute($stmt);

   }
  else{
      // Update the database with the new status and times
      $qryUpdatePoolTable = "UPDATE `pool_tables` SET poolTableStatus = ?, timeStarted = ?, timeEnd = ? WHERE poolTableID = ?";
      $stmt = mysqli_prepare($conn, $qryUpdatePoolTable);
      mysqli_stmt_bind_param($stmt, "sssi", $defaultStatus, $defaultTimeStart, $defaultTimeEnd, $reservation['tableID']);
      mysqli_stmt_execute($stmt);

  }
  }

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



      // Determine status badge
      if($poolTableStatus == "Done" || $poolTableStatus == "Available") {
          $status = "badge bg-success";
          $defaultStatus = $poolTableStatus; 
      } else if($poolTableStatus == "Reserved" || $poolTableStatus == "Waiting") {
          $status = "badge bg-warning";
          $defaultStatus = $poolTableStatus;
      } else if($poolTableStatus == "Playing"){
          $status = "badge bg-danger";
          $defaultStatus = $poolTableStatus;
      } else {
          $status = "badge bg-danger";
          $defaultStatus = "Playing";
      }

      // Output table row
      echo "<tr>
              <td>".$customerName."</td>
              <td>".$poolTableNumber."</td>
              <td>".$timeStarted[1]."</td>
              <td>".$timeEnd[1]."</td>
              <td><span class='".$status."'>".$defaultStatus."</span></td>
            </tr>";
  }

  echo "</tbody>";

  foreach($arrayMemberAccount as $memberAccount){
      $memberValidity  = $memberAccount['validityDate'];
      // Parse HTML date string into a DateTime object
        $date = DateTime::createFromFormat('Y-m-d', $memberValidity);
        // Convert DateTime object to SQL date format (YYYY-MM-DD)
        $sqlDate = $date->format('Y-m-d');
      if($sqlDate < $currentDate){
          $memberID = $memberAccount['memberID'];
              $qryModifyReserve  = "UPDATE pool_table_reservation SET memberID = NULL where memberID = ?";
              $prepareModifyReserve = mysqli_prepare($conn, $qryModifyReserve);
              mysqli_stmt_bind_param($prepareModifyReserve, "i", $memberID);
              mysqli_stmt_execute($prepareModifyReserve);

              $qryDeleteMembershipAccount = "DELETE FROM member_details WHERE memberID = ?";
              $prepareDeleteMembershipAccount = mysqli_prepare($conn, $qryDeleteMembershipAccount);
              mysqli_stmt_bind_param($prepareDeleteMembershipAccount, "i", $memberID);
              mysqli_stmt_execute($prepareDeleteMembershipAccount);


      }
  }

  ?>
