<?php 
include "connect_database.php";
include "encodeDecode.php";
include "src/get_data_from_database/get_admin_accounts.php";
$key = "TheGreatestNumberIs73";
session_start();
date_default_timezone_set('Asia/Manila');

if (isset($_SESSION["userSuperAdminID"])) {
  $superAdminID = $_SESSION["userSuperAdminID"];
  if (isset($_POST['firstName'])) {
    $firstName = encryptData(mysqli_real_escape_string($conn, $_POST['firstName']), $key);
    $lastName = encryptData(mysqli_real_escape_string($conn, $_POST['lastName']), $key);
    $middleName = encryptData(mysqli_real_escape_string($conn, $_POST['middleName']), $key);
    $email = encryptData(mysqli_real_escape_string($conn, $_POST['email']), $key);
    $username = encryptData(mysqli_real_escape_string($conn, $_POST['username']), $key);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // $adminSex = $_POST['adminSex']);
    $adminSex = $_POST['adminSex'];
    $contactNumber = encryptData(mysqli_real_escape_string($conn, $_POST['contactNumber']), $key);
    $shift = intVal($_POST['adminShift']);

    // Hash the password using Argon2
    $options = [
      'memory_cost' => 1 << 17, // 128MB memory cost (default)
      'time_cost' => 4,       // 4 iterations (default)
      'threads' => 3,         // Use 3 threads for processing (default)
    ];
    $hashedPassword = password_hash($password, PASSWORD_ARGON2I, $options);

    // here is where information of admin is inserted
    $qryInsertAdminInfo = "INSERT INTO `admin_info`(`adminInfoID`, `adminLastName`, `adminFirstName`, `adminMiddleName`, `adminSex`, `adminContactNumber`, `adminEmail`) VALUES (NULL,?,?,?,?,?,?)";
    $conInsertAdminInfo = mysqli_prepare($conn, $qryInsertAdminInfo);
    mysqli_stmt_bind_param($conInsertAdminInfo, 'ssssss', $lastName, $firstName, $middleName, $adminSex, $contactNumber, $email);
    mysqli_stmt_execute($conInsertAdminInfo);

    //get the id of admin info that was inserted
    $adminInfoID = mysqli_insert_id($conn);

    //here is where the admin account is inserted
    $qryInsertAdminAccount = "INSERT INTO `admin_accounts`(`adminID`, `superAdminID`, `adminInfoID`,`adminShiftID`, `adminUsername`, `adminPassword`) VALUES (NULL,?,?,?,?,?)";
    $conInsertAdminAccount = mysqli_prepare($conn, $qryInsertAdminAccount);
    mysqli_stmt_bind_param($conInsertAdminAccount, 'iiiss', $superAdminID, $adminInfoID, $shift, $username, $hashedPassword);
    mysqli_stmt_execute($conInsertAdminAccount);

    sendAdminEmail($email,$username,$password,$key);
    
    unset($_POST['firstName']);
  }

if(isset($_POST['selectedRows'])){ 
    $selectedRows = $_POST['selectedRows'];
        foreach($selectedRows as $rowId){
            //delete admin account
            $qryDeleteAdminAccount = "DELETE FROM `admin_accounts` WHERE adminInfoID = ?";
            $connDeleteAdminAccount = mysqli_prepare($conn, $qryDeleteAdminAccount);
            mysqli_stmt_bind_param($connDeleteAdminAccount,'i',$rowId);
            mysqli_stmt_execute($connDeleteAdminAccount);

            //delete admin info
            $qryDeleteAdminInfo = "DELETE FROM `admin_info` WHERE adminInfoID = ?";
            $connDeleteAdminInfo = mysqli_prepare($conn, $qryDeleteAdminInfo);
            mysqli_stmt_bind_param($connDeleteAdminInfo,'i',$rowId);
            mysqli_stmt_execute($connDeleteAdminInfo);

          foreach($arrayAdminAccount as $adminAccount){
             if($adminAccount['adminInfoID'] == $rowId){
               $adminEmail = $adminAccount['adminEmail'];
               $adminUsername = $adminAccount['adminUsername'];
               sendDeleteNotif($adminEmail,$adminUsername,$key);
             }
          }
          
        }
      // Assuming you want to return a success message
        echo "Rows deleted successfully";
        unset($_POST['selectedRows']);
}

//update admin part here

if (isset($_POST['updateAdmin'])) {
  $adminInfoID = $_POST['updateAdmin'];
  $firstName = encryptData(mysqli_real_escape_string($conn, $_POST['FirstName']), $key);
  $lastName = encryptData(mysqli_real_escape_string($conn, $_POST['lastName']), $key);
  $middleName = encryptData(mysqli_real_escape_string($conn, $_POST['middleName']), $key);
  $email = encryptData(mysqli_real_escape_string($conn, $_POST['email']), $key);
  $username = encryptData(mysqli_real_escape_string($conn, $_POST['username']), $key);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $sex = $_POST['adminSex'];
  $contactNumber = encryptData(mysqli_real_escape_string($conn, $_POST['contactNumber']), $key);
  $shift = intVal($_POST['adminShift']);

  // Hash the password using Argon2
  $options = [
    'memory_cost' => 1 << 17, // 128MB memory cost (default)
    'time_cost' => 4,       // 4 iterations (default)
    'threads' => 3,         // Use 3 threads for processing (default)
  ];
  $hashedPassword = password_hash($password, PASSWORD_ARGON2I, $options);

  //here is where the admin information is updated
  $qryUpdateAdminInfo = "UPDATE `admin_info` SET `adminLastName`= ?,`adminFirstName`= ?,`adminMiddleName`= ?,`adminSex`= ?,`adminContactNumber`= ?,`adminEmail`= ? WHERE adminInfoID = ?";
  $conUpdateAdminInfo = mysqli_prepare($conn, $qryUpdateAdminInfo);
  mysqli_stmt_bind_param($conUpdateAdminInfo, 'ssssssi', $lastName, $firstName, $middleName, $sex, $contactNumber, $email, $adminInfoID);
  mysqli_stmt_execute($conUpdateAdminInfo);

  // here is where account of admin is updated
  if($password === "."){
    $qryUpdateAdminAccounts = "UPDATE `admin_accounts` SET `adminShiftID`= ?,`adminUsername`= ? WHERE adminInfoID = ?";
    $conUpdateAdminAccounts = mysqli_prepare($conn, $qryUpdateAdminAccounts);
    mysqli_stmt_bind_param($conUpdateAdminAccounts, 'isi', $shift, $username, $adminInfoID);
    mysqli_stmt_execute($conUpdateAdminAccounts);
  }
  else{
    $qryUpdateAdminAccounts = "UPDATE `admin_accounts` SET `adminShiftID`= ?,`adminUsername`= ?,`adminPassword`= ? WHERE adminInfoID = ?";
    $conUpdateAdminAccounts = mysqli_prepare($conn, $qryUpdateAdminAccounts);
    mysqli_stmt_bind_param($conUpdateAdminAccounts, 'issi', $shift, $username,$hashedPassword,$adminInfoID);
    mysqli_stmt_execute($conUpdateAdminAccounts); 
  }
  
  sendEditNotif($email,$username,$password,$key);   
  //get the id of admin info that was updated
  //$adminInfoID = mysqli_insert_id($conn);
}


}

function sendAdminEmail($email,$adminUsername, $password, $key) {
  include "src/send_email/send_admin_details.php";
}
function sendDeleteNotif($email,$adminUsername,$key){
  include "src/send_email/delete_admin_email.php";
}
function sendEditNotif($email,$adminUsername,$password,$key){
  include "src/send_email/edit_admin_email.php";
}