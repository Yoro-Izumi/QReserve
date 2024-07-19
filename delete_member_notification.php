<?php
// Include necessary files
include "connect_database.php";
include "encodeDecode.php";
include "src/get_data_from_database/get_customer_information.php";
include "src/get_data_from_database/get_member_account.php";
include "src/get_data_from_database/convert_to_normal_time.php";

// Configuration
$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Current date and time
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

// File to store last execution dates
$lastExecutionFile = 'last_execution_date.txt';

// Read last execution data or initialize if file doesn't exist or contains '[]'
$lastExecutionData = [];
if (file_exists($lastExecutionFile)) {
    $lastExecutionDataContent = file_get_contents($lastExecutionFile);
    if ($lastExecutionDataContent !== false && $lastExecutionDataContent !== '[]') {
        $lastExecutionData = json_decode($lastExecutionDataContent, true);
    }
}

// Array to store current execution data
$currentExecutionData = $lastExecutionData;


// Iterate over member accounts
foreach($arrayMemberAccount as $memberAccount) {
    $memberID = $memberAccount['memberID'];
    $memberControlNumber = $memberAccount['membershipID'];
    $memberValidity = $memberAccount['validityDate'];
    $validity = "Expired";
    $date = DateTime::createFromFormat('Y-m-d', $memberValidity);
    $sqlDate = $date->format('Y-m-d');
    $validityDate = convertToNormalDate($sqlDate);
    $dateDifference = dateDifference($sqlDate, $currentDate); // function for date difference
    $customerEmail = $memberAccount['customerEmail'];
    $memberAccountStatus = $memberAccount['validity'];

    // Check if memberID + current date is not in last execution data
    $memberDateKey = $memberID . '_' . $currentDate;
    
    if (!in_array($memberDateKey, $lastExecutionData)) {
        // Notify if membership will expire in 5 days
        if ($dateDifference === 5 && $memberAccountStatus === 'Valid') {
            include 'src/send_email/send_advance_expiration_notification.php';

            
            // Record memberID + current date in current execution data
            $currentExecutionData[] = $memberDateKey;
        } 
        
        elseif ($sqlDate < $currentDate && $memberAccountStatus === 'Valid') {
            // Update membership validity if expired
            $qryDeleteMembershipAccount = "UPDATE member_details SET validity = ? WHERE memberID = ?";
            $prepareDeleteMembershipAccount = mysqli_prepare($conn, $qryDeleteMembershipAccount);
            
            if ($prepareDeleteMembershipAccount) {
                mysqli_stmt_bind_param($prepareDeleteMembershipAccount, "si", $validity, $memberID);
                mysqli_stmt_execute($prepareDeleteMembershipAccount);

                // Notify member of expiration
                include 'src/send_email/send_expiration_notification.php';
                // Record memberID + current date in current execution data
                $currentExecutionData[] = $memberDateKey;
            } 
            
            else {
                // Handle query preparation error
                error_log("Failed to prepare query: " . mysqli_error($conn));
            }
        }

        
    }
}

// Update last execution data in file only if there are new entries
if (!empty($currentExecutionData)) {
    file_put_contents($lastExecutionFile, json_encode($currentExecutionData));
}
?>
