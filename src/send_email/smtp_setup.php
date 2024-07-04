<?php
// Require Composer's autoloader
include "src/PHPMailer/vendor/autoload.php";

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

// Server settings for Gmail SMTP
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com'; // SMTP server for Gmail
$mail->SMTPAuth   = true;             // Enable SMTP authentication
$mail->Username   = 'qreserveemail@gmail.com'; // Your Gmail address
$mail->Password   = 'wqow mxei iruk aepm';   // Your app password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
$mail->Port       = 587;              // TCP port to connect to
