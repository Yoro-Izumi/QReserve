<?php
// Start the session to manage session variables
session_start();

// Set the default timezone to 'Asia/Manila'
date_default_timezone_set('Asia/Manila');

// Include the necessary files for database connection and data fetching
include "connect_database.php";
include "src/get_data_from_database/get_member_account.php";
include "encodeDecode.php";

// Define a key for encoding and decoding
$key = "TheGreatestNumberIs73";

// Check if 'pin' and 'password' are posted
if (isset($_POST['pinInput']) && isset($_POST['new-password'])) {
  $pinInput = $_POST['pinInput'];
  $password = $_POST['new-password'];

  // Calculate the elapsed time since the PIN was set
  $elapsed_time = time() - $_SESSION['pin_time'];

  // Check if the PIN has expired (5 minutes)
  if ($elapsed_time > 300) {
    // Unset the session variables for PIN
    unset($_SESSION['pin']);
    unset($_SESSION['pin_time']);
    
    // Return a JSON response indicating the PIN has expired
    echo json_encode(['status' => 'error', 'message' => 'PIN has expired.']);
    exit();
  } elseif ($pinInput !== $_SESSION['pin']) {
    // Check if the input PIN matches the session PIN
    echo json_encode(['status' => 'error', 'message' => 'Invalid PIN.']);
    exit();
  } else {
    $emailFound = false;

    // Check the email in super admin accounts
    foreach ($arrayMemberAccount as $member) {
      if (decryptData($member['customerEmail'], $key) === $_SESSION['emailPassword']) {
        $memberID = $member['memberID'];

        // Hash the password using Argon2
        $options = [
          'memory_cost' => 1 << 17, // 128MB memory cost (default)
          'time_cost' => 4,         // 4 iterations (default)
          'threads' => 3,           // Use 3 threads for processing (default)
        ];
        $hashedPassword = password_hash($password, PASSWORD_ARGON2I, $options);

        // Prepare the SQL query to update the password
        $qryUpdatePassword = "UPDATE member_details SET membershipPassword = ? WHERE memberID = ?";
        $connUpdatePassword = mysqli_prepare($conn, $qryUpdatePassword);
        mysqli_stmt_bind_param($connUpdatePassword, "si", $hashedPassword, $memberID);
        mysqli_stmt_execute($connUpdatePassword);

        // Return a JSON response indicating the password was updated
        echo json_encode(['status' => 'success', 'message' => 'Password Updated!']);
        $emailFound = true;
        exit();
      }
    }

    // If the email was not found in the super admin accounts, return an error message
    if (!$emailFound) {
      echo json_encode(['status' => 'error', 'message' => 'Email does not exist. Please try again.']);
    }
  }

  // Unset the session variables for PIN and email
  unset($_SESSION['pin']);
  unset($_SESSION['pin_time']);
  unset($_SESSION['emailPassword']);
}
?>
