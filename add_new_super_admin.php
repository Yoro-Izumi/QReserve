<?php
include "connect_database.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');
if (isset($_POST['submitSuperAdmin'])) {
  $email = encryptData(mysqli_real_escape_string($conn, $_POST['email']), $key);
  $username = encryptData(mysqli_real_escape_string($conn, $_POST['username']), $key);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Hash the password using Argon2
  $options = [
    'memory_cost' => 1 << 17, // 128MB memory cost (default)
    'time_cost' => 4,       // 4 iterations (default)
    'threads' => 3,         // Use 3 threads for processing (default)
  ];
  $hashedPassword = password_hash($password, PASSWORD_ARGON2I, $options);

  //here is where the super admin account is inserted
  $qryInsertSuperAdminAccount = "INSERT INTO `super_admin`(`superAdminID`, `superAdminUsername`, `superAdminPassword`, `superAdminEmail`) VALUES (NULL,?,?,?)";
  $conInsertSuperAdminAccount = mysqli_prepare($conn, $qryInsertSuperAdminAccount);
  mysqli_stmt_bind_param($conInsertSuperAdminAccount, 'sss', $username, $hashedPassword, $email);
  mysqli_stmt_execute($conInsertSuperAdminAccount);
  header("location:Refresh:0");
}
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Admin Profiles</title>

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
  <link rel="stylesheet" href="./css/sidebar.css" />
  <link rel="stylesheet" href="./css/style.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
</head>

<body>
  <?php include "superadmin_sidebar.php"; ?>

  <section class="home-section">
    <h4 class="krona-one-regular mt-5">Add New Admin</h4>
    <hr class="my-4">
    <div class="container-fluid" id="profmanage-add-new-profile">
      <form class="needs-validation dashboard-square-kebab" id="add-new-profile-form" novalidate action="add_new_super_admin.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12 col-md-3 mb-3">
            <label for="contactNumber" class="form-label">Username <span>*</span></label>
            <input type="text" class="form-control" name="username" id="contactNumber" placeholder="Enter Username here" required pattern="^09\d{9}$" oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long')" oninput="this.setCustomValidity('')" />
            <!-- <div class="valid-feedback">
                      <!-- Looks good! -->
                  </div> -->
            <div class="invalid-feedback">
              Please enter a valid username.
            </div>
          </div>
          <div class="col-12 col-md-3 mb-3">
            <label for="email" class="form-label">Email Address <span>*</span></label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address here" required oninvalid="this.setCustomValidity('Please enter a valid email address')" oninput="this.setCustomValidity('')" />
            <!-- <div class="valid-feedback">
                <!-- Looks good! -->
            </div> -->
            <div class="invalid-feedback">
              Please enter a valid email address.
            </div>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <label for="password" class="form-label">Password <span>*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" id="password" placeholder="Enter password here" required />
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
              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Re-enter password here" required />
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
            <button class="btn btn-primary w-100 create-button" name="submitSuperAdmin" type="submit">Create</button>
          </div>
          <div class="col-12 col-md-2">
            <button class="btn btn-outline-primary w-100 cancel-button" type="reset" onclick="resetForm()">Cancel</button>
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
    document.addEventListener("DOMContentLoaded", function() {
      const togglePassword1 = document.querySelector("#password-toggle-1");
      const passwordInput1 = document.querySelector("#password");
      const eyeIcon1 = togglePassword1.querySelector("i");

      togglePassword1.addEventListener("click", function() {
        const type =
          passwordInput1.getAttribute("type") === "password" ?
          "text" :
          "password";
        passwordInput1.setAttribute("type", type);

        // Toggle eye icon classes
        eyeIcon1.classList.toggle("fa-eye-slash");
        eyeIcon1.classList.toggle("fa-eye");
      });

      const togglePassword2 = document.querySelector("#password-toggle-2");
      const passwordInput2 = document.querySelector("#confirmPassword");
      const eyeIcon2 = togglePassword2.querySelector("i");

      togglePassword2.addEventListener("click", function() {
        const type =
          passwordInput2.getAttribute("type") === "password" ?
          "text" :
          "password";
        passwordInput2.setAttribute("type", type);

        // Toggle eye icon classes
        eyeIcon2.classList.toggle("fa-eye-slash");
        eyeIcon2.classList.toggle("fa-eye");
      });
    });
  </script>

  <!-- For password checking -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const passwordInput = document.querySelector("#password");
      const confirmPasswordInput = document.querySelector("#confirmPassword");
      const passwordMatchFeedback = document.querySelector("#passwordMatchFeedback");
      const passwordMatch = document.querySelector("#passwordMatch");
      const passwordMismatch = document.querySelector("#passwordMismatch");

      confirmPasswordInput.addEventListener("input", function() {
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


</body>

</html>