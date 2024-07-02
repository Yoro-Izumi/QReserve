<?php
session_start();
date_default_timezone_set('Asia/Manila');
include "connect_database.php";
include "src/get_data_from_database/get_admin_accounts.php";
include "src/get_data_from_database/get_super_admin_accounts.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";

if (isset($_POST['pinInput']) && isset($_POST['new-password'])) {
    $pinInput = $_POST['pinInput'];
    $password = $_POST['new-password'];
    $elapsed_time = time() - $_SESSION['pin_time'];

    if ($elapsed_time > 300) { // 5 minutes
        unset($_SESSION['pin']);
        unset($_SESSION['pin_time']);
        echo json_encode(['status' => 'error', 'message' => 'PIN has expired.']);
        exit();
    } elseif ($pinInput !== $_SESSION['pin']) { // Check if the input PIN matches the stored PIN
        echo json_encode(['status' => 'error', 'message' => 'Invalid PIN.']);
        exit();
    } else {
        $emailFound = false;

        
        // Check in super admin accounts
        foreach ($arraySuperAdminAccount as $superAdmin) {
            if (decryptData($superAdmin['superAdminEmail'], $key) === $_SESSION['emailPassword']) {
                $superAdminID = $superAdmin['superAdminID'];

                // Hash the password using Argon2
                $options = [
                    'memory_cost' => 1 << 17, // 128MB memory cost (default)
                    'time_cost' => 4,         // 4 iterations (default)
                    'threads' => 3,           // Use 3 threads for processing (default)
                ];
                $hashedPassword = password_hash($password, PASSWORD_ARGON2I, $options);

                $qryUpdatePassword = "UPDATE super_admin SET superAdminPassword = ? WHERE superAdminID = ?";
                $connUpdatePassword = mysqli_prepare($conn, $qryUpdatePassword);
                mysqli_stmt_bind_param($connUpdatePassword, "si", $hashedPassword, $superAdminID);
                mysqli_stmt_execute($connUpdatePassword);

                echo json_encode(['status' => 'success', 'message' => 'Password Updated!']);
                $emailFound = true;
                exit();
            }
        }

        // Check in admin accounts if not found in super admin accounts
        if (!$emailFound) {
            foreach ($arrayAdminAccount as $admin) {
                if (decryptData($admin['adminEmail'], $key) === $_SESSION['emailPassword']) {
                    $adminID = $admin['adminID'];

                    // Hash the password using Argon2
                    $options = [
                        'memory_cost' => 1 << 17, // 128MB memory cost (default)
                        'time_cost' => 4,         // 4 iterations (default)
                        'threads' => 3,           // Use 3 threads for processing (default)
                    ];
                    $hashedPassword = password_hash($password, PASSWORD_ARGON2I, $options);

                    $qryUpdatePassword = "UPDATE admin_accounts SET adminPassword = ? WHERE adminID = ?";
                    $connUpdatePassword = mysqli_prepare($conn, $qryUpdatePassword);
                    mysqli_stmt_bind_param($connUpdatePassword, "si", $hashedPassword, $adminID);
                    mysqli_stmt_execute($connUpdatePassword);

                    echo json_encode(['status' => 'success', 'message' => 'Password Updated!']);
                    $emailFound = true;
                    exit();
                }
            }
        }

        if (!$emailFound) {
            echo json_encode(['status' => 'error', 'message' => 'Email does not exist. Please try again.']);
        }
    }

    unset($_SESSION['pin']);
    unset($_SESSION['pin_time']);
    unset($_SESSION['emailPassword']);
}
?>
