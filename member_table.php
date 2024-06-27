<!-- <?php

date_default_timezone_set('Asia/Manila');
include "connect_database.php";
include "src/get_data_from_database/get_member_account.php";
include "src/get_data_from_database/get_customer_information.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";

echo"
<thead>
<tr>
<tr>
  <th>Actions</th>
  <th>Name</th>
  <th>Control Number</th>
  <th>Birthday</th>
  <th>Contact Number</th>
  <th>Email Address</th>
  <th>Validity Date</th>
</tr>
</thead>
<tbody>";

foreach ($arrayMemberAccount as $memberAccount) { //get membership details as well as information of member
  $customerID = $memberAccount["customerID"];
  $memberUsername = decryptData($memberAccount["memberUsername"], $key);
  $membershipValidity = $memberAccount["validityDate"];
  $customerName = decryptData($memberAccount['customerFirstName'], $key) . " " . decryptData($memberAccount['customerMiddleName'], $key) . " " . decryptData($memberAccount['customerLastName'], $key);
  $customerBirthdate = decryptData($memberAccount['customerBirthdate'], $key);
  $customerPhone = decryptData($memberAccount['customerNumber'], $key);
  $customerEmail = decryptData($memberAccount['customerEmail'], $key);
echo"
  <tr>
    <td><input class='member-checkbox' type='checkbox' value='$customerID'></td>
    <td>$customerName</td>
    <td>$memberUsername</td>
    <td>$customerBirthdate</td>
    <td>$customerPhone</td>
    <td>$customerEmail</td>
    <td>$membershipValidity</td>
  </tr>";
 }
echo "</tbody>";

?> -->