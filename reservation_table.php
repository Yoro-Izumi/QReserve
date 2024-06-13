<?php 
session_start();
include "connect_database.php";
include "encodeDecode.php";
include "src/get_data_from_database/get_pool_table_info.php";
include "src/get_data_from_database/get_reservation_info.php";
include "src/get_data_from_database/get_walk_in.php";
include "src/get_data_from_database/get_customer_information.php";
include "src/get_data_from_database/get_member_account.php";

$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');

if(isset($_SESSION['userSuperAdminID'])){

echo "
<thead>
<tr>
  <th>Actions</th>
  <th>Name</th>
  <th>Date of Reservation</th>
  <th>Time of Reservation</th>
  <th>Pool Table</th>
  <th>Contact Number</th>
  <th>Email Address</th>
  <th>Status</th>
</tr>
</thead>
<tbody>";

foreach ($arrayReservationInfo as $reservations) {
  $reservationDate = $reservations['reservationDate'];
  $reservationStatus = $reservations['reservationStatus'];
  $reservationTimeStart = $reservations['reservationTimeStart'];
  $reservationTimeEnd = $reservations['reservationTimeEnd'];
  $tableNumber = $reservations['poolTableNumber'];

  foreach ($arrayMemberAccount as $members) {
    if ($members['memberID'] == $reservations['memberID']) {
      $customerName = decryptData($members['customerFirstName'], $key) . " " . decryptData($members['customerMiddleName'], $key) . " " . decryptData($members['customerLastName'], $key);
      $contactNumber = decryptData($members['customerNumber'], $key);
      $email = decryptData($members['customerEmail'], $key);
    }
  }

  
  echo "
  <tr>";if ($reservationStatus == "Paid" || $reservationStatus == "Done") {
    $status = "badge bg-success";
    echo "<td> </td>";
  } else if ($reservationStatus == "On Process" || $reservationStatus == "Pending") {
    $status = "badge bg-warning";
    echo "<td><input type='checkbox' class='reservation-checkbox' value='{$reservations['reservationID']}'></td>";
  } else {
    $status = "badge bg-danger";
    echo "<td> </td>";
  }
  echo "
    <td>$customerName</td>
    <td>$reservationDate</td>
    <td>$reservationTimeStart - $reservationTimeEnd</td>
    <td>$tableNumber</td>
    <td>$contactNumber</td>
    <td>$email</td>";
    
  echo "<td><span class='$status'>$reservationStatus</span></td>
  </tr>";
}

foreach ($arrayWalkinDetails as $walkin) {
  $walkinDate = $walkin['walkinDate'];
  $walkinStatus = $walkin['walkinStatus'];
  $walkinTimeStart = $walkin['walkinTimeStart'];
  $walkinTimeEnd = $walkin['walkinTimeEnd'];
  $tableNumber = $walkin['poolTableNumber'];

  // Directly access customer information from the walk-in array
  $customerName = decryptData($walkin['customerFirstName'], $key) . " " . decryptData($walkin['customerMiddleName'], $key) . " " . decryptData($walkin['customerLastName'], $key);
  $contactNumber = decryptData($walkin['customerNumber'], $key);
  $email = decryptData($walkin['customerEmail'], $key);

  echo "
  <tr>
    <td><input type='checkbox' class='reservation-checkbox' value='{$walkin['walkinID']}'></td>
    <td>$customerName</td>
    <td>$walkinDate</td>
    <td>$walkinTimeStart - $walkinTimeEnd</td>
    <td>$tableNumber</td>
    <td>$contactNumber</td>
    <td>$email</td>";
    if ($walkinStatus == "Paid" || $walkinStatus == "Done") {
      $status = "badge bg-success";
    } else if ($walkinStatus == "Waiting" || $walkinStatus == "Pending") {
      $status = "badge bg-warning";
    } else {
      $status = "badge bg-danger";
    }
  echo "<td><span class='$status'>$walkinStatus</span></td>
  </tr>";
}
echo "</tbody>";
}
else if(isset($_SESSION['userAdminID'])){


  echo "
  <thead>
  <tr>
    <th>Name</th>
    <th>Date of Reservation</th>
    <th>Time of Reservation</th>
    <th>Pool Table</th>
    <th>Contact Number</th>
    <th>Email Address</th>
    <th>Status</th>
  </tr>
  </thead>
  <tbody>";

  foreach ($arrayReservationInfo as $reservations) {
    $reservationDate = $reservations['reservationDate'];
    $reservationStatus = $reservations['reservationStatus'];
    $reservationTimeStart = $reservations['reservationTimeStart'];
    $reservationTimeEnd = $reservations['reservationTimeEnd'];
    $tableNumber = $reservations['poolTableNumber'];

    foreach ($arrayMemberAccount as $members) {
      if ($members['memberID'] == $reservations['memberID']) {
        $customerName = decryptData($members['customerFirstName'], $key) . " " . decryptData($members['customerMiddleName'], $key) . " " . decryptData($members['customerLastName'], $key);
        $contactNumber = decryptData($members['customerNumber'], $key);
        $email = decryptData($members['customerEmail'], $key);
      }
    }

    echo "
    <tr>
      <td>$customerName</td>
      <td>$reservationDate</td>
      <td>$reservationTimeStart - $reservationTimeEnd</td>
      <td>$tableNumber</td>
      <td>$contactNumber</td>
      <td>$email</td>";
      if ($reservationStatus == "Paid" || $reservationStatus == "Done") {
        $status = "badge bg-success";
      } else if ($reservationStatus == "On Process" || $reservationStatus == "Pending") {
        $status = "badge bg-warning";
      } else {
        $status = "badge bg-danger";
      }
    echo "<td><span class='$status'>$reservationStatus</span></td>
    </tr>";
  }

  foreach ($arrayWalkinDetails as $walkin) {
    $walkinDate = $walkin['walkinDate'];
    $walkinStatus = $walkin['walkinStatus'];
    $walkinTimeStart = $walkin['walkinTimeStart'];
    $walkinTimeEnd = $walkin['walkinTimeEnd'];
    $tableNumber = $walkin['poolTableNumber'];

    // Directly access customer information from the walk-in array
    $customerName = decryptData($walkin['customerFirstName'], $key) . " " . decryptData($walkin['customerMiddleName'], $key) . " " . decryptData($walkin['customerLastName'], $key);
    $contactNumber = decryptData($walkin['customerNumber'], $key);
    $email = decryptData($walkin['customerEmail'], $key);

    echo "
    <tr>
      <td>$customerName</td>
      <td>$walkinDate</td>
      <td>$walkinTimeStart - $walkinTimeEnd</td>
      <td>$tableNumber</td>
      <td>$contactNumber</td>
      <td>$email</td>";
      if ($walkinStatus == "Paid" || $walkinStatus == "Done") {
        $status = "badge bg-success";
      } else if ($walkinStatus == "Waiting" || $walkinStatus == "Pending") {
        $status = "badge bg-warning";
      } else {
        $status = "badge bg-danger";
      }
    echo "<td><span class='$status'>$walkinStatus</span></td>
    </tr>";
  }
}
?>
