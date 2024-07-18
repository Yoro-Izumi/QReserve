<?php
session_start();
date_default_timezone_set('Asia/Manila');
include "connect_database.php";
include "src/get_data_from_database/get_admin_accounts.php";
include "src/get_data_from_database/get_super_admin_accounts.php";
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

    // Check in the super admin accounts
    foreach ($arraySuperAdminAccount as $superAdminAccount) {
        if (decryptData($superAdminAccount['superAdminEmail'], $key) === $email) {
            $superAdminID = $superAdminAccount['superAdminID'];
            $qryUpdateSuperAdmin = "UPDATE super_admin SET superAdminPassword = ? WHERE superAdminID = ?";
            $conUpdateSuperAdmin = mysqli_prepare($conn, $qryUpdateSuperAdmin);
            mysqli_stmt_bind_param($conUpdateSuperAdmin, 'si', $hashedPassword, $superAdminID);
            if (mysqli_stmt_execute($conUpdateSuperAdmin)) {
                $isUpdated = true;
                echo json_encode(['status' => 'success']);
                exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Super admin password update failed.']);
                exit();
            }
        }
    }

    // Check in the admin accounts
    foreach ($arrayAdminAccount as $adminAccount) {
        if (decryptData($adminAccount['adminEmail'], $key) === $email) {
            $adminID = $adminAccount['adminID'];
            $qryUpdateAdmin = "UPDATE admin_accounts SET adminPassword = ? WHERE adminID = ?";
            $conUpdateAdmin = mysqli_prepare($conn, $qryUpdateAdmin);
            mysqli_stmt_bind_param($conUpdateAdmin, 'si', $hashedPassword, $adminID);
            if (mysqli_stmt_execute($conUpdateAdmin)) {
                $isUpdated = true;
                echo json_encode(['status' => 'success']);
                exit();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Admin password update failed.']);
                exit();
            }
        }
    }

    if (!$isUpdated) {
        echo json_encode(['status' => 'error', 'message' => 'Account not found or password update failed.']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Session expired or invalid pin(d).']);
}
?>
