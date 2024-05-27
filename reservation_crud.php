<?php

session_start();
date_default_timezone_set('Asia/Manila');
    include "connect_database.php";
    include "src/get_data_from_database/get_member_account.php";
    include "src/get_data_from_database/get_customer_information.php";
    include "encodeDecode.php";
    $key = "TheGreatestNumberIs73";


  if(isset($_POST['selectedRowsReject'])){ 
    $selectedRowsReject = $_POST['selectedRowsReject'];
    $reservationStatus = "Rejected";
        foreach($selectedRowsReject as $rowIdReject){
            //update reservation status
            $qryRejectReservation = "UPDATE `pool_table_reservation` SET reservationStatus = ? where reservationID = ?";
            $connRejectReservation = mysqli_prepare($conn, $qryRejectReservation);
            mysqli_stmt_bind_param($connRejectReservation,'si',$reservationStatus,$rowIdReject);
            mysqli_stmt_execute($connRejectReservation);

        }
      // Assuming you want to return a success message
        echo "Rows deleted successfully";
        unset($_POST['selectedRowsReject']);
}

if(isset($_POST['selectedRowsAccept'])){ 
  $selectedRowsAccept = $_POST['selectedRowsAccept'];
  $reservationStatus = "Pending";
      foreach($selectedRowsAccept as $rowIdAccept){
          //update reservation status
          $qryAcceptReservation = "UPDATE `pool_table_reservation` SET reservationStatus = ? where reservationID = ?";
          $connAcceptReservation = mysqli_prepare($conn, $qryAcceptReservation);
          mysqli_stmt_bind_param($connAcceptReservation,'si',$reservationStatus,$rowIdAccept);
          mysqli_stmt_execute($connAcceptReservation);

      }
    // Assuming you want to return a success message
      echo "Rows deleted successfully";
      unset($_POST['selectedRowsAccept']);
}

if (isset($_SESSION['userMemberID'])) {
  $userID = $_SESSION['userMemberID'];
   // if($conn){
        // Code to execute when the connection is successful
        if(isset($_POST["selectDate"])){
          $selectDate = mysqli_real_escape_string($conn,$_POST["selectDate"]);
          $timeDifference = 0;
          $selectStartTime = mysqli_real_escape_string($conn,$_POST["selectStartTime"]);
          $selectEndTime = mysqli_real_escape_string($conn,$_POST["selectEndTime"]);
          $sTime = explode(":",$selectStartTime); $startTime = (int)$sTime[0];
          $eTime = explode(":",$selectEndTime); $endTime = (int)$eTime[0];
              if($startTime < $endTime){
                  $timeDifference = $endTime - $startTime;
              }
              else{
                  $timeDifference = $startTime - $endTime;
              }
          $poolTable = mysqli_real_escape_string($conn,$_POST["selectTable"]);
          $hoursID = $timeDifference;
          $paymentID = 1;
          $reservationStatus = "On Process";

          //For reservation information
          $reservationQuery = "INSERT INTO `pool_table_reservation`(`reservationID`, `tableID`, `memberID`, `paymentID`,`superAdminID`, `serviceID`, `reservationDate`, `reservationTimeStart`, `reservationTimeEnd`, `reservationStatus`) VALUES (NULL,?,?,NULL,NULL,1,?,?,?,?)";
          $reservationPrepare = mysqli_prepare($conn,$reservationQuery);
          mysqli_stmt_bind_param($reservationPrepare,"iissss",$poolTable,$userID,$selectDate,$selectStartTime,$selectEndTime,$reservationStatus);
          mysqli_stmt_execute($reservationPrepare);
          
          header("location:booking_form.php");
      }
mysqli_close($conn);

    }
?>