
            
<?php
     echo "<input type='hidden' id='qrInput' value='qr code'>";
     echo "<img id='qrcodeImage' src='' alt='QR Code Image'>";
// Require Composer's autoloader
require 'src/PHPMailer/vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    include "src/PHPMailer/send_email/smtp_setup.php";
    
    // Recipients
    $mail->setFrom('emailhere@gmail.com', 'Bevitore');
    $mail->addAddress(decryptData($customerEmail,$key), decryptData($customerEmail,$key)); // Add a recipient

    // Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'Membership Details';
    $mail->Body    = "
        <html>
        <head>
        <style>
          /* Inline CSS for styling */
          body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
          }
          .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          }
          button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
          }


        </style>

        </head>
        <body>

        <div class='container'>
          <h3 style='text-align:center; color:green;'></h3>
          <div style='border:2px solid green; border-radius:10px; padding: 20px; margin:20px;'>
          <h1 style='font:Inika; text-align:center; color:green;'>Admission Status</h1>
          <hr style='color:green; opacity:80%;'>
          <span>Dear Customer,</span>
          <br><br>
          <span style='margin:20px;'>Your request for membership has been accepted.</span>
          <br><br>
          <span style='margin:20px;'>Attached to this message is your official Bevitore Membership account.</span>
          <br><br>
          <img id='qrcodeImage' src='' alt='QR Code Image'>
            <span>Account: ".decryptData($memberControlNumber,$key)." </span>
          <br>
            <span>Password: $memberPassword</span>
          <br><br>
          <span style='margin:20px;'>We look forward to having you at our institution this upcoming academic year. Congratulations and welcome to our school.</span>
        </div>

        <hr>
        <h4>CBevitore Sta.Rosa</h4><br>
        <span><i>This communication is intended solely for the use of the addressee. It may contain confidential or legally priviledged information. If you are not the intended recipient, any disclosure, copying, distribution or taking action in reliance on this communication is strictly prohibited and unlawful. If you received this communication in error, please notify  the sender immediately and delete this communication from your system. Colegio De Santa Rosa De Lima Inc. is neither liable for the proper and complete transimission of this communication nor for any delay in its receipt.</i></span>
        </div>
        </body>
        </html>
        ";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // Send email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


?>
<?php include "src/qr api/QR Code/qr.php"; ?>

<script>
window.addEventListener('load', function() {
    document.getElementById('qrInput').value = "1";
});
</script>