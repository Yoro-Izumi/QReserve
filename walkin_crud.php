<?php

session_start();
date_default_timezone_set('Asia/Manila');
    include "connect_database.php";
    include "src/get_data_from_database/get_member_account.php";
    include "src/get_data_from_database/get_customer_information.php";
    include "src/get_data_from_database/get_service.php";
    include "encodeDecode.php";
    $key = "TheGreatestNumberIs73";

    $currentDateTime = date('Y-m-d H:i:s');



  $adminID = $_SESSION['userAdminID'];
   // if($conn){
        // Code to execute when the connection is successful
        if(isset($_POST["selectStartTime"])){
            $customerFirstName = encryptData(mysqli_real_escape_string($conn, $_POST['firstName']), $key);
            $customerLastName = encryptData(mysqli_real_escape_string($conn, $_POST['lastName']), $key);
            $customerMiddleName = encryptData(mysqli_real_escape_string($conn, $_POST['middleName']), $key);
            $customerFullName = $customerFirstName."".$customerMiddleName." ".$customerLastName;
            $customerEmail = encryptData(mysqli_real_escape_string($conn, $_POST['email']), $key);
            $customerPhone = encryptData(mysqli_real_escape_string($conn, $_POST['contactNumber']), $key);
            $customerBirthdate = encryptData(mysqli_real_escape_string($conn, $_POST['birthDate']), $key);
            $selectDate = mysqli_real_escape_string($conn,$_POST["selectDate"]);
            $selectStartTime = mysqli_real_escape_string($conn,$_POST["selectStartTime"]).":00";
            $selectEndTime = mysqli_real_escape_string($conn,$_POST["selectEndTime"]).":00";
            $duration = 1;
              // get duration of time
              $sTime = explode(":",$selectStartTime);
              $eTime = explode(":",$selectEndTime);
              $startTime = (int)$sTime[0];
              $endTime = (int)$eTime[0];
              if($endTime > $startTime){
                $duration = $endTime - $startTime;
              }
              else{
                $duration = $startTime - $endTime;
              }
              
              
            $poolTable = mysqli_real_escape_string($conn,$_POST["selectTable"]);
            $paymentID = 1;
            $serviceID = 1; 
            $walkinStatus = "Reserved";
            $paymentAmount = 0.00; 

            //get service price and update payment amount
            $qryGetServicePrice = "SELECT serviceRate from services where serviceID = ? ";
            $conGetServicePrice = mysqli_prepare($conn, $qryGetServicePrice);
            mysqli_stmt_bind_param($conGetServicePrice, 'i', $serviceID);
            mysqli_stmt_execute($conGetServicePrice);
            $result = mysqli_stmt_get_result($conGetServicePrice);
            $servicePrice = mysqli_fetch_assoc($result)['serviceRate'];
            $paymentAmount = $servicePrice * $duration;


          // Convert DateTime object to SQL date format (YYYY-MM-DD)
          //$sqlDate = $selectDate->format('Y-m-d');
          //current date
          $currentDate = date('Y-m-d');

          //insert customer info
          $qryInsertCustomerInfo = "INSERT INTO `customer_info`(`customerID`, `customerFirstName`, `customerLastName`, `customerMiddleName`, `customerBirthdate`, `customerNumber`, `customerEmail`) VALUES (NULL,?,?,?,?,?,?)";
          $conInsertCustomerInfo = mysqli_prepare($conn, $qryInsertCustomerInfo);
          mysqli_stmt_bind_param($conInsertCustomerInfo, "ssssss", $customerFirstName, $customerLastName, $customerMiddleName, $customerBirthdate, $customerPhone, $customerEmail);
          mysqli_stmt_execute($conInsertCustomerInfo);

          $customerID = mysqli_insert_id($conn);  

          //insert payment information
          $qryInsertPaymentInfo = "INSERT INTO `payment_history`(`paymentID`, `customerID`, `paymentAmount`) VALUES (NULL,?,?)";
          $conInsertPaymentInfo = mysqli_prepare($conn, $qryInsertPaymentInfo);
          mysqli_stmt_bind_param($conInsertPaymentInfo, "id", $customerID, $paymentAmount);
          mysqli_stmt_execute($conInsertPaymentInfo);

          $paymentID = mysqli_insert_id($conn);

          //For walkin information
          $walkinQuery = "INSERT INTO `pool_table_walk_in`(`walkinID`, `tableID`, `customerID`, `paymentID`, `adminID`, `serviceID`, `walkinDate`, `walkinTimeStart`, `walkinTimeEnd`, `walkinStatus`, `walkinCreationDate`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?)";
          $walkinPrepare = mysqli_prepare($conn,$walkinQuery);
          mysqli_stmt_bind_param($walkinPrepare,'iiiiisssss',$poolTable,$customerID,$paymentID,$adminID,$serviceID,$selectDate,$selectStartTime,$selectEndTime,$walkinStatus,$currentDateTime);
          mysqli_stmt_execute($walkinPrepare);

          //For updating pool table info
          //$qryUpdatePoolTable = "UPDATE `pool_tables` SET `poolTableNumber`='[value-2]',`poolTableStatus`='[value-3]',`customerName`='[value-4]',`timeStarted`='[value-5]',`timeEnd`='[value-6]' WHERE `poolTableID`=?";
          
          }
      mysqli_close($conn);
   
?>