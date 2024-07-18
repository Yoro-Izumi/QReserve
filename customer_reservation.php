<?php
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION['userMemberID'])) {
  $userID = $_SESSION['userMemberID'];
  include "connect_database.php";
  include "src/get_data_from_database/get_member_account.php";
  include "src/get_data_from_database/get_customer_information.php";
  include "encodeDecode.php";
  $key = "TheGreatestNumberIs73";

  foreach ($arrayMemberAccount as $memberAccount) {
    if ($memberAccount["memberID"] == $userID) {
      $memberControlNumber = $memberAccount['membershipID'];
      $membershipValidity = $memberAccount['validityDate'];
      $customerID = $memberAccount['customerID'];
      foreach ($arrayCustomerInformation as $customerInformation) {
        if ($customerInformation["customerID"] == $customerID) {
          $customerFirstName = decryptData($customerInformation['customerFirstName'], $key);
          $customerLastName = decryptData($customerInformation['customerLastName'], $key);
          $customerMiddleName = decryptData($customerInformation['customerMiddleName'], $key);
          $customerBirthdate = decryptData($customerInformation['customerBirthdate'], $key);
          $customerNumber = decryptData($customerInformation['customerNumber'], $key);
          $customerEmail = decryptData($customerInformation['customerEmail'], $key);
        }
      }
    }
  }

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <title>Book a Reservation</title>
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

    <!-- jQuery -->
    <script src="src/js/jquery-3.7.1.js"></script>
    <!-- Datatables JS -->
    <script src="src/js/jquery.dataTables.min.js"></script>
    <script src="src/js/dataTables.bootstrap5.min.js"></script>

    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
  </head>

  <body class="body">
    <?php include "customer_header.php";
    ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-12 text-center">
          <h1 class="qreserve mt-5 mb-0">QReserve</h1>
          <h6 id="booking-sub">BEVITORE SANTA ROSA</h6>
          <hr class="my-4">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h3 class="fw-bold ps-4">Fill up the form</h3>
          <form class="row dashboard-square-kebab needs-validation" id="booking-form" novalidate>
            <div class="col-md-4 mb-3">
              <label for="firstName" class="form-label">First Name <span>*</span></label>
              <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" required onblur="handleInput(event)" oninput="validateName(event)" readonly value="<?php echo $customerFirstName; ?>" />
              <input type="hidden" name="hiddenFirstName" id="hiddenFirstName" value="<?php echo $customerFirstName; ?>" />
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div class="invalid-feedback">
                Please provide a valid first name.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="middleName" class="form-label">Middle Name</label>
              <input type="text" class="form-control" id="middleName" name="middleName" placeholder="" onblur="handleInput(event)" oninput="validateName(event)" readonly value="<?php echo $customerMiddleName; ?>" readonly value="<?php echo $customerMiddleName; ?>" />
              <input type="hidden" name="hiddenMiddleName" id="hiddenMiddleName" value="<?php echo $customerMiddleName; ?>" />
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div class="invalid-feedback">
                Please provide a valid middle name.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="lastName" class="form-label">Last Name <span>*</span></label>
              <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" required onblur="handleInput(event)" oninput="validateName(event)" readonly value="<?php echo $customerLastName; ?>" />
              <input type="hidden" name="hiddenLastName" id="hiddenLastName" value="<?php echo $customerLastName; ?>" />
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div class="invalid-feedback">
                Please provide a valid last name.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="birthDate" class="form-label">Birthdate <span>*</span></label>
              <input type="date" class="form-control" id="birthDate" required readonly value="<?php echo $customerBirthdate; ?>" />
              <input type="hidden" name="hiddenBirthDate" id="hiddenBirthDate" value="<?php echo $customerBirthdate; ?>" />
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div class="invalid-feedback">
                Please provide a valid birthdate.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
              <input type="text" class="form-control" id="contactNumber" name="contactNumber" required minlength="11" maxlength="11" oninput="validateContactNumber(event)" readonly value="<?php echo $customerNumber; ?>" />
              <input type="hidden" name="hiddenContactNumber" id="hiddenContactNumber" value="<?php echo $customerNumber; ?>" />
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div class="invalid-feedback">
                Please provide a valid contact number.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="email" class="form-label">Email Address <span>*</span></label>
              <input type="email" class="form-control" id="email" name="email" required oninput="validateEmail(event)" readonly value="<?php echo $customerEmail; ?>" />
              <input type="hidden" name="hiddenContactNumber" id="hiddenContactNumber" value="<?php echo $customerNumber; ?>" />
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div id="emailError" class="invalid-feedback">
                Please provide a valid email address.
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="selectDate" class="form-label">Select Date <span>*</span></label>
              <input type="date" class="form-control" name="selectDate" id="selectDate" placeholder="Enter membership validity here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" value="<?php echo $customerValidity; ?>" min="<?php echo date('Y-m-d'); ?>" />
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div class="invalid-feedback">
                Please provide a valid date.
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="selectStartTime" class="form-label">Start Time <span>*</span></label>
              <input type="time" class="form-control" id="selectStartTime" name="selectStartTime" required oninput="adjustEndTime()">
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div class="invalid-feedback">
                Please provide a valid start time.
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="selectEndTime" class="form-label">End Time <span>*</span></label>
              <input type="time" class="form-control" id="selectEndTime" name="selectEndTime" required>
              <div class="valid-feedback">
                <!-- Looks good! -->
              </div>
              <div class="invalid-feedback">
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
            <div class="row justify-content-end mt-5">
              <div class="col-12 col-md-2 mb-3 mb-md-0">
                <button class="btn btn-primary w-100 create-button-member" type="submit" id="create-walkin-button">Create</button>
              </div>
              <div class="col-12 col-md-2 mb-3 mb-md-0">
                <button class="btn btn-outline-primary w-100 cancel-button-member" type="button" onclick="window.location.reload()">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

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
            <button type="button" class="btn btn-outline-primary cancel-button-member" data-bs-dismiss="modal">Edit</button>
            <button type="button" class="btn btn-primary create-button-member" data-bs-toggle="modal" data-bs-target="#success-add-walkin-modal" id="success-reservation-button">Confirm</button>
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
            <!-- <button class="btn btn-primary create-button-member" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button> -->
            <button class="btn btn-primary  create-button" name="submitReserve" id="submitReserve" type="submit">Proceed</button>
          </div>
        </div>
      </div>
    </div>
    </div>



    <div id="updateTable" style="display:none;"><!--this div's only purpose is to help table update--></div>
    <script src="src/js/booking_form.js"></script>

  </body>

  </html>
<?php
} else {
  header('location:customer_login.php');
  exit();
}
?>