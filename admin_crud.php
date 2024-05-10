<?php 
include "connect_database.php";
include "encodeDecode.php";
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
    $sex = encryptData(mysqli_real_escape_string($conn, $_POST['sex']), $key);
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
    mysqli_stmt_bind_param($conInsertAdminInfo, 'ssssss', $lastName, $firstName, $middleName, $sex, $contactNumber, $email);
    mysqli_stmt_execute($conInsertAdminInfo);

    //get the id of admin info that was inserted
    $adminInfoID = mysqli_insert_id($conn);

    //here is where the admin account is inserted
    $qryInsertAdminAccount = "INSERT INTO `admin_accounts`(`adminID`, `superAdminID`, `adminInfoID`,`adminShiftID`, `adminUsername`, `adminPassword`) VALUES (NULL,?,?,?,?,?)";
    $conInsertAdminAccount = mysqli_prepare($conn, $qryInsertAdminAccount);
    mysqli_stmt_bind_param($conInsertAdminAccount, 'iiiss', $superAdminID, $adminInfoID, $shift, $username, $hashedPassword);
    mysqli_stmt_execute($conInsertAdminAccount);
    unset($_POST['firstName']);
  }


//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  /*  if(isset($_POST['adminName'])){
        $adminName = mysqli_real_escape_string($conn, $_POST['adminName']);
        $serviceCapacity = mysqli_real_escape_string($conn, $_POST['capacity']);
        $serviceRate = mysqli_real_escape_string($conn, $_POST['serviceRate']);
        $hour = 1;
        $qryAddNewPrice = "INSERT INTO `hour_price`(`hoursID`, `numberOfHours`, `normalPrice`, `succeedingHourPrice`) VALUES (NULL,?,?,?)";
        $connAddNewPrice = mysqli_prepare($conn, $qryAddNewPrice);
        mysqli_stmt_bind_param($connAddNewPrice,'iii',$hour,$serviceRate,$serviceRate);
        mysqli_stmt_execute($connAddNewPrice);

        $priceID = mysqli_insert_id($conn);

        //add new service
        $qryAddNewService = "INSERT INTO `services`(`serviceID`, `serviceName`, `serviceCapacity`, `serviceRate`, `serviceImage`, `superAdminID`) VALUES (NULL,?,?,?,?,?)";
        $connAddNewService = mysqli_prepare($conn, $qryAddNewService);
        mysqli_stmt_bind_param($connAddNewService,'siisi',$serviceName,$serviceCapacity,$priceID,$serviceImage,$_SESSION["userSuperAdminID"]);
        mysqli_stmt_execute($connAddNewService);

        unset($_POST['serviceName']);
        unset($_POST['capacity']);
        unset($_POST['serviceRate']);
    }
}
    if(isset($_POST['update_service_button'])){
       // $qryUpdateService = "UPDATE `services` SET `serviceID`=[value-1],`serviceName`=[value-2],`serviceCapacity`=[value-3],`serviceRate`=[value-4],`serviceImage`=[value-5],`superAdminID`=[value-6] WHERE serviceID = ?";

    }
*/
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
        }
      // Assuming you want to return a success message
        echo "Rows deleted successfully";
        unset($_POST['selectedRows']);
}

if (isset($_POST['adminID'])) {
  $adminID = mysqli_real_escape_string($conn, $_POST['adminID']);
  $firstName = encryptData(mysqli_real_escape_string($conn, $_POST['firstName']), $key);
  $lastName = encryptData(mysqli_real_escape_string($conn, $_POST['lastName']), $key);
  $middleName = encryptData(mysqli_real_escape_string($conn, $_POST['middleName']), $key);
  $email = encryptData(mysqli_real_escape_string($conn, $_POST['email']), $key);
  $username = encryptData(mysqli_real_escape_string($conn, $_POST['username']), $key);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $sex = encryptData(mysqli_real_escape_string($conn, $_POST['sex']), $key);
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
  $qryUpdateAdminInfo = "UPDATE `admin_info` SET adminLastName`=?,`adminFirstName`=?,`adminMiddleName`=?,`adminSex`=?,`adminContactNumber`=?,`adminEmail`=? WHERE `adminInfoID`=?";
  $conUpdateAdminInfo = mysqli_prepare($conn, $qryUpdateAdminInfo);
  mysqli_stmt_bind_param($conUpdateAdminInfo,'ssssssi', $lastName, $firstName, $middleName, $sex, $contactNumber, $email, $adminID);
  mysqli_stmt_execute($conUpdateAdminInfo);

  //here is where the admin account is inserted
  $qryUpdateAdminAccount = "INSERT INTO `admin_accounts` SET `superAdminID`=?,`adminShiftID`=?,`adminUsername`=?,`adminPassword`=? WHERE `adminInfoID`=?";
  $conUpdateAdminAccount = mysqli_prepare($conn, $qryUpdateAdminAccount);
  mysqli_stmt_bind_param($conUpdateAdminAccount, 'iiiss', $superAdminID, $shift, $username, $hashedPassword, $adminID);
  mysqli_stmt_execute($conUpdateAdminAccount);

  unset($_POST['adminID']);
}

}