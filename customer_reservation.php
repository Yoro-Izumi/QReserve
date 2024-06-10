<?php
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION["userMemberID"])) {
    $userID = $_SESSION['userMemberID'];
    include "connect_database.php";
    include "src/get_data_from_database/get_member_account.php";
    include "src/get_data_from_database/get_customer_information.php";
    include "src/get_data_from_database/get_reservation_info.php";
    include "src/get_data_from_database/get_member_account.php";
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
                <div class="col-md-12 mt-5 pt-3">
                    <h4 class="qreserve">Reservations</h4>
                    <hr class="my-4 mt-3">
                    <div class="dashboard-square-kebab" id="customer-reservation-form" novalidate action="submit_customer_reservation.php" method="POST" enctype="multipart/form-data">
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

                            foreach ($arrayReservationInfo as $reservations) {
                                $reservationDate = $reservations['reservationDate'];
                                $reservationStatus = $reservations['reservationStatus'];
                                $reservationTimeStart = $reservations['reservationTimeStart'];
                                $reservationTimeEnd = $reservations['reservationTimeEnd'];
                                $tableNumber = $reservations['poolTableNumber'];
                              
                                // minove ko lang to ayaw kasi lumabas sa table
                                foreach ($arrayMemberAccount as $members) {
                                  if ($members['memberID'] == $reservations['memberID']) {
                                    $customerName = decryptData($members['customerFirstName'], $key) . " " . decryptData($members['customerMiddleName'], $key) . " " . decryptData($members['customerLastName'], $key);
                                    $contactNumber = decryptData($members['customerNumber'], $key);
                                    $email = decryptData($members['customerEmail'], $key);
                                  } 
                                  // else {
                                  //   $customerName = "";
                                  //   $contactNumber = "";
                                  //   $email = "";
                                  // }
                                }
                            }

                            ?>
<div class="name-status-container">
    <h2 class="fw-bold">
        <?php echo $customerFirstName; ?> <?php echo $customerMiddleName; ?> <?php echo $customerLastName; ?>
    </h2>
    <div class="status-box">
        <span class="status-text">Done</span>
    </div>
</div>


                            <div class="col-12">
                                <h5 class="customer-reservation pt-2">Reservation Date: <span class="reservation-detail"><?php echo $reservationDate; ?></span></h5>
                            </div>
                            <div class="col-12">
                                <h5 class="customer-reservation">Pool Table: <span class="reservation-detail"><?php echo $tableNumber; ?></span></h5>
                            </div>
                            <div class="col-12">
                                <h5 class="customer-reservation">Time: <span class="reservation-detail"><?php echo $reservationTimeStart; ?> - <?php echo $reservationTimeEnd; ?></span></h5>
                            </div>
                            <div class="col-12 col-md-6 pt-4">
                                <h5 class="date-reserved">Date Reserved: <span class="reservation-detail"><?php echo $customerFirstName; ?></span></h5>
                            </div>
                            <div class="col-12 col-md-6 cancel-reservation-button">
                            <button class="btn btn-outline-primary" id="cancel_reservation_button">Cancel Reservation</button>
                            </div>

                        </div>
                    </div>
                </div>


                <div id="updateTable" style="display:none;"><!--this div's only purpose is to help table update--></div>
    <script>
      $(document).ready(function() {
        // Function to update table content
        function updateTable() {
          $.ajax({
            url: 'pool_table.php',
            type: 'GET',
            success: function(response) {
              $('#updateTable').html(response);
            }
          });
        }

        // Initial table update
        updateTable();

        // Refresh table every 5 seconds
        setInterval(updateTable, 1000); // Adjust interval as needed
      });

    </script> 


    </body>

    </html>
<?php
} else {
    header('location:customer_login.php');
    exit();
}
?>