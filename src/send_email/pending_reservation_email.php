<?php
    $key = "TheGreatestNumberIs73";
    try {
      // Include the QR code library
      include 'src/phpqrcode/phpqrcode/qrlib.php';

      // Generate QR code
      QRcode::png($data, $outputFile);
     // Include the PHPMailer setup
     include 'src/send_email/smtp_setup.php';   

     // Recipients
     $mail->setFrom('emailhere@gmail.com', 'Bevitore');
     $customerEmailDecrypted = decryptData($memberEmail,$key);
     $mail->addAddress($customerEmailDecrypted, $customerEmailDecrypted); // Add a recipient

     // Attach the QR code image
     $mail->addAttachment($outputFile); // This will attach the image to the email
     $mail->addEmbeddedImage($outputFile, 'qrcode_image'); // This will embed the image in the email

     // Content
     $mail->isHTML(true); // Set email format to HTML
     $mail->Subject = 'Reservation Details';
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
           <span style='margin:20px;'>Your reservation has been appoved and is now pending! Please pay the amount the send the proof payment</span>
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