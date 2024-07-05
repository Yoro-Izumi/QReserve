<?php
session_start();
date_default_timezone_set('Asia/Manila');
include "connect_database.php";
include "src/get_data_from_database/get_member_account.php";
include "encodeDecode.php";

$key = "TheGreatestNumberIs73";

if (isset($_POST['pinInput'], $_POST['new-password'], $_POST['confirm-password'])) {
    $pinInput = trim($_POST['pinInput']);
    $newPassword = trim($_POST['new-password']);
    $confirmPassword = trim($_POST['confirm-password']);
    $sessionPin = isset($_SESSION['pin']) ? trim($_SESSION['pin']) : null;
    $sessionPinTime = isset($_SESSION['pin_time']) ? trim($_SESSION['pin_time']) : null;
    $email = isset($_SESSION['emailPassword']) ? trim($_SESSION['emailPassword']) : null;

    // Validate inputs
    if (!$email || !$sessionPin || !$sessionPinTime) {
        echo json_encode(['status' => 'error', 'message' => 'Session expired or invalid pin(a).']);
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
        exit();
    }

    if ($pinInput !== $sessionPin) {
        echo json_encode(['status' => 'error', 'message' => 'Session expired or invalid pin(b).']);
        exit();
    }

    // Check if the PIN is expired (e.g., valid for 10 minutes)
    if (time() - $sessionPinTime > 600) {
        echo json_encode(['status' => 'error', 'message' => 'Session expired or invalid pin(c).']);
        exit();
    }

    // Argon2 options
    $options = [
        'memory_cost' => 1 << 17, // 128MB memory cost
        'time_cost' => 4,         // 4 iterations
        'threads' => 3            // Use 3 threads for processing
    ];
    
    $hashedPassword = password_hash($newPassword, PASSWORD_ARGON2I, $options);

    $isUpdated = false;

    // Check in the member accounts
    foreach ($arrayMemberAccount as $memberAccount) {
        if (decryptData($memberAccount['customerEmail'], $key) === $email) {
            $memberID = $memberAccount['memberID'];
            $qryUpdateMember = "UPDATE member_details SET membershipPassword = ? WHERE memberID = ?";
            $conUpdateMember = mysqli_prepare($conn, $qryUpdateMember);
            mysqli_stmt_bind_param($conUpdateMember, 'si', $hashedPassword, $memberID);
            if (mysqli_stmt_execute($conUpdateMember)) {
                $isUpdated = true;
                echo json_encode(['status' => 'success']);
                exit();
            } else {
                // Error executing statement
                echo json_encode(['status' => 'error', 'message' => 'Membership account password update failed.']);
                exit();
            }
        }
    }

    // If no update occurred
    if (!$isUpdated) {
        echo json_encode(['status' => 'error', 'message' => 'Account not found or password update failed.']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Session expired or invalid pin(d).']);
}
?>
