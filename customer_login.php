<?php

include 'connect_database.php';
include 'encodeDecode.php';
include 'src/get_data_from_database/get_member_account.php';

//encryptData($data,$key); decryptData($data,$key);
$key = "TheGreatestNumberIs73";
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION['userMemberID'])) {
  header('location:customer_dashboard.php');
  die();
}

$error_message = ""; // Initialize error message variable

if(isset($_POST['login_member'])){                                                                
  $username=mysqli_real_escape_string($conn,$_POST['username']);
  $password=mysqli_real_escape_string($conn,$_POST['password']);
  $usernameExists = false;

  if(mysqli_num_rows($memberAccountConn) > 0){
    foreach($arrayMemberAccount as $membershipAccount){
      if(decryptData($membershipAccount['membershipID'],$key) == $username){
        $usernameExists = true;
        if(password_verify($password, $membershipAccount['membershipPassword'])){
          echo '<script language="javascript">';
          echo 'alert("You are now logged in!")';
          echo '</script>';
          $_SESSION['userMemberID'] = $membershipAccount['memberID'];
          header("location:customer_dashboard.php");
          exit();
        }else {
          $error_message = "Username and Password are mismatched.";
        }
        break; // No need to continue looping once username is found
      }
    }
  }

  if (!$usernameExists) {
    $error_message = "Account does not exist.";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bevitore Sta Rosa</title>

  <link rel="stylesheet" href="src/css/landing.css">
  <link rel="stylesheet" href="src/css/style.css">

  <!-- Fontawesome Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Montserrat Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

  <style>
    /* Eye Toggle */
    button.toggle-password {
      border: none !important;
      outline: none !important;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: transparent !important;
      color: gray;
      margin-right: 5%;
    }

    button.toggle-password:hover {
      background-color: transparent !important;
      color: black !important;
    }

    button.toggle-password:focus,
    button.toggle-password:active {
      background-color: transparent !important;
      color: gray !important;
    }

    button.toggle-password i {
      pointer-events: none;
    }

    button.toggle-password i {
      font-size: 1.2rem;
    }
  </style>

</head>

<body class="customer-landing">

  <div class="homepage" id="home">
    <div class="content container-fluid">
    <div class="home">
      <img src="src/images/Bevitore Billiards Hall Logo.png" alt="Bevitore Logo" class="bevitore-logo">
      <h1 class="qreserve" id="index-qreserve">QReserve</h1>
      <h6 class="bevitore">BEVITORE SANTA ROSA</h6>
      <div class="container-fluid login">
        <div class="row">
        <form action="customer_login.php" method="POST" onsubmit="return validateControlNumber()">
            <h5 class="text-center fw-bold">Welcome!</h5>

            <div id="error-message" class="alert alert-danger d-none" role="alert">
              <!-- Error message will be injected here -->
            </div>
            
            <?php if (!empty($error_message)) : ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
              </div>
            <?php endif; ?>
            
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="controlNumber" placeholder="" name="username" maxlength="7" minlength="7" required />
              <label for="controlNumber">Control Number <span>*</span></label>
            </div>
            <div class="form-floating mb-2 position-relative">
              <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" maxlength="30" required />
              <label for="floatingPassword">Password <span>*</span></label>
              <button class="btn btn-secondary toggle-password position-absolute end-0 top-50 translate-middle-y " type="button">
                <i class="fas fa-eye-slash"></i>
              </button>
            </div>

            <a href="" class="forgot-password">Forgot Password</a>
            <div class="">
              <button type="submit" class="btn btn-primary w-100 login-button mt-4" name="login_member" href="#" role="button">Sign In</button>
            </div>
          </form>

        </div>
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




  <script>
    // For password toggle
    document.addEventListener("DOMContentLoaded", function() {
      const togglePassword = document.querySelector(".toggle-password");
      const passwordInput = document.querySelector("#floatingPassword");
      const eyeIcon = togglePassword.querySelector("i");

      togglePassword.addEventListener("click", function() {
        const type =
          passwordInput.getAttribute("type") === "password" ?
          "text" :
          "password";
        passwordInput.setAttribute("type", type);

        // Toggle eye icon classes
        eyeIcon.classList.toggle("fa-eye-slash");
        eyeIcon.classList.toggle("fa-eye");
      });
    });

    // Validation for Control Number
    function validateControlNumber() {
      const controlNumber = document.getElementById('controlNumber').value;
      const errorMessageDiv = document.getElementById('error-message');
      const pattern = /^[0-9]{1,4}-[0-9]{1,4}$/;

      if (!pattern.test(controlNumber)) {
        errorMessageDiv.textContent = 'Please input a valid control number.';
        errorMessageDiv.classList.remove('d-none');
        return false;
      }

      errorMessageDiv.classList.add('d-none');
      return true;
    }
  </script>
</body>

</html>
