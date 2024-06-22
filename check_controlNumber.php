<?php
include "connect_database.php";
include "encodeDecode.php";
include "src/get_data_from_database/get_member_account.php";

$key = "TheGreatestNumberIs73";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controlNumber = isset($_POST['controlNumber']) ? $_POST['controlNumber'] : '';
    
    // Assuming $arrayMemberAccount contains your membership data
    foreach ($arrayMemberAccount as $memberAccount) {
        $membershipID = decryptData($memberAccount['membershipID'], $key);

        // Compare $controlNumber with $membershipID
        if ($controlNumber === $membershipID) {
            // Display a warning message if they match
            echo "<span style='color: red;'>Taken!</span>";
        } else {
            // Display a success message if they don't match
            echo "<span style='color: green;'>Available</span>";
        }
    }
} else {
    echo "Invalid request!";
}
?>

