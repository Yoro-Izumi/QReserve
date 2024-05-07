<?php
session_start();
date_default_timezone_set('Asia/Manila');

if (isset($_SESSION["userSuperAdminID"])) {
  include "connect_database.php";
  include "src/get_data_from_database/get_reservation_info.php";
  include "src/get_data_from_database/get_member_account.php";
  include "encodeDecode.php";
  $key = "TheGreatestNumberIs73";

?>
  <!DOCTYPE html>
  <!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <title>Reservations</title>
    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Online Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Datatables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- External CSS -->
    <link rel="stylesheet" href="src/css/sidebar.css" />
    <link rel="stylesheet" href="src/css/style.css" />

    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
  </head>

  <body class="body">
    <?php include "superadmin_sidebar.php"; ?>

    <section class="home-section">
      <h4 class="qreserve">Reservations</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab">
        <table id="example" class="table table-striped" style="width: 100%">
          <thead>
            <tr>
              <th>Actions</th>
              <th>Name</th>
              <th>Date of Reservation</th>
              <th>Time of Reservation</th>
              <th>Pool Table</th>
              <th>Contact Number</th>
              <th>Email Address</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($arrayReservationInfo as $reservations) {
              $reservationDate = $reservations['reservationDate'];
              $reservationStatus = $reservations['reservationStatus'];
              $reservationTimeStart = $reservations['reservationTimeStart'];
              $reservationTimeEnd = $reservations['reservationTimeEnd'];
              $tableNumber = $reservations['poolTableNumber'];
              foreach ($arrayMemberAccount as $members) {
                if ($members['memberID'] == $reservations['memberID']) {
                  $customerName = decryptData($members['customerFirstName'], $key) . " " . decryptData($members['customerMiddleName'], $key) . " " . decryptData($members['customerLastName'], $key);
                  $contactNumber = decryptData($members['customerNumber'], $key);
                  $email = decryptData($members['customerEmail'], $key);
                } else {
                  $customerName = "";
                  $contactNumber = "";
                  $email = "";
                }
              }
            ?>
              <tr>
                <td><input type="checkbox" value="<?php echo $reservations['reservationID']; ?>"></td>
                <td><?php echo $customerName; ?></td>
                <td><?php echo $reservationDate; ?></td>
                <td><?php echo $reservationTimeStart; ?> - <?php echo $reservationTimeEnd; ?></td>
                <td><?php echo $tableNumber; ?></td>
                <td><?php echo $contactNumber; ?></td>
                <td><?php echo $email; ?></td>
                <?php
                if ($reservationStatus == "Paid" || $reservationStatus == "Done") {
                  $status = "badge bg-success";
                } else if ($reservationStatus == "On Process" || $reservationStatus == "Pending") {
                  $status = "badge bg-warning";
                } else {
                  $status = "badge bg-danger";
                }
                ?>
                <td><span class="<?php echo $status; ?>"><?php echo $reservationStatus; ?></span></td>

              </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="mt-3">
          <!-- <button type="button" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button> -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accept-modal" id="accept-service">Accept Selected</button>
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reject-modal" id="reject-service">Reject Selected</button>
          <!-- <button type="button" class="btn btn-primary" onclick="editSelected()">Edit Selected</button> -->
        </div>
      </div>
    </section>


    <!-- Modals -->
    <!-- Accept Reservation Modals -->
    <div class="modal fade" id="accept-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="warning"><img src="src/images/icons/alert.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
          </div>
          <div class="modal-body">
            Are you sure you want to accept this reservation?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary create-button" data-bs-target="#success-accept-modal" data-bs-toggle="modal">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Accept Reservation Modals -->
    <div class="modal fade" id="success-accept-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="success"><img src="src/images/icons/available-worldwide.gif" alt="Success Icon" class="modal-icons">Sucess!</h2>
          </div>
          <div class="modal-body">
            You have successfully accepted this reservation.
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary create-button" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Reject Reservation Modals -->
    <div class="modal fade" id="reject-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="warning"><img src="src/images/icons/alert.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
          </div>
          <div class="modal-body">
            Are you sure you want to reject this reservation?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary create-button" data-bs-target="#success-reject-modal" data-bs-toggle="modal">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Reject Reservation Modals -->
    <div class="modal fade" id="success-reject-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="deleted"><img src="src/images/icons/cancel.gif" alt="Wait Icon" class="modal-icons">Rejected!</h2>
          </div>
          <div class="modal-body">
            You have successfully rejected this reservation.
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary create-button" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>













    <script>
      $(document).ready(function() {
        $("#example").DataTable({
          paging: true,
          lengthChange: true,
          searching: true,
          ordering: true,
          info: true,
          autoWidth: false,
          responsive: true,
        });
      });

      let sidebar = document.querySelector(".sidebar");
      let closeBtn = document.querySelector("#btn");
      let searchBtn = document.querySelector(".bx-search");

      closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");
        menuBtnChange(); //calling the function(optional)
      });

      searchBtn.addEventListener("click", () => {
        // Sidebar open when you click on the search icon
        sidebar.classList.toggle("open");
        menuBtnChange(); //calling the function(optional)
      });

      // following are the code to change sidebar button(optional)
      function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
          closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the icons class
        } else {
          closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the icons class
        }
      }
    </script>
  </body>

  </html>
<?php } else {
  header("location:login.php");
} ?>