<?php
session_start();
if (isset($_SESSION["userSuperAdminID"]) || isset($_SESSION["userAdminID"])) { // Check for admin session too
  $visitors = 0;
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
          <div class="col-md-12">
            <h3 class="fw-bold ps-4">Fill up the form</h3>
            <form class="row dashboard-square-kebab needs-validation" id="booking-form" novalidate>
              <div class="col-md-4">
                <label for="firstName" class="form-label">First Name <span>*</span></label>
                <input type="text" class="form-control trim-input validate-input" name="firstName" placeholder="Enter first name here" id="firstName" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please enter a valid first name.
                </div>
              </div>
              <div class="col-md-4">
                <label for="middleName" class="form-label">Middle Name</label>
                <input type="text" class="form-control trim-input validate-input" name="middleName" placeholder="Enter middle name here" id="middleName">
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please enter a valid middle name.
                </div>
              </div>
              <div class="col-md-4">
                <label for="lastName" class="form-label">Last Name <span>*</span></label>
                <input type="text" class="form-control trim-input validate-input" name="lastName" placeholder="Enter last name here" id="lastName" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please enter a valid last name.
                </div>
              </div>
              <div class="col-md-4">
                <label for="birthDate" class="form-label">Birthdate <span>*</span></label>
                <input type="date" class="form-control trim-input validate-input" name="birthDate" id="birthDate" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please enter a valid birthdate.
                </div>
              </div>
              <div class="col-md-4">
                <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
                <input type="text" class="form-control trim-input validate-contact" name="contactNumber" id="contactNumber" placeholder="Enter contact number here" minlength="11" maxlength="11" required pattern="^09\d{9}$" oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long without spaces')" oninput="this.setCustomValidity(''); if (!/^\d*$/.test(this.value)) this.value = ''; this.value = this.value.replace(/\s/g, '')" />
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please enter a valid contact number.
                </div>
              </div>
              <div class="col-12 col-md-4">
                <label for="email" class="form-label">Email Address <span>*</span></label>
                <input type="email" class="form-control trim-input" name="email" id="email" placeholder="Enter email address here" required />
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback" id="emailError">
                  Please enter a valid email address.
                </div>
              </div>

              <div class="col-12 col-md-3">
                <label for="validity" class="form-label">Select Date <span>*</span></label>
                <input type="date" class="form-control" name="selectDate" id="selectDate" placeholder="Enter membership validity here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" value="<?php echo $customerValidity; ?>" min="<?php echo date('Y-m-d'); ?>" />
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please select a date.
                </div>
              </div>

              <div class="col-12 col-md-3">
                <label for="selectStartTime" class="form-label">Start Time <span>*</span></label>
                <select class="form-control" name="selectStartTime" id="selectStartTime" required onchange="updateEndTime()">
                  <option value="" selected disabled>Select start time</option>
                  <option value="10:00:00">10:00am</option>
                  <option value="11:00:00">11:00am</option>
                  <option value="12:00:00">12:00 noon</option>
                  <option value="13:00:00">1:00pm</option>
                  <option value="14:00:00">2:00pm</option>
                  <option value="15:00:00">3:00pm</option>
                  <option value="16:00:00">4:00pm</option>
                  <option value="17:00:00">5:00pm</option>
                  <option value="18:00:00">6:00pm</option>
                  <option value="19:00:00">7:00pm</option>
                  <option value="20:00:00">8:00pm</option>
                  <option value="21:00:00">9:00pm</option>
                  <option value="22:00:00">10:00pm</option>
                  <option value="23:00:00">11:00pm</option>
                  <option value="00:00:00">12:00 midnight</option>
                  <option value="1:00:00">1:00am</option>
                  <option value="2:00:00">2:00am</option>
                  <option value="3:00:00">3:00am</option>
                </select>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please select a start time.
                </div>
              </div>

              <div class="col-12 col-md-3 mb-3">
                <label for="selectEndTime" class="form-label">End Time <span>*</span></label>
                <select class="form-control" name="selectEndTime" id="selectEndTime" required>
                  <option value="" selected disabled>Select end time</option>
                  <!-- Options will be dynamically added based on selected start time -->
                </select>
                <div class="valid-feedback">
                  Looks good!
                </div>
                <div class="invalid-feedback">
                  Please select an end time.
                </div>
              </div>
              <div class="col-12 col-md-3 mb-3">
                <label for="selectTable" class="form-label">Select Table <span>*</span></label>
                <select class="form-control" name="selectTable" id="selectTable" placeholder="Select Table" required>
                  <!-- Options will be dynamically added based on selected start time onchange="this.setCustomValidity('')"-->
                </select>
                <div class="invalid-feedback">
                  Please select a table.
                </div>
              </div>
              <div class="col-12 col-md-12 mb-3 mb-4">
                <h6 class="mb-0 pb-0">Bevitore 2D Map</h6>
                <img src="src/images/map.png" alt="" style="width: 100%; height: 100%;">
              </div>
              <div class="row justify-content-end mt-5">
                <div class="col-12 col-md-2 mb-3 mb-md-0">
                  <button class="btn btn-primary w-100 create-button" name="submitReserve" id="submitReserve" type="submit">Create</button>
                </div>
                <div class="col-12 col-md-2">
                  <button class="btn btn-outline-primary w-100 cancel-button" type="reset" onclick="resetForm()">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>


    <div id="updateTable" style="display:none;"><!--this div's only purpose is to help table update--></div>
    <script src="src/js/sidebar.js"></script>
    <script src="src/js/admin_walk_in_form.js"></script>

  </body>

  </html>
<?php } else {
  header("location:login.php");
  die();
} ?>
















