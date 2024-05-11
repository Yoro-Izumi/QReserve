<?php
include "connect_database.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";
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

    $qryInsertCustomerInfo = "INSERT INTO `customer_info`(`customerID`, `customerFirstName`, `customerLastName`, `customerMiddleName`, `customerBirthdate`, `customerNumber`, `customerEmail`) VALUES (NULL,?,?,?,?,?,?)";
    $conInsertCustomerInfo = mysqli_prepare($conn, $qryInsertCustomerInfo);
    mysqli_stmt_bind_param($conInsertCustomerInfo, "ssssss", $customerFirstName, $customerLastName, $customerMiddleName, $customerBirthdate, $customerPhone, $customerEmail);
    mysqli_stmt_execute($conInsertCustomerInfo);
    $customerID = mysqli_insert_id($conn);

    $qryInsertMemberDetails = "INSERT INTO `member_details`(`memberID`, `membershipID`, `perk_id`, `membershipPassword`, `customerID`, `creationDate`, `validityDate`, `superAdminID`) VALUES (NULL,?,?,?,?,?,?,?)";
    $conInsertMemberDetails = mysqli_prepare($conn, $qryInsertMemberDetails);
    mysqli_stmt_bind_param($conInsertMemberDetails, "sssssss", $memberControlNumber, $y, $hashedPassword, $customerID, $currentDate, $sqlDate, $userSuperAdmin);
    mysqli_stmt_execute($conInsertMemberDetails);
    unset($_POST['firstName']);
  }

  if(isset($_POST['selectedRows'])){ 
    $selectedRows = $_POST['selectedRows'];
        foreach($selectedRows as $rowId){
            //delete member account
            $qryDeleteMemberAccount = "DELETE FROM `member_details` WHERE customerID = ?";
            $connDeleteMemberAccount = mysqli_prepare($conn, $qryDeleteMemberAccount);
            mysqli_stmt_bind_param($connDeleteMemberAccount,'i',$rowId);
            mysqli_stmt_execute($connDeleteMemberAccount);

            //delete member info (customer_information)
            $qryDeleteMemberInfo = "DELETE FROM `customer_info` WHERE customerID = ?";
            $connDeleteMemberInfo = mysqli_prepare($conn, $qryDeleteMemberInfo);
            mysqli_stmt_bind_param($connDeleteMemberInfo,'i',$rowId);
            mysqli_stmt_execute($connDeleteMemberInfo);
        }
      // Assuming you want to return a success message
        echo "Rows deleted successfully";
        unset($_POST['selectedRows']);
}

}

?>