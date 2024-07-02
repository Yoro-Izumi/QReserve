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
                <!-- <button class="btn btn-outline-primary w-100 cancel-button-member" type="button" onclick="window.location.reload()">Cancel</button> -->
                <button class="btn btn-outline-primary w-100 cancel-button-member" type="button" onclick="handleCancel()">Cancel</button>

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
            <h2 class="modal-title  fw-bold text-center" id="success"><img src="src/images/icons/file.gif" alt="Wait Icon" class="modal-icons">On Process...</h2>
          </div>
          <div class="modal-body text-center">
            <p>Your booking is now on process!<br>Please check your email for the details of your reservation.</p>
            <p class="proceed">Proceed to pay your reservation through the provided Payment Details</p>
            <p class="gcash">GCash: 09123456789</p>
            <p>Send your proof of payment to <a href="https://www.facebook.com/Bevitore.Sta.Rosa">Bevitore’s Facebook Page.</a></p>
          </div>
          <div class="modal-footer">
            <!-- <button class="btn btn-primary create-button-member" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button> -->
            <button class="btn btn-primary  create-button-member" name="submitReserve" id="submitReserve" type="submit">Proceed</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="dataPrivacy" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title fw-bold" id="success">
              <img src="src/images/icons/insurance.gif" alt="Wait Icon" class="modal-icons">Bevitore Customer Policy
            </h2>
          </div>
          <div class="modal-body">
            <p class="fw-bold">Please be guided to Bevitore Customer Policy:</p>
            <p class="fw-bold mt-3 mb-0">Reservation Confirmation:</p>
            <ul class="mt-0 mb-0">
              <li>The reservation will be confirmed once the table is available upon checking. You will receive an email containing the confirmed reservation and your reservation details.</li>
            </ul>
            <p class="fw-bold mt-3 mb-0">Reservation Rejection:</p>
            <ul class="mt-0 mb-0">
              <li>You will receive an email indicating the reason for your rejected reservation.</li>
            </ul>
            <p class="fw-bold mt-3 mb-0">Cancellation Policy:</p>
            <ul class="mt-0 mb-0">
              <li>If you wish to cancel your reservation, your payment will be non-refundable and non-transferable.</li>
            </ul>
            <p class="fw-bold mt-3 mb-0">No-show Policy:</p>
            <ul class="mt-0 mb-0">
              <li>If you fail to show up to your scheduled and confirmed reservation without prior notice, your reservation will be voided.</li>
              <li>Your payment will be non-refundable and non-transferable.</li>
            </ul>
            <p class="fw-bold mt-4 mb-0">For more inquiries, contact us at <a href="https://www.facebook.com/Bevitore.Sta.Rosa">Bevitore Santa Rosa</a></p>
          </div>
          <div class="modal-footer text-center">
            <button class="btn btn-primary create-button-member" data-bs-toggle="modal">I understand</button>
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
            <button type="button" class="btn btn-outline-primary cancel-button-member" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary create-button-member" data-bs-toggle="modal" id="proceedButton">Proceed</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Bootstrap Modal -->
    <!-- Example Bootstrap Modal for unsaved changes -->
    <div class="modal fade" id="confirmUnsavedReloadModal" tabindex="-1" aria-labelledby="confirmUnsavedReloadModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmUnsavedReloadModalLabel">Unsaved Changes</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>You have unsaved changes. Are you sure you want to reload the page?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="proceedReloadBtn" class="btn btn-primary">Reload</button>
          </div>
        </div>
      </div>
    </div>
    </div>





    <script>
      $(document).ready(function() {
        $('#dataPrivacy').modal('show'); // Show the modal on page load
      });
    </script>


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