<?php
  try {
    // Include the PHPMailer setup
    include 'src/send_email/smtp_setup.php';

    // Recipients
    $mail->setFrom('emailhere@gmail.com', 'Bevitore');
    $mail->addAddress($email); // Add recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Password Reset PIN';
    $mail->Body = "
      <html>
      <head>
      <style>
        body { font-family: Arial, sans-serif; }
        .container { padding: 20px; border-radius: 10px; }
      </style>
      </head>
      <body>
      <div class='container'>
        <h1>Password Reset PIN</h1>
        <p>Your password reset PIN is: <strong>$pin</strong></p>
        <p>Please use this PIN to reset your password. The PIN is valid for 2 minutes.</p>
      </div>
      </body>
      </html>
    ";

    // Send email
    if ($mail->send()) {
      echo json_encode(['status' => 'success', 'message' => 'PIN sent to your email.']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Error sending email: ' . $mail->ErrorInfo]);
    }
  } 
  catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error sending email: ' . $e->getMessage()]);
  }
?>
