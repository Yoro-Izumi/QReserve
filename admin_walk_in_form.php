<?php
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION["userSuperAdminID"]) || isset($_SESSION["userAdminID"])) { // Check for admin session too
  $visitors = 0;

  $today = date('Y-m-d');
  include "connect_database.php";
  include "encodeDecode.php";
  $key = "TheGreatestNumberIs73";
  include "src/get_data_from_database/get_admin_accounts.php";
  $adminSessionID = $_SESSION['userAdminID'];
  $adminUsername = " ";
  foreach ($arrayAdminAccount as $admin) {
    if ($admin['adminID'] === $adminSessionID) {
      $adminUsername = decryptData($admin['adminUsername'], $key);
    }
  }
?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

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

    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

    <!-- External CSS -->
    <link rel="stylesheet" href="src/css/sidebar.css" />
    <link rel="stylesheet" href="src/css/style.css" />
  </head>

  <body class="body">
    <?php include "admin_sidebar.php"; ?>
    <section class="home-section">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 text-center">
            <h1 class="qreserve mb-0">QReserve</h1>
            <h6 id="booking-sub">BEVITORE SANTA ROSA</h6>
            <hr class="my-4">
          </div>
        </div>

        <div class="row">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="fw-bold ps-4">Fill up the form</h3>
            <div class="fw-bold pe-4">
              <input type="radio" class="btn-check" name="price-option" id="walkin-button" data-price="0" autocomplete="off" checked>
              <label class="btn btn-outline-success walkin-button" for="walkin-button">Walk-In</label>

              <input type="radio" class="btn-check" name="price-option" id="member-button" data-price="-50" autocomplete="off">
              <label class="btn btn-outline-danger" for="member-button">Member</label>
            </div>
          </div>
          <div class="col-md-12">
            <form class="row dashboard-square-kebab needs-validation" id="booking-form" novalidate>
              <div class="col-md-4 mb-3">
                <label for="firstName" class="form-label">First Name <span>*</span></label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name here" required onblur="handleInput(event)" oninput="validateName(event)" maxlength="50" minlength="3">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Please provide a valid first name.
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label for="middleName" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Enter middle name here" onblur="handleInput(event)" oninput="validateName(event)" maxlength="50">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Please provide a valid middle name.
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label for="lastName" class="form-label">Last Name <span>*</span></label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name here" required onblur="handleInput(event)" oninput="validateName(event)" maxlength="50">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Please provide a valid last name.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="birthDate" class="form-label">Birthdate <span>*</span></label>
                <input type="date" class="form-control" id="birthDate" name="birthDate" required max="2100-12-31">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Please provide a valid birthdate.
                </div>
              </div>

              <div class="col-md-4 mb-3">
                <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
                <input type="text" class="form-control" id="contactNumber" placeholder="Enter contact number here" name="contactNumber" required minlength="11" maxlength="11" oninput="validateContactNumber(event)">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Please provide a valid contact number.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="email" class="form-label">Email Address <span>*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address here" required oninput="validateEmail(event)" maxlength="50">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div id="emailError" class="invalid-feedback">
                  Please provide a valid email address.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="selectDate" class="form-label">Select Date <span>*</span></label>
                <input type="date" class="form-control" name="selectDate" id="selectDate" placeholder="Enter membership validity here" required readonly value="<?php echo date('Y-m-d'); ?>" />
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Please provide a valid date.
                </div>
              </div>

              <div class="col-md-3 mb-3">
                <label for="selectStartTime" class="form-label">Start Time <span>*</span></label>
                <input type="time" class="form-control" id="selectStartTime" name="selectStartTime" required min="10:00" oninput="adjustEndTime()">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Start time must be after 10:00 AM.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="selectEndTime" class="form-label">End Time <span>*</span></label>
                <input type="time" class="form-control" id="selectEndTime" name="selectEndTime" required oninput="validateEndTime()">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback" id="endTimeFeedback">
                  Please provide a valid end time.
                </div>
              </div>

              <div class="col-md-3 mb-3">
                <label for="selectTable" class="form-label">Select Table <span>*</span></label>
                <select class="form-control" name="selectTable" id="selectTable" required>
                  <option value="">Select table</option>
                  <!-- Options will be dynamically added based on selected start time -->
                </select>
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Please provide a valid table.
                </div>
              </div>
              <div class="col-12 col-md-12 mb-3 mb-4">
                <h6 class="mb-0 pb-0">Bevitore 2D Map</h6>
                <img src="src/images/map.png" alt="" style="width: 100%; height: 100%;">
              </div>
              <input type="hidden" id="getTotalPriceHour" name="getTotalPriceHour">
              <div class="row justify-content-end mt-5">
                <div class="col-12 col-md-2 mb-3 mb-md-0">
                  <button class="btn btn-primary w-100 create-button" type="submit" id="create-walkin-button">Create</button>
                </div>
                <div class="col-12 col-md-2 mb-3 mb-md-0">
                  <button class="btn btn-outline-primary w-100 cancel-button" type="button" onclick="handleCancel()">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>


    <!-- Add this div at the end of your HTML body to contain the modal -->
    <div class="modal fade" id="confirmAddWalkin" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" id="add-new-service-modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title fw-bold text-center" id="wait"><img src="src/images/icons/hourglass.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
            <h6 class="mt-2 mb-0 pb-0">Here's what we received:</h6>
          </div>
          <div class="modal-body">
            <!-- The content will be dynamically generated here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Edit</button>
            <button type="button" class="btn btn-primary create-button" data-bs-toggle="modal" data-bs-target="#success-add-walkin-modal" id="success-reservation-button">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Add New Walkin Modal -->
    <div class="modal fade" id="success-add-walkin-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="success"><img src="src/images/icons/available-worldwide.gif" alt="Wait Icon" class="modal-icons">Success!</h2>
          </div>
          <div class="modal-body text-center">
            Kindly wait for your turn to play!
          </div>
          <div class="modal-footer">
            <!-- <button class="btn btn-primary create-button" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button> -->
            <button class="btn btn-primary  create-button" name="submitWalkin" id="submitWalkin" type="submit">Proceed</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="unsavedChangesModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="cancelModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" id="">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title fw-bold text-center" id="wait"><img src="src/images/icons/alert.gif" alt="Wait Icon" class="modal-icons">Leaving Page?</h2>
          </div>
          <div class="modal-body">
            <p class="text-center">Looks like you’re in the middle of writing something. Changes that you’ve made will not be saved.</p>
            <p class="mt-3 mb-0 text-center fw-bold">Are you sure you want to leave this page?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary create-button" data-bs-toggle="modal" id="proceedButton">Proceed</button>
          </div>
        </div>
      </div>
    </div>

    </div>

    <div id="updateTable" style="display:none;"><!--this div's only purpose is to help table update--></div>
    <script src="src/js/sidebar.js"></script>
    <script src="src/js/admin_walk_in_form.js"></script>

  </body>

  </html>
<?php } else {
  header("location:login.php");
  die();
} ?>