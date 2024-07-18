<?php
session_start();
if (isset($_SESSION["userSuperAdminID"]) || isset($_SESSION["userAdminID"])) { // Check for admin session too
  $visitors = 0;
  date_default_timezone_set('Asia/Manila');
  include "connect_database.php";
  include "src/get_data_from_database/get_pool_table_info.php";
  include "src/get_data_from_database/get_reservation_info.php";
  include "src/get_data_from_database/get_walk_in.php";
  include "src/get_data_from_database/get_customer_information.php";
  include "src/get_data_from_database/get_member_account.php";
  include "src/get_data_from_database/convert_to_normal_time.php";
  include "encodeDecode.php";
  $key = "TheGreatestNumberIs73";
  $currentDate = date("Y-m-d");

  $customerName = $email = $contactNumber = " ";
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
  <?php include "admin_sidebar.php"; ?>

  <script>
  $(document).ready(function() {
    var table = $('#example').DataTable();
    var searchContainer = table.table().container().querySelector('.dataTables_filter');

    // Move the DataTables search input into the custom container
    document.getElementById('datatableSearchContainer').appendChild(searchContainer);
  });

  // Custom filter function for status
  $('#statusFilter').on('change', function() {
    var selectedStatus = $(this).val();
    $('#example').DataTable().column(8).search(selectedStatus).draw();
  });
</script>

<style>
  .form-group label {
    display: inline-block;
    margin-right: 10px;
  }

  #statusFilter {
    display: inline-block;
    width: auto;
  }

  .dataTables_filter {
    margin-bottom: 0;
    display: flex;
    align-items: center;
  }
</style>

<section class="home-section">
  <h4 class="qreserve">Reservations</h4>
  <hr class="my-4 mb-3 mt-3">
  <div class="container-fluid dashboard-square-kebab">
    <form>
      <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center">
          <div class="form-group mb-0 d-flex align-items-center">
            <label for="statusFilter" class="mb-0 me-2">Filter by Status:</label>
            <select class="form-control" id="statusFilter">
              <option value="">All</option>
              <option value="Reserved">Reserved</option>
              <option value="On Process">On Process</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div>
          <div id="datatableSearchContainer"></div>
        </div>
      </div>
      <table id="example" class="table table-striped" style="width: 100%">
        <thead>
            <tr>
              <th>Reservation Code</th>
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
            <?php
            foreach ($arrayReservationInfo as $reservations) {
              $reservationID = $reservations['reservationID'] ?? '';
              $reservationDate = $reservations['reservationDate'] ?? '';
              $reservationStatus = $reservations['reservationStatus'] ?? '';
              $reservationTimeStart = convertToNormalTime($reservations['reservationTimeStart']) ?? '';
              $reservationTimeEnd = convertToNormalTime($reservations['reservationTimeEnd']) ?? '';
              $tableNumber = $reservations['poolTableNumber'] ?? '';
              $reservationCode = '';

              if ($reservationDate >= $currentDate) {
                $getQRCodeQuery = "SELECT codeQR FROM qr_code where reservationID = ?";
                $getQRCodePrepare = mysqli_prepare($conn, $getQRCodeQuery);
                mysqli_stmt_bind_param($getQRCodePrepare, "i", $reservationID);
                mysqli_stmt_execute($getQRCodePrepare);
                $getQRCodeResult = mysqli_stmt_get_result($getQRCodePrepare);
                $getQRCodeRow = mysqli_fetch_assoc($getQRCodeResult);
                $reservationCode = $getQRCodeRow['codeQR'] ?? '';

                foreach ($arrayMemberAccount as $members) {
                  if ($members['memberID'] == $reservations['memberID']) {
                    $customerName = decryptData($members['customerFirstName'], $key) . " " . decryptData($members['customerMiddleName'], $key) . " " . decryptData($members['customerLastName'], $key);
                    $contactNumber = decryptData($members['customerNumber'], $key) ?? '';
                    $email = decryptData($members['customerEmail'], $key) ?? '';
                  }
                }

                echo "<tr>";
                if ($reservationStatus == "Paid" || $reservationStatus == "Done" || $reservationStatus == "Reserved") {
                  $status = "badge bg-success";
                } else if ($reservationStatus == "On Process") {
                  $status = "badge bg-warning";
                } else {
                  $status = "badge bg-danger";
                }
                echo "
                  <td>$reservationCode</td>
                  <td>$customerName</td>
                  <td>".convertToNormalDate($reservationDate)."</td>
                  <td>$reservationTimeStart - $reservationTimeEnd</td>
                  <td>$tableNumber</td>
                  <td>$contactNumber</td>
                  <td>$email</td>
                  <td><span class='$status'>$reservationStatus</span></td>
                </tr>";
              } else {
                // Additional code for else case, if needed
              }
            }

            foreach ($arrayWalkinDetails as $walkin) {
              $walkinDate = $walkin['walkinDate'] ?? '';
              $walkinStatus = $walkin['walkinStatus'] ?? '';
              $walkinTimeStart = convertToNormalTime($walkin['walkinTimeStart']) ?? '';
              $walkinTimeEnd = convertToNormalTime($walkin['walkinTimeEnd']) ?? '';
              $tableNumber = $walkin['poolTableNumber'] ?? '';

              if ($walkinDate >= $currentDate) {
                $customerName = decryptData($walkin['customerFirstName'], $key) . " " . decryptData($walkin['customerMiddleName'], $key) . " " . decryptData($walkin['customerLastName'], $key);
                $contactNumber = decryptData($walkin['customerNumber'], $key) ?? '';
                $email = decryptData($walkin['customerEmail'], $key) ?? '';

                echo "<tr>
                  <td>Walk-in</td>
                  <td>$customerName</td>
                  <td>".convertToNormalDate($walkinDate)."</td>
                  <td>$walkinTimeStart - $walkinTimeEnd</td>
                  <td>$tableNumber</td>
                  <td>$contactNumber</td>
                  <td>$email</td>";
                if ($walkinStatus == "Paid" || $walkinStatus == "Done" || $walkinStatus == "Reserved") {
                  $status = "badge bg-success";
                } else if ($walkinStatus == "Waiting" || $walkinStatus == "Pending") {
                  $status = "badge bg-warning";
                } else {
                  $status = "badge bg-danger";
                }
                echo "<td><span class='$status'>$walkinStatus</span></td>
                </tr>";
              } else {
                // Additional code for else case, if needed
              }
            }
            ?>
          </tbody>
        </table></form>
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
            <button type="button" id="confirm-accept-reservation" class="btn btn-primary create-button" data-bs-target="#success-accept-modal" data-bs-toggle="modal">Confirm</button>
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
            <button class="btn btn-primary create-button" onclick="reload()" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
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
            <button type="button" id="confirm-reject-reservation" class="btn btn-primary create-button" data-bs-target="#success-reject-modal" data-bs-toggle="modal">Confirm</button>
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
            <button class="btn btn-primary create-button" onclick="reload()" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>


    <input type="text" id="qrInput" autofocus>
      <div id="result" type='hidden'></div>

    <!-- Modal for showing the reservation details on qr scan-->
    <div class="modal fade" id="reservation_details" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="wait">
                <div class="modal-header">
                    <h2 class="modal-title fw-bold text-center" id="success">
                        <img src="src/images/icons/available-worldwide.gif" alt="Wait Icon" class="modal-icons">Reservation Details
                    </h2>
                </div>
                <div class="modal-body text-center" id="modal-body-content">
                    (Details Here)
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary create-button" id="submitReserve" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Invalid QR Code -->
    <div class="modal fade" id="invalid_qr_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="invalid_qr_modal_label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title fw-bold text-center" id="invalid_qr_modal_label">Invalid QR Code
            </h2>
          </div>
          <div class="modal-body text-center" id="modal-body-content">
            The scanned QR code is invalid or does not exist.
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary create-button" id="closeInvalidQRModal" type="button" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>



    <style>
      /* Hide div result */
      #result {
        position: absolute;
        left: -9999px;
        display:none;
      }
    </style>
    <style>
      /* Hide the QR input field */
      #qrInput {
        position: absolute;
        left: -9999px;
      }
    </style>

<script src="src/js/sidebar.js"></script>
<script src="src/js/reservations_viewing.js"></script>

    <script>
        function removeInputField() {
            var userAgent = navigator.userAgent || navigator.vendor || window.opera;

            // Check for iOS devices
            var isIOS = /iPad|iPhone|iPod/.test(userAgent) && !window.MSStream;

            // Check for other mobile devices
            var isMobile = /Android|webOS|BlackBerry|IEMobile|Opera Mini/.test(userAgent) || isIOS;

            if (isMobile) {
                var inputField = document.getElementById('qrInput');
                if (inputField) {
                    inputField.parentNode.removeChild(inputField);
                }
            }
            if (isIOS) {
                var inputField = document.getElementById('qrInput');
                if (inputField) {
                    inputField.parentNode.removeChild(inputField);
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            removeInputField();
        });
    </script>

  </body>

  </html>
<?php } else {
  header("location:login.php");
} ?>