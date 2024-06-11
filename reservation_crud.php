<?php

session_start();
date_default_timezone_set('Asia/Manila');
    include "connect_database.php";
    include "src/get_data_from_database/get_member_account.php";
    include "src/get_data_from_database/get_customer_information.php";
    include "src/get_data_from_database/get_reservation_info.php";
    include "encodeDecode.php";
    $key = "TheGreatestNumberIs73";
    // Include the QR code library
    include 'src/phpqrcode/phpqrcode/qrlib.php';

    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

  if(isset($_POST['selectedRowsReject'])){ 
    $selectedRowsReject = $_POST['selectedRowsReject'];
    $reservationStatus = "Rejected";
        foreach($selectedRowsReject as $rowIdReject){
            //update reservation status
            $qryRejectReservation = "UPDATE `pool_table_reservation` SET reservationStatus = ? where reservationID = ?";
            $connRejectReservation = mysqli_prepare($conn, $qryRejectReservation);
            mysqli_stmt_bind_param($connRejectReservation,'si',$reservationStatus,$rowIdReject);
            mysqli_stmt_execute($connRejectReservation);

            // Data to encode into the QR code
            $data = encryptData($rowIdReject, $key);
            // Output file name
            $outputFile = 'src/phpqrcode/temp/'.$data.'.png';

            //get reservation details 
          foreach($arrayReservationInfo as $reservationInfo){
            if($reservationInfo['reservationID'] == $rowIdReject){
              $memberID = $reservationInfo['memberID'];
                foreach($arrayMemberAccount as $memberAccount){
                  if($memberAccount['memberID'] == $memberID){
                    $memberEmail = $memberAccount['customerEmail'];
                    pendingEmail($memberEmail,$rowIdReject,$data,$outputFile);
                  }
                  
                }
            }

          }
          

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


          // Data to encode into the QR code
          $data = encryptData($rowIdAccept, $key);
          // Output file name
          $outputFile = 'src/phpqrcode/temp/'.$data.'.png';

          $imageName = $data.".png";
 

          //For qr code
          $qrQuery = "INSERT INTO `qr_code`(`qrID`,`reservationID`,`qrImage`) VALUES (NULL,?,?)";
          $qrPrepare = mysqli_prepare($conn,$qrQuery);
          mysqli_stmt_bind_param($qrPrepare,"is",$rowIdAccept,$imageName);
          mysqli_stmt_execute($qrPrepare);

           //get reservation details 
           foreach($arrayReservationInfo as $reservationInfo){
            if($reservationInfo['reservationID'] == $rowIdAccept){
              $memberID = $reservationInfo['memberID'];
                foreach($arrayMemberAccount as $memberAccount){
                  if($memberAccount['memberID'] == $memberID){
                    $memberEmail = $memberAccount['customerEmail'];
                    pendingEmail($memberEmail,$rowIdAccept,$data,$outputFile);
                  }
                  
                }
            }

          }

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
          
          //onProcessEmail($selectDate,$selectStartTime,$selectEndTime,$reservationStatus,$email);
      }
mysqli_close($conn);

    }

function onProcessEmail($selectDate,$selectStartTime,$selectEndTime,$reservationStatus,$email){

try {
    // Include the PHPMailer setup
    include 'src/send_email/smtp_setup.php';   
    
    // Recipients
    $mail->setFrom('emailhere@gmail.com', 'Bevitore');
    $customerEmailDecrypted = decryptData($customerEmail, $key);
    $mail->addAddress($customerEmailDecrypted, $customerEmailDecrypted); // Add a recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Membership Details';
    $mail->Body    = "
        <html>
        <head>
        <style>
          body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
          .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
          button { padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border: none; border-radius: 5px; cursor: pointer; }
        </style>
        </head>
        <body>
        <div class='container'>
          <h3 style='text-align:center; color:green;'></h3>
          <div style='border:2px solid green; border-radius:10px; padding: 20px; margin:20px;'>
          <h1 style='font:Inika; text-align:center; color:yellow;'>Resevation Status</h1>
          <hr style='color:green; opacity:80%;'>
          <span>Dear Customer,</span>
          <br><br>
          <span style='margin:20px;'>Resevation details:</span>
          <br><br>
          <span style='margin:20px;'>Your reservation is being reviewed</span>
          <br><br>
            <span>Account:  </span>
          <br>
            <span>Password: <span>
          <br><br>
        </div>

        <hr>
        <h4>Bevitore Sta.Rosa</h4><br>
        <span><i>This communication is intended solely for the use of the addressee. It may contain confidential or legally privileged information. If you are not the intended recipient, any disclosure, copying, distribution or taking action in reliance on this communication is strictly prohibited and unlawful. If you received this communication in error, please notify the sender immediately and delete this communication from your system. Bevitore Sta.Rosa is neither liable for the proper and complete transmission of this communication nor for any delay in its receipt.</i></span>
        </div>
        </body>
        </html>
        ";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // Send email
    if ($mail->send()) {
        echo 'Message has been sent';
    } else {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo 'Message could not be sent. Error: ' . $e->getMessage();
}

}

function pendingEmail($memberEmail,$rowIdAccept,$data,$outputFile){

  try {


    // Generate QR code
    QRcode::png($data, $outputFile);
   // Include the PHPMailer setup
   include 'src/send_email/smtp_setup.php';   
   
   // Recipients
   $mail->setFrom('emailhere@gmail.com', 'Bevitore');
   $customerEmailDecrypted = decryptData($memberEmail, $key);
   $mail->addAddress($customerEmailDecrypted, $customerEmailDecrypted); // Add a recipient

   // Attach the QR code image
   $mail->addAttachment($outputFile); // This will attach the image to the email
   $mail->addEmbeddedImage($outputFile, 'qrcode_image'); // This will embed the image in the email

   // Content
   $mail->isHTML(true); // Set email format to HTML
   $mail->Subject = 'Membership Details';
   $mail->Body    = "
       <html>
       <head>
       <style>
         body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
         .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
         button { padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border: none; border-radius: 5px; cursor: pointer; }
       </style>
       </head>
       <body>
       <div class='container'>
         <h3 style='text-align:center; color:green;'></h3>
         <div style='border:2px solid green; border-radius:10px; padding: 20px; margin:20px;'>
         <h1 style='font:Inika; text-align:center; color:yellow;'>Resevation Status</h1>
         <hr style='color:green; opacity:80%;'>
         <span>Dear Customer,</span>
         <br><br>
         <span style='margin:20px;'>Your reservation has been appoved and is now pending! Please pay the amount and the send the proof payment</span>
         <br><br>
         <span style='margin:20px;'>Image below is the qr code of your reservation</span>
         <br><br>
         <img src='cid:qrcode_image' alt='QR Code'> <!-- Referencing the embedded image -->
          <br><br>
           <span>Link:  </span>
         <br>
       </div>

       <hr>
       <h4>Bevitore Sta.Rosa</h4><br>
       <span><i>This communication is intended solely for the use of the addressee. It may contain confidential or legally privileged information. If you are not the intended recipient, any disclosure, copying, distribution or taking action in reliance on this communication is strictly prohibited and unlawful. If you received this communication in error, please notify the sender immediately and delete this communication from your system. Bevitore Sta.Rosa is neither liable for the proper and complete transmission of this communication nor for any delay in its receipt.</i></span>
       </div>
       </body>
       </html>
       ";
   $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

   // Send email
   if ($mail->send()) {
       echo 'Message has been sent';
   } else {
       echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
   }
} catch (Exception $e) {
   echo 'Message could not be sent. Error: ' . $e->getMessage();
}
}