<?php
session_start();
include 'connect_database.php';
include 'src/get_data_from_database/get_admin_accounts.php';
include 'src/get_data_from_database/get_admin_info.php';
include 'src/get_data_from_database/get_reservation_info.php';
include 'encodeDecode.php';
$key = 'TheGreatestNumberIs73';
date_default_timezone_set('Asia/Manila');

//if (isset($_SESSION["userSuperAdminID"])) {
    // Generate random data for graphs
    // Ensure that this part matches the provided Python-generated data

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="path/to/your/main.css">
</head>
<body>
    <header>
        <h1>Main Page Header</h1>
    </header>
    <main>
        <?php include 'generate_content.php'; ?>
    </main>
    <footer>
        <p>Footer Content</p>
    </footer>
</body>
</html>
