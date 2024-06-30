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
        <?php include "customer_header.php";
        ?>

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
                    <div class="row">
                        <div class="col-6">
                            <h3 class="fw-bold">Bevitore Data Privacy Policy</h3>
                        </div>
                        <div class="col-6 tanga">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="customer_account.php">My Account</a></li>
                                    <!-- <li class="breadcrumb-item"><a href="data_privacy.php">Data Privacy</a></li> -->
                                </ol>
                            </nav>
                        </div>
                        <div class="col-12">
                            <p class="mt-3">At Bevitore, we value your privacy and are committed to protecting your personal data. This Data Privacy Policy outlines how we collect, use, share, and protect your information when you use our services.</p>
                            <h6 class="fw-bold mt-4 mb-0">Information Collection</h6>
                            <p class="mt-0 mb-0">We collect various types of information, including:</p>
                            <p class="mt-3 mb-0">Personal Information:</p>
                            <ul class="mt-0 mb-0">
                                <li>Name</li>
                                <li>Email Address</li>
                                <li>Phone Number</li>
                                <li>Mailing Address</li>
                                <li>Date of Birth</li>
                                <li>Payment Information</li>
                            </ul>
                            <h6 class="fw-bold mt-3 mb-0">We collect this information through:</h6>
                            <ul class="mt-0 mb-0">
                                <li>Forms you fill out on our website or mobile app.</li>
                                <li>Interactions with our customer service team.</li>
                            </ul>
                            <h5 class="fw-bold mt-5 mb-0">Use of Information</h5>
                            <h6 class="fw-bold mt-0 mb-0">We use the information we collect to:</h6>
                            <ul class="mt-0 mb-0">
                                <li>Provide and improve our services.</li>
                                <li>Process your reservation and manage your account.</li>
                                <li>Communicate with you about your orders, account, or transactions.</li>
                                <li>Send you promotional materials and offers, with your consent.</li>
                                <li>Customize your experience with Bevitore.</li>
                            </ul>
                            <h5 class="fw-bold mt-5 mb-0">Data Sharing and Disclosure</h5>
                            <h6 class="fw-bold mt-0 mb-0">We do not sell your personal information. We may share your data with:</h6>
                            <ul class="mt-0 mb-0">
                                <li>Legal Requirements: Authorities if required by law or in response to legal processes, such as a court order or subpoena.</li>
                            </ul>
                            <h5 class="fw-bold mt-5 mb-0">Data Security</h5>
                            <h6 class="fw-bold mt-0 mb-0">We implement various security measures to ensure the protection of your personal data, including:</h6>
                            <ul class="mt-2 mb-0">
                            <li>Encryption of sensitive information.</li>
                                <li>Access controls to restrict unauthorized access.</li>
                                <li>Regular security assessments.</li>
                                <li>Send you promotional materials and offers, with your consent.</li>
                                <li>Customize your experience with Bevitore.</li>
                            </ul>
                            <h6 class="mt-2 mb-0"><i>**Despite these measures, please be aware that no method of transmission over the internet or electronic storage is completely secure.**</i></h6>
                            <h5 class="fw-bold mt-5 mb-0">User Rights</h5>
                            <h6 class="fw-bold mt-0 mb-0">You have the following rights regarding your personal data:</h6>
                            <ul class="mt-2 mb-0">
                            <li>Access: Request access to the personal data we hold about you.</li>
                                <li>Correction: Request corrections to any inaccurate or incomplete data.</li>
                                <li>Deletion: Request the deletion of your personal data.</li>
                                <li>Objection: Object to the processing of your data for certain purposes.</li>
                                <li>Withdrawal of Consent: Withdraw your consent for data processing at any time.Withdrawal of Consent: Withdraw your consent for data processing at any time.</li>
                            </ul>
                            <h5 class="fw-bold mt-5 mb-0"> If you have any questions or concerns about this policy, please contact us at:</h4>
                            <ul class="mt-2 mb-0">
                            <li><b>Facebook:</b> <a href="https://www.facebook.com/Bevitore.Sta.Rosa">Bevitore Santa Rosa</a></li>
                                <li><b>Email:</b> bevitore.inquiries2022@gmail.com</li>
                                <li><b>Address:</b> 2nd Floor Victory Central Mall Sta Rosa, Balibago Complex,Sta Rosa City, Laguna, Santa Rosa</li>
                            </ul>
                        </div>

                    </div>

                </div>

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