<?php
session_start();
date_default_timezone_set('Asia/Manila');
include "connect_database.php";
include "src/get_data_from_database/get_admin_accounts.php";
include "src/get_data_from_database/get_super_admin_accounts.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $_SESSION['emailPassword'] = $email;

    // Check if the email is not empty
    if ($email === "" || $email === " ") {
        echo json_encode(['status' => 'error', 'message' => 'Please enter your email address']);
        exit();
    }

    // Check if the email ends with @gmail.c0m
    if (preg_match('/@gmail\.c0m$/', $email)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
        exit();
    }

    // Check if the email is not a Gmail address
    if (!preg_match('/@gmail\.com$/', $email)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
        exit();
    }

    $emailExists = false;

    // Check in super admin accounts
    foreach ($arraySuperAdminAccount as $superAdmin) {
        if (decryptData($superAdmin['superAdminEmail'], $key) === $email) {
            $emailExists = true;
            break;
        }
    }

    // Check in admin accounts if not found in super admin accounts
    if (!$emailExists) {
        foreach ($arrayAdminAccount as $admin) {
            if (decryptData($admin['adminEmail'], $key) === $email) {
                $emailExists = true;
                break;
            }
        }
    }

    if (!$emailExists) {
        echo json_encode(['status' => 'error', 'message' => 'Email does not exist.']);
        exit();
    }

    $pin = rand(100000, 999999); // Generate a 6-digit PIN
    $_SESSION['pin'] = $pin;
    $_SESSION['pin_time'] = time(); // Save the current time

    include "src/send_email/send_pin_number.php";

    exit();
}
?>
