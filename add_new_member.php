<?php
include "connect_database.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION["userSuperAdminID"])) {
  $userSuperAdmin = $_SESSION["userSuperAdminID"];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Member Profile</title>
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
</head>

<body>
  <?php include "superadmin_sidebar.php"; ?>

  <section class="home-section">
    <h4 class="qreserve mt-5">Add New Member</h4>
    <hr class="my-4">
    <div class="container-fluid" id="profmanage-add-new-profile">
      <form class="row dashboard-square-kebab needs-validation" id="booking-form" novalidate>
        <div class="col-md-4 mb-2">
          <label for="firstName" class="form-label">First Name <span>*</span></label>
          <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name here" required onblur="handleInput(event)" oninput="validateName(event)" maxlength="50">
          <div class="valid-feedback">
            <!-- Looks good! -->
          </div>
          <div class="invalid-feedback">
            Please provide a valid first name.
          </div>
        </div>
        <div class="col-md-4 mb-2">
          <label for="middleName" class="form-label">Middle Name</label>
          <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Enter middle name here" onblur="handleInput(event)" oninput="validateName(event)" maxlength="50">
          <div class="valid-feedback">
            <!-- Looks good! -->
          </div>
          <div class="invalid-feedback">
            Please provide a valid middle name.
          </div>
        </div>
        <div class="col-md-4 mb-2">
          <label for="lastName" class="form-label">Last Name <span>*</span></label>
          <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name here" required onblur="handleInput(event)" oninput="validateName(event)" maxlength="50">
          <div class="valid-feedback">
            <!-- Looks good! -->
          </div>
          <div class="invalid-feedback">
            Please provide a valid last name.
          </div>
        </div>
        <div class="col-md-4 mb-2">
                <label for="birthDate" class="form-label">Birthdate <span>*</span></label>
                <input type="date" class="form-control" id="birthDate" name="birthDate" required max="2100-12-31">
                <div class="valid-feedback">
                  <!-- Looks good! -->
                </div>
                <div class="invalid-feedback">
                  Please provide a valid birthdate.
                </div>
              </div>
        <div class="col-md-4 mb-2">
          <label for="email" class="form-label">Email Address <span>*</span></label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email here" required oninput="validateEmail(event)" onblur="handleInput(event)" maxlength="50"   >
          <div class="valid-feedback">
            <!-- Looks good! -->
          </div>
          <div id="emailError" class="invalid-feedback">
            Please provide a valid email address.
          </div>
        </div>
        <div class="col-md-4 mb-2">
          <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
          <input type="text" class="form-control" id="contactNumber" placeholder="Enter contact number here" name="contactNumber" required minlength="11" maxlength="11" oninput="validateContactNumber(event)">
          <div class="valid-feedback">
            <!-- Looks good! -->
          </div>
          <div class="invalid-feedback">
            Please provide a valid contact number.
          </div>
        </div>
        <div class="col-md-6 mb-2">
          <label for="controlNumber" class="form-label">Control Number <span>*</span></label>
          <input type="text" class="form-control" id="controlNumber" placeholder="Enter control number here (e.g., 00-0000)" name="controlNumber" required minlength="7" maxlength="7" onblur="validateControlNumber(event)">
          <div class="valid-feedback">
            <!-- Looks good! -->
          </div>
          <div id="controlNumberFeedback" class="invalid-feedback">
            Please provide a valid control number.
          </div>
        </div>
        <div class="col-md-6 mb-2">
          <label for="validity" class="form-label">Validity Date <span>*</span></label>
          <input type="date" class="form-control" id="validity" placeholder="Enter birthDate here" name="validity" required onblur="handleInput(event)" oninput="validateUsername(event)">
          <div class="valid-feedback">
            <!-- Looks good! -->
          </div>
          <div class="invalid-feedback">
            Please provide a valid validity date.
          </div>
        </div>
        <div class="col-12 col-md-6">
          <label for="password" class="form-label">Password <span>*</span></label>
          <div class="input-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password here" required oninput="checkPasswordStrength(this.value)" maxlength="50"/>
            <button class="btn btn-secondary eye-toggle" type="button" id="password-toggle-1">
              <i class="fas fa-eye-slash"></i>
            </button>
          </div>
          <div id="password-strength-indicator"></div>
        </div>
        <div class="col-12 col-md-6">
          <label for="confirmPassword" class="form-label">Confirm Password <span>*</span></label>
          <div class="input-group">
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Re-enter password here" required maxlength="50" />
            <button class="btn btn-secondary eye-toggle" type="button" id="password-toggle-2">
              <i class="fas fa-eye-slash"></i>
            </button>
          </div>
          <div class="feedback" id="passwordMatchFeedback"></div>
          <div class="valid-feedback" id="passwordMatch">
            Passwords match!
          </div>
          <div class="invalid-feedback" id="passwordMismatch">
            Passwords do not match.
          </div>
        </div>
        <div class="row justify-content-end mt-5">
          <div class="col-12 col-md-2 mb-2 mb-md-0">
            <button class="btn btn-primary w-100 create-button" type="submit" id="create-walkin-button">Create</button>
          </div>
          <div class="col-12 col-md-2 mb-2 mb-md-0">
            <button class="btn btn-outline-primary w-100 cancel-button" type="button">Cancel</button>
          </div>
        </div>
      </form>
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
          <button type="button" class="btn btn-primary create-button" data-bs-toggle="modal" data-bs-target="#success-add-walkin-modal">Confirm</button>
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
          You have successfully registered a new account.
        </div>
        <div class="modal-footer">
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

  <div id="updateTable" style="display:none;"></div>
  <script src="src/js/add_new_member.js"></script>
  <script src="src/js/sidebar.js"></script>
</body>

</html>
<?php  } else {
  header("location:login.php");
} ?>
