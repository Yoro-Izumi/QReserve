<?php
session_start();
if(isset($_SESSION["userSuperAdminID"])){
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Service</title>

  <!-- Boxicons CDN Link -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Online Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />

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
  <link rel="stylesheet" href="./css/sidebar.css" />
  <link rel="stylesheet" href="./css/style.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <img src="./images/Bevitore-logo.png" class="img-fluid icon" id="sidebar-logo" />
      <div class="logo_name krona-one-regular ms-2 mb-0">QReserve</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <!-- <li>
          <i class='bx bx-search' ></i>
         <input type="text" placeholder="Search...">
         <span class="tooltip">Search</span>
      </li> -->
      <li>
        <a href="dashboard.php">
          <i class="bx bx-home"></i>
          <span class="links_name">Home</span>
        </a>
        <span class="tooltip">Home</span>
      </li>
      <li>
        <a href="reservations_viewing.php">
          <i class="bx bx-book"></i>
          <span class="links_name">Reservations Viewing</span>
        </a>
        <span class="tooltip">Reservations</span>
      </li>
      <li>
        <a href="service management.php">
          <i class="bx bx-aperture"></i>
          <span class="links_name">Service Management</span>
        </a>
        <span class="tooltip">Services</span>
      </li>
      <li>
        <a href="profile_management.php">
          <i class="bx bx-user"></i>
          <span class="links_name">Profile Management</span>
        </a>
        <span class="tooltip">Profiles</span>
      </li>
      <!-- 
      <li class="nav-item dropdown">
        <a class="nav-link" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bx bx-user"></i>
          <span class="links_name dropdown-toggle">Profile Management </span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="admin-profiles.php">Admin Accounts</a></li>
          <li><a class="dropdown-item" href="member-profiles.php">Member Accounts</a></li>
        </ul>
      </li> -->
      <li>
        <a href="reports.php">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">Reports</span>
        </a>
        <span class="tooltip">Reports</span>
      </li>

      <li class="profile">
        <div class="profile-details">
          <div class="name_job">
            <div class="name">Prem Shahi</div>
            <div class="job">Web designer</div>
          </div>
        </div>
        <a href="index.php">
          <i class="bx bx-log-out" id="log_out"></i>
        </a>
      </li>
    </ul>
  </div>

  <section class="home-section">
    <h4 class="krona-one-regular mt-5">Add New Service</h4>
    <hr class="my-4" />
    <div class="container-fluid" id="profmanage-add-new-profile">
      <form class="needs-validation dashboard-square-kebab" id="add-new-profile-form" novalidate
        action="BABAGUHIN ITU.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12 col-md-4 mb-3">
            <label for="serviceName" class="form-label">Service Name <span>*</span></label>
            <input type="text" class="form-control" name="serviceName" id="serviceName"
              placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$"
              oninvalid="this.setCustomValidity('Please enter a valid first name')"
              oninput="this.setCustomValidity('')" />
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">
              Please enter a valid first name.
            </div>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <label for="serviceRate" class="form-label">Rate</label>
            <div class="input-group">
              <span class="input-group-text">₱</span>
              <input type="text" class="form-control" name="serviceRate" id="serviceRate" placeholder="Enter rate here"
                pattern="^\d+(\.\d{1,2})?$" required oninvalid="this.setCustomValidity('Please enter a valid rate')"
                oninput="this.setCustomValidity('')" />
            </div>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a valid rate.</div>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <label for="lastName" class="form-label">Last Name <span>*</span></label>
            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter last name here"
              required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$"
              oninvalid="this.setCustomValidity('Please enter a valid last name')"
              oninput="this.setCustomValidity('')" />
            <!-- <div class="valid-feedback">
                      Looks good!
                  </div> -->
            <div class="invalid-feedback">
              Please enter a valid last name.
            </div>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <label for="email" class="form-label">Email Address <span>*</span></label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address here"
              required oninvalid="this.setCustomValidity('Please enter a valid email address')"
              oninput="this.setCustomValidity('')" />
            <!-- <div class="valid-feedback">
                Looks good!
            </div> -->
            <div class="invalid-feedback">
              Please enter a valid email address.
            </div>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <label for="contactNumber" class="form-label">Username <span>*</span></label>
            <input type="text" class="form-control" name="contactNumber" id="contactNumber"
              placeholder="Enter contact number here" required pattern="^09\d{9}$" minlength="11" maxlength="11"
              oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long')"
              oninput="this.setCustomValidity('')" />
            <!-- <div class="valid-feedback">
                      Looks good!
                  </div> -->
            <div class="invalid-feedback">
              Please enter a valid contact number.
            </div>
          </div>
          <div class="col-12 col-md-4 mb-3">
            <label for="adminShift" class="form-label">Shift <span>*</span></label>
            <select class="form-control" name="adminShift" id="adminShift" required
              onchange="this.setCustomValidity('')">
              <option value="" selected disabled>Select shift</option>
              <option value="10 AM - 6PM">10AM - 6PM</option>
              <option value="6PM - 1AM">6PM - 1AM</option>
              <option value="6PM - 3AM">6PM - 3AM</option>
            </select>
            <div class="invalid-feedback">Please select a shift.</div>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <label for="password" class="form-label">Password <span>*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" id="password"
                placeholder="Enter password here" required />
              <button class="btn btn-secondary" type="button" id="password-toggle-1">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div class="invalid-feedback" id="passwordError">
              Please enter a valid password.
            </div>
          </div>
          <div class="col-12 col-md-6 mb-5">
            <label for="confirmPassword" class="form-label">Confirm Password <span>*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword"
                placeholder="Re-enter password here" required />
              <button class="btn btn-secondary" type="button" id="password-toggle-2">
                <i class="fas fa-eye"></i>
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
        </div>

        <!-- Buttons section -->
        <div class="row justify-content-end">
          <div class="col-12 col-md-2 mb-3 mb-md-0">
            <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">
              Create
            </button>
          </div>
          <div class="col-12 col-md-2">
            <button class="btn btn-outline-primary w-100 cancel-button" type="reset" onclick="resetForm()">
              Cancel
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <script>
    //For Sidebar
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

  <!-- Updated script for password toggle -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const togglePassword1 = document.querySelector("#password-toggle-1");
      const passwordInput1 = document.querySelector("#password");
      const eyeIcon1 = togglePassword1.querySelector("i");

      togglePassword1.addEventListener("click", function () {
        const type =
          passwordInput1.getAttribute("type") === "password"
            ? "text"
            : "password";
        passwordInput1.setAttribute("type", type);

        // Toggle eye icon classes
        eyeIcon1.classList.toggle("fa-eye-slash");
        eyeIcon1.classList.toggle("fa-eye");
      });

      const togglePassword2 = document.querySelector("#password-toggle-2");
      const passwordInput2 = document.querySelector("#confirmPassword");
      const eyeIcon2 = togglePassword2.querySelector("i");

      togglePassword2.addEventListener("click", function () {
        const type =
          passwordInput2.getAttribute("type") === "password"
            ? "text"
            : "password";
        passwordInput2.setAttribute("type", type);

        // Toggle eye icon classes
        eyeIcon2.classList.toggle("fa-eye-slash");
        eyeIcon2.classList.toggle("fa-eye");
      });
    });
  </script>

  <!-- For password checking -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const passwordInput = document.querySelector("#password");
      const confirmPasswordInput = document.querySelector("#confirmPassword");
      const passwordMatchFeedback = document.querySelector(
        "#passwordMatchFeedback"
      );
      const passwordMatch = document.querySelector("#passwordMatch");
      const passwordMismatch = document.querySelector("#passwordMismatch");

      confirmPasswordInput.addEventListener("input", function () {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (password === confirmPassword) {
          passwordMatchFeedback.innerHTML = "";
          passwordMatch.style.display = "block";
          passwordMismatch.style.display = "none";
        } else {
          passwordMatchFeedback.innerHTML = "";
          passwordMatch.style.display = "none";
          passwordMismatch.style.display = "block";
        }
      });
    });
  </script>

  <script> //For Rate
    document.addEventListener("DOMContentLoaded", function () {
      const serviceRateInput = document.querySelector("#serviceRate");

      // Add event listener for input
      serviceRateInput.addEventListener("input", function () {
        // Get the input value
        let rate = serviceRateInput.value;

        // Remove non-numeric characters and leading zeroes
        rate = rate.replace(/\D/g, "").replace(/^0+/, "");

        // Format the rate with Philippine Peso sign and commas for thousands separator
        rate =
          "₱" +
          parseFloat(rate).toLocaleString(undefined, {
            minimumFractionDigits: 2,
          });

        // Update the input value
        serviceRateInput.value = rate;
      });
    });
  </script>
</body>

</html>
<?php } else{
header("location:login.php");
}?>?>