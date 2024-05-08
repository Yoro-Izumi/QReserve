<?php
session_start();
date_default_timezone_set('Asia/Manila');

  include "connect_database.php";
  include "src/get_data_from_database/get_reservation_info.php";
  include "src/get_data_from_database/get_member_account.php";
  include "encodeDecode.php";
  $key = "TheGreatestNumberIs73";

echo"
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
    } else {
      $customerName = "";
      $contactNumber = "";
      $email = "";
    }
  }
echo"
  <tr>
    <td><input type='checkbox' value='{$reservations['reservationID']}'></td>
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
echo "</tbody>";
?>