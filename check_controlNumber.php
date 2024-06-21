<?php
include "connect_database.php";
include "encodeDecode.php";

$key = "TheGreatestNumberIs73";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberControlNumber = isset($_POST['membershipID']) ? $_POST['membershipID'] : '';

    // Decrypt the control number
    $decryptedControlNumber = decryptData($memberControlNumber, $key);

    // Check if the decrypted control number already exists in the database
    $query = "SELECT * FROM member_details WHERE membershipID = '$decryptedControlNumber'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "<span style='color: red;'>Control Number already exists! Please choose another ID.</span>";
    } else {
        echo "<span style='color: green;'>Control Number is available.</span>";
    }
} else {
    echo "Invalid request!";
}
?>
