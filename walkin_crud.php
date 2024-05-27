<?php

session_start();
date_default_timezone_set('Asia/Manila');
    include "connect_database.php";
    include "src/get_data_from_database/get_member_account.php";
    include "src/get_data_from_database/get_customer_information.php";
    include "encodeDecode.php";
    $key = "TheGreatestNumberIs73";



  $adminID = $_SESSION['userAdminID'];
   // if($conn){
        // Code to execute when the connection is successful
        if(isset($_POST["selectDate"])){
            $customerFirstName = encryptData(mysqli_real_escape_string($conn, $_POST['firstName']), $key);
            $customerLastName = encryptData(mysqli_real_escape_string($conn, $_POST['lastName']), $key);
            $customerMiddleName = encryptData(mysqli_real_escape_string($conn, $_POST['middleName']), $key);
            $customerEmail = encryptData(mysqli_real_escape_string($conn, $_POST['email']), $key);
            $customerPhone = encryptData(mysqli_real_escape_string($conn, $_POST['contactNumber']), $key);
            $customerBirthdate = encryptData(mysqli_real_escape_string($conn, $_POST['birthDate']), $key);
            $selectDate = mysqli_real_escape_string($conn,$_POST["selectDate"]);
            $selectStartTime = mysqli_real_escape_string($conn,$_POST["selectStartTime"]);
            $selectEndTime = mysqli_real_escape_string($conn,$_POST["selectEndTime"]);
            $poolTable = mysqli_real_escape_string($conn,$_POST["selectTable"]);
            $paymentID = 1;
            $serviceID = 1;
            $walkinStatus = "Playing";

           // Parse HTML date string into a DateTime object
          $date = DateTime::createFromFormat('Y-m-d', $memberValidity);
          // Convert DateTime object to SQL date format (YYYY-MM-DD)
          $sqlDate = $date->format('Y-m-d');
          //current date
          $currentDate = date('Y-m-d');

          //insert customer info
          $qryInsertCustomerInfo = "INSERT INTO `customer_info`(`customerID`, `customerFirstName`, `customerLastName`, `customerMiddleName`, `customerBirthdate`, `customerNumber`, `customerEmail`) VALUES (NULL,?,?,?,?,?,?)";
          $conInsertCustomerInfo = mysqli_prepare($conn, $qryInsertCustomerInfo);
          mysqli_stmt_bind_param($conInsertCustomerInfo, "ssssss", $customerFirstName, $customerLastName, $customerMiddleName, $customerBirthdate, $customerPhone, $customerEmail);
          mysqli_stmt_execute($conInsertCustomerInfo);

          $customerID = mysqli_insert_id($conn);  

          //insert payment information
          $qryInsertPaymentInfo = "INSERT INTO `payment_info`(`paymentID`, `customerID`, `paymentAmount`) VALUES (NULL,?,?)";
          $conInsertPaymentInfo = mysqli_prepare($conn, $qryInsertPaymentInfo);
          mysqli_stmt_bind_param($conInsertPaymentInfo, "is", $customerID, $paymentAmount);
          mysqli_stmt_execute($conInsertPaymentInfo);

          $paymentID = mysqli_insert_id($conn);

          //For reservation information
          $walkinQuery = "INSERT INTO `pool_table_walk_in`(`walkinID`, `tableID`, `customerID`, `paymentID`, `adminID`, `serviceID`, `walkinDate`, `walkinTimeStart`, `walkinTimeEnd`, `walkinStatus`) VALUES (NULL,?,?,?,?,?,?,?,?,?)";
          $walkinPrepare = mysqli_prepare($conn,$reservationQuery);
          mysqli_stmt_bind_param($walkinPrepare,'iiiiissss',$poolTable,$customerID,$paymentID,$adminID,$serviceID,$selectDate,$selectStartTime,$selectEndTime,$walkinStatus);
          mysqli_stmt_execute($walkinPrepare);
          
          }
      mysqli_close($conn);
   
?>