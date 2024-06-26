<?php
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION["userMemberID"])) {
    $userID = $_SESSION['userMemberID'];
    include "connect_database.php";
    include "src/get_data_from_database/get_member_account.php";
    include "src/get_data_from_database/get_customer_information.php";
    include "encodeDecode.php";
    $key = "TheGreatestNumberIs73";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>Account</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="src/css/style.css">
        <link rel="stylesheet" href="src/css/landing.css">

        <!-- Fontawesome Link for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


        <!-- Montserrat Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

        <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

    </head>

    <body class="body">
        <header>
            <nav class="navbar p-0">
                <img src="src/images/Bevitore-logo.png" id="customer-landing-logo" />
                <input type="checkbox" id="menu-toggler">
                <label for="menu-toggler" id="hamburger-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z" />
                    </svg>
                </label>
                <ul class="all-links">
                <li><a href="customer_dashboard.php">Home</a></li>
          <li><a href="customer_account.php">Reservations</a></li>
          <li><a href="customer_account.php">Account</a></li>
          <li><a href="customer_logout.php">Log Out</a></li>
                </ul>
            </nav>
        </header>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="qreserve mt-5 pt-3 mb-0">QReserve</h1>
                    <h6 id="booking-sub">BEVITORE SANTA ROSA</h6>
                    <hr class="my-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="fw-bold ps-4">My Account</h3>
                    <form class="needs-validation dashboard-square-kebab" id="account-form" novalidate action="submit_customer_reservation.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <?php
                            foreach ($arrayMemberAccount as $memberAccount) {
                                if ($memberAccount["memberID"] == $userID) {
                                    $memberControlNumber = decryptData($memberAccount['membershipID'], $key);
                                    $customerFirstName = decryptData($memberAccount['customerFirstName'], $key);
                                    $customerLastName = decryptData($memberAccount['customerLastName'], $key);
                                    $customerMiddleName = decryptData($memberAccount['customerMiddleName'], $key);
                                    $customerBirthdate = decryptData($memberAccount['customerBirthdate'], $key);
                                    $customerNumber = decryptData($memberAccount['customerNumber'], $key);
                                    $customerEmail = decryptData($memberAccount['customerEmail'], $key);
                                }
                            }
                            ?>
                            <div class="col-12 col-md-12 mb-3 ">
                                <label for="firstName" class="form-label customer-account" >First Name: <h1 class="customer-account-field" id="customer-name"><?php echo $customerFirstName; ?> <?php echo $customerMiddleName; ?> <?php echo $customerLastName; ?></h1></label>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="firstName" class="form-label customer-account">Control Number: <h4 class="customer-account-field" id="customer-name"><?php echo $memberControlNumber; ?></h4></label>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="firstName" class="form-label customer-account">Birthdate: <h4 class="customer-account-field" id="customer-name"><?php echo $customerBirthdate; ?></h4></label>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="firstName" class="form-label customer-account">Contact Number: <h4 class="customer-account-field" id="customer-name"><?php echo $customerNumber; ?></h4></label>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="firstName" class="form-label customer-account">Email Address: <h4 class="customer-account-field" id="customer-name"><?php echo $customerEmail; ?></h4></label>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
    header('location:customer_login.php');
    exit();
}
?>