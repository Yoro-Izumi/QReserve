<?php
include "connect_database.php";
include "encodeDecode.php";
include "src/get_data_from_database/get_member_account.php";
$key = "TheGreatestNumberIs73";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION["userSuperAdminID"])) {
  $userSuperAdmin = $_SESSION["userSuperAdminID"];
  if (isset($_POST['firstName'])) {
    $customerFirstName = encryptData(mysqli_real_escape_string($conn, $_POST['firstName']), $key);
    $customerLastName = encryptData(mysqli_real_escape_string($conn, $_POST['lastName']), $key);
    $customerMiddleName = encryptData(mysqli_real_escape_string($conn, $_POST['middleName']), $key);
    $customerEmail = encryptData(mysqli_real_escape_string($conn, $_POST['email']), $key);
    $customerPhone = encryptData(mysqli_real_escape_string($conn, $_POST['contactNumber']), $key);
    $customerBirthdate = encryptData(mysqli_real_escape_string($conn, $_POST['birthDate']), $key);
    $memberControlNumber = encryptData(mysqli_real_escape_string($conn, $_POST['controlNumber']), $key);
    $memberPassword = mysqli_real_escape_string($conn, $_POST['password']);
    $memberValidity = mysqli_real_escape_string($conn, $_POST['validity']);
    $x = "None";
    $y = 1;
    $statusValidity = 'Valid';

    // Hash the password using Argon2
    $options = [
      'memory_cost' => 1 << 17, // 128MB memory cost (default)
      'time_cost' => 4,       // 4 iterations (default)
      'threads' => 3,         // Use 3 threads for processing (default)
    ];
    $hashedPassword = password_hash($memberPassword, PASSWORD_ARGON2I, $options);

    // Parse HTML date string into a DateTime object
    $date = DateTime::createFromFormat('Y-m-d', $memberValidity);
    // Convert DateTime object to SQL date format (YYYY-MM-DD)
    $sqlDate = $date->format('Y-m-d');
    //current date
    $currentDate = date('Y-m-d');

    sendMembershipEmail($customerEmail, $memberControlNumber, $memberPassword, $key);  

    $qryInsertCustomerInfo = "INSERT INTO `customer_info`(`customerID`, `customerFirstName`, `customerLastName`, `customerMiddleName`, `customerBirthdate`, `customerNumber`, `customerEmail`) VALUES (NULL,?,?,?,?,?,?)";
    $conInsertCustomerInfo = mysqli_prepare($conn, $qryInsertCustomerInfo);
    mysqli_stmt_bind_param($conInsertCustomerInfo, "ssssss", $customerFirstName, $customerLastName, $customerMiddleName, $customerBirthdate, $customerPhone, $customerEmail);
    mysqli_stmt_execute($conInsertCustomerInfo);
    $customerID = mysqli_insert_id($conn);

    $qryInsertMemberDetails = "INSERT INTO `member_details`(`memberID`, `membershipID`, `perk_id`, `membershipPassword`, `customerID`, `creationDate`, `validityDate`, `superAdminID`, `validity`) VALUES (NULL,?,?,?,?,?,?,?,?)";
    $conInsertMemberDetails = mysqli_prepare($conn, $qryInsertMemberDetails);
    mysqli_stmt_bind_param($conInsertMemberDetails, "ssssssss", $memberControlNumber, $y, $hashedPassword, $customerID, $currentDate, $sqlDate, $userSuperAdmin, $statusValidity);
    mysqli_stmt_execute($conInsertMemberDetails);



    unset($_POST['firstName']);
  }
  
// delete member details
  if(isset($_POST['selectedRows'])){ 
    $selectedRows = $_POST['selectedRows'];
    $validityStatus = "Expired";
        foreach($selectedRows as $rowId){

            //delete member account
            $qryDeleteMemberAccount = "UPDATE `member_details` SET `validity` = ? WHERE customerID = ?";
            $connDeleteMemberAccount = mysqli_prepare($conn, $qryDeleteMemberAccount);
            mysqli_stmt_bind_param($connDeleteMemberAccount,'si',$validityStatus,$rowId);
            mysqli_stmt_execute($connDeleteMemberAccount);

            foreach($arrayMemberAccount as $memberAccount){
              if($memberAccount['customerID'] == $rowId){
                $memberID  = $memberAccount['memberID'];
                $customerEmail = $memberAccount['customerEmail'];
                $memberControlNumber = $memberAccount['membershipID'];
                sendDeleteNotif($customerEmail,$memberControlNumber,$key);
              }
            } 
        }
      // Assuming you want to return a success message
        echo "Rows deleted successfully";
        unset($_POST['selectedRows']);
}

//update member details
  if (isset($_POST['memberID'])) {
    $memberID = $_POST['memberID'];
    $customerFirstName = encryptData(mysqli_real_escape_string($conn, $_POST['FirstName']), $key);
    $customerLastName = encryptData(mysqli_real_escape_string($conn, $_POST['lastName']), $key);
    $customerMiddleName = encryptData(mysqli_real_escape_string($conn, $_POST['middleName']), $key);
    $customerEmail = encryptData(mysqli_real_escape_string($conn, $_POST['email']), $key);
    $customerPhone = encryptData(mysqli_real_escape_string($conn, $_POST['contactNumber']), $key);
    $customerBirthdate = encryptData(mysqli_real_escape_string($conn, $_POST['birthDate']), $key);
    $memberControlNumber = encryptData(mysqli_real_escape_string($conn, $_POST['controlNumber']), $key);
    $memberPassword = mysqli_real_escape_string($conn, $_POST['password']);
    $memberValidity = mysqli_real_escape_string($conn, $_POST['validity']);
    $userSuperAdmin = $_SESSION['userSuperAdminID'] ?? 1; // Default to 1 if not set

    // Hash the password using Argon2
    $options = [
      'memory_cost' => 1 << 17, // 128MB memory cost (default)
      'time_cost' => 4,         // 4 iterations (default)
      'threads' => 3,           // Use 3 threads for processing (default)
    ];
    $hashedPassword = password_hash($memberPassword, PASSWORD_ARGON2I, $options);

    // Parse HTML date string into a DateTime object
    $date = DateTime::createFromFormat('Y-m-d', $memberValidity);
    // Convert DateTime object to SQL date format (YYYY-MM-DD)
    $sqlDate = $date->format('Y-m-d');
    // Current date
    $currentDate = date('Y-m-d');

    // Update customer info
    $qryUpdateCustomerInfo = "UPDATE `customer_info` SET `customerFirstName`=?, `customerLastName`=?, `customerMiddleName`=?, `customerBirthdate`=?, `customerNumber`=?, `customerEmail`=? WHERE `customerID`=?";
    $conUpdateCustomerInfo = mysqli_prepare($conn, $qryUpdateCustomerInfo);
    mysqli_stmt_bind_param($conUpdateCustomerInfo, "ssssssi", $customerFirstName, $customerLastName, $customerMiddleName, $customerBirthdate, $customerPhone, $customerEmail, $memberID);
    mysqli_stmt_execute($conUpdateCustomerInfo);

    if ($memberPassword === ".") {
      $qryUpdateMemberDetails = "UPDATE `member_details` SET `membershipID`=?, `creationDate`=?, `validityDate`=?, `superAdminID`=? WHERE `customerID`=?";
      $conUpdateMemberDetails = mysqli_prepare($conn, $qryUpdateMemberDetails);
      mysqli_stmt_bind_param($conUpdateMemberDetails, "sssii", $memberControlNumber, $currentDate, $sqlDate, $userSuperAdmin, $memberID);
      mysqli_stmt_execute($conUpdateMemberDetails);
    } else {
      $qryUpdateMemberDetails = "UPDATE `member_details` SET `membershipID`=?, `membershipPassword`=?, `creationDate`=?, `validityDate`=?, `superAdminID`=? WHERE `customerID`=?";
      $conUpdateMemberDetails = mysqli_prepare($conn, $qryUpdateMemberDetails);
      mysqli_stmt_bind_param($conUpdateMemberDetails, "ssssii", $memberControlNumber, $hashedPassword, $currentDate, $sqlDate, $userSuperAdmin, $memberID);
      mysqli_stmt_execute($conUpdateMemberDetails);
    }

    // Send notification email
    sendEditNotif($customerEmail, $memberControlNumber, $memberPassword, $key);

    unset($_POST['FirstName']);
  }

}


function sendMembershipEmail($customerEmail, $memberControlNumber, $memberPassword, $key) {
  include "src/send_email/send_member_details.php";
}
function sendDeleteNotif($customerEmail,$memberControlNumber,$key){
  include "src/send_email/delete_member_email.php";
}
function sendEditNotif($customerEmail,$memberControlNumber,$memberPassword,$key){
  include "src/send_email/edit_member_email.php";
}

