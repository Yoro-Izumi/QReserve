<!-- <?php
include "connect_database.php";
include "src/get_data_from_database/get_admin_accounts.php";
include "src/get_data_from_database/get_admin_info.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');

echo"
<thead>
<tr>
<tr>
  <th>Actions</th>
  <th>Name</th>
  <th>Sex</th>
  <th>Username</th>
  <th>Contact Number</th>
  <th>Email Address</th>
  <th>Shift</th>
</tr>
</thead>
<tbody>";

foreach ($arrayAdminAccount as $adminAccount) { //get membership details as well as information of member
  $adminInfoID = $adminAccount["adminInfoID"];
  $adminUsername = decryptData($adminAccount["adminUsername"], $key);
  $adminName = decryptData($adminAccount['adminFirstName'], $key) . " " . decryptData($adminAccount['adminMiddleName'], $key) . " " . decryptData($adminAccount['adminLastName'], $key);
  $adminSex = decryptData($adminAccount['adminSex'], $key);
  $adminPhone = decryptData($adminAccount['adminContactNumber'], $key);
  $adminEmail = decryptData($adminAccount['adminEmail'], $key);
  $adminShift = ($adminAccount['shiftTimeStart']) . " - " . ($adminAccount['shiftTimeEnd']);
echo "
  <tr>
    <td><input onchange='getSelected(this)' type='checkbox' class='admin-checkbox' value='$adminInfoID'></td>
    <td>$adminName</td>
    <td>$adminSex</td>
    <td>$adminUsername</td>
    <td>$adminPhone</td>
    <td>$adminEmail</td>
    <td>$adminShift</td>
  </tr>";
}
echo "</tbody>";
?> -->