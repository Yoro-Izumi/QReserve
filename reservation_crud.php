<?php

session_start();
date_default_timezone_set('Asia/Manila');
    include "connect_database.php";
    include "src/get_data_from_database/get_member_account.php";
    include "src/get_data_from_database/get_customer_information.php";
    include "src/get_data_from_database/get_reservation_info.php";
    include "src/get_data_from_database/convert_to_normal_time.php";
    include "encodeDecode.php";
    $key = "TheGreatestNumberIs73";

    $currentDateTime = date('Y-m-d H:i:s');
    //$date = date('Y-m-d');
    //$time = date('H:i:s');

    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

if (isset($_POST['selectedRowsReject'])) { 
    $selectedRowsReject = json_decode($_POST['selectedRowsReject'], true);
    $reservationStatus = "Rejected";
    $reason = $_POST['rejectionReason']; // get rejection reason
    $txtReason = $_POST['thirdOptionTextarea']; // third option text area

    if ($reason == 'thirdOption') {
        $reason = $txtReason;
    }

    foreach ($selectedRowsReject as $rowIdReject) {
        // Update reservation status
        $qryRejectReservation = "UPDATE `pool_table_reservation` SET reservationStatus = ? WHERE reservationID = ?";
        $connRejectReservation = mysqli_prepare($conn, $qryRejectReservation);
        mysqli_stmt_bind_param($connRejectReservation, 'si', $reservationStatus, $rowIdReject);
        mysqli_stmt_execute($connRejectReservation);

        // Data to encode into the QR code
        $data = encryptData($rowIdReject, $key);
        // Output file name
        $outputFile = 'src/phpqrcode/temp/' . $data . '.png';

        // Get reservation details 
        foreach ($arrayReservationInfo as $reservationInfo) {
            if ($reservationInfo['reservationID'] == $rowIdReject) {
                $date = convertToNormalDate($reservationInfo['reservationDate']);
                $time = convertToNormalTime($reservationInfo['reservationTimeStart']);
                $memberID = $reservationInfo['memberID'];
                foreach ($arrayMemberAccount as $memberAccount) {
                    if ($memberAccount['memberID'] == $memberID) {
                        $memberEmail = $memberAccount['customerEmail'];
                        RejectedEmail($memberEmail, $rowIdReject, $reason, $date, $time);
                    }
                }
            }
        }
    }

    // Assuming you want to return a success message
    echo "Rows updated successfully";
    unset($_POST['selectedRowsReject']);
}



if(isset($_POST['selectedRowsAccept'])){ 
  $selectedRowsAccept = $_POST['selectedRowsAccept'];
  $reservationStatus = "Reserved";
  $randomNum = rand(10,100000000);
  
      foreach($selectedRowsAccept as $rowIdAccept){
          //update reservation status
          $qryAcceptReservation = "UPDATE `pool_table_reservation` SET reservationStatus = ? where reservationID = ?";
          $connAcceptReservation = mysqli_prepare($conn, $qryAcceptReservation);
          mysqli_stmt_bind_param($connAcceptReservation,'si',$reservationStatus,$rowIdAccept);
          mysqli_stmt_execute($connAcceptReservation);


          // Data to encode into the QR code
          $data = $randomNum."_".$rowIdAccept;
          // Output file name
          $outputFile = 'src/phpqrcode/temp/qreservation_'.$data.'.png';

          $imageName = 'qreservation_'.$data.".png";
 

          //For qr code
          $qrQuery = "INSERT INTO `qr_code`(`qrID`,`reservationID`,`qrImage`,`codeQR`) VALUES (NULL,?,?,?)";
          $qrPrepare = mysqli_prepare($conn,$qrQuery);
          mysqli_stmt_bind_param($qrPrepare,"iss",$rowIdAccept,$imageName,$data);
          mysqli_stmt_execute($qrPrepare);

           //get reservation details 
           foreach($arrayReservationInfo as $reservationInfo){
            if($reservationInfo['reservationID'] == $rowIdAccept){
            $date  = convertToNormalDate($reservationInfo['reservationDate']);
            $time  = convertToNormalTime($reservationInfo['reservationTimeStart']);
              $memberID = $reservationInfo['memberID'];
                foreach($arrayMemberAccount as $memberAccount){
                  if($memberAccount['memberID'] == $memberID){
                    $memberEmail = $memberAccount['customerEmail'];
                    pendingEmail($memberEmail,$rowIdAccept,$data,$outputFile,$date,$time);
                  }
                  
                }
            }

          }

      }
    // Assuming you want to return a success message
      echo "Rows Updated successfully";
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
          $reservationQuery = "INSERT INTO `pool_table_reservation`(`reservationID`, `tableID`, `memberID`, `paymentID`,`superAdminID`, `serviceID`, `reservationDate`, `reservationTimeStart`, `reservationTimeEnd`, `reservationStatus`, `reservationCreationDate`) VALUES (NULL,?,?,NULL,NULL,1,?,?,?,?,?)";
          $reservationPrepare = mysqli_prepare($conn,$reservationQuery);
          mysqli_stmt_bind_param($reservationPrepare,"iisssss",$poolTable,$userID,$selectDate,$selectStartTime,$selectEndTime,$reservationStatus,$currentDateTime);
          mysqli_stmt_execute($reservationPrepare);
          
          //onProcessEmail($selectDate,$selectStartTime,$selectEndTime,$reservationStatus,$email);
      }
mysqli_close($conn);

}

function pendingEmail($memberEmail,$rowIdAccept,$data,$outputFile,$date,$time){
include "src/send_email/pending_reservation_email.php";
}

function RejectedEmail($memberEmail, $rowIdReject, $reason, $date, $time){
include "src/send_email/rejected_reservation_email.php";
}