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

if (isset($_POST['login_member'])) {
  $controlNumber = mysqli_real_escape_string($conn, $_POST['controlNumber']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $controlNumberExists = false;

  if (mysqli_num_rows($memberAccountConn) > 0) {
    foreach ($arrayMemberAccount as $membershipAccount) {
      if (decryptData($membershipAccount['membershipID'], $key) == $controlNumber) {
        $controlNumberExists = true;
        if (password_verify($password, $membershipAccount['membershipPassword'])) {
          echo '<script language="javascript">';
          echo 'alert("You are now logged in!")';
          echo '</script>';
          $_SESSION['userMemberID'] = $membershipAccount['memberID'];
          header("location:customer_dashboard.php");
          exit();
        } else {
          $error_message = "Control Number or Password is mismatched.";
        }
        break; // No need to continue looping once controlNumber is found
      }
    }
  }

  if (!$controlNumberExists) {
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

  <!-- Boxicons CDN Link -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Montserrat Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

  <!-- Online Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <!-- External CSS -->
  <link rel="stylesheet" href="src/css/sidebar.css" />
  <link rel="stylesheet" href="src/css/style.css" />

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

              <!-- <div class="form-floating mb-3">
                <input type="text" class="form-control" id="controlNumber" placeholder="" name="controlNumber" maxlength="7" minlength="7" required onblur="validateControlNumber2(event)" onblur="handleInput(event)" />
                <label for="controlNumber">Control Number <span>*</span></label>
              </div> -->
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="controlNumber" placeholder="Enter control number here (e.g., 00-0000)" name="controlNumber" required minlength="7" maxlength="7" onblur="validateControlNumber2(event)">
                <label for="controlNumber">Control Number <span>*</span></label>
              </div>
              <div class="form-floating mb-2 position-relative">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" maxlength="30" required oninput="validatePassword(event)" />
                <label for="floatingPassword">Password <span>*</span></label>
                <button class="btn btn-secondary toggle-password position-absolute end-0 top-50 translate-middle-y " type="button">
                  <i class="fas fa-eye-slash"></i>
                </button>
              </div>

              <a href="#" class="forgot-password" data-bs-toggle="modal" data-bs-target="#forget-password-modal">Forgot Password</a>
              <div class="">
                <button type="submit" class="btn btn-primary w-100 login-button mt-4" name="login_member" href="#" role="button">Sign In</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Modals -->
  <!-- Change Password Modal -->
  <div class="modal fade" id="forget-password-modal" name="forget-password-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-custom" id="">
        <div class="modal-header">
          <h4 class="modal-title fw-bold text-center" id="success">Forget Password</h4>
        </div>
        <div class="modal-body">
          <div id="sendPinError" class="alert alert-danger" role="alert" style="display: none;"></div>
          <form id="send-pin-form" name="send-pin-form">
            <label for="email" class="form-label">Email Address <span>*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address here" oninput="validateEmail(event)" maxlength="56" required>
          </form>
          <div class="valid-feedback">
            <!-- Looks good! -->
          </div>
          <div id="emailError" class="invalid-feedback">
            Please provide a valid email address.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id="forgetPassButton" name="forgetPassButton" class="btn btn-primary continue-button">Continue</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Continue Change Password Modal -->
  <div class="modal fade" id="continue-forget-password" name="continue-forget-password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-custom" id="">
        <div class="modal-header">
          <h4 class="modal-title fw-bold text-center" id="success">Enter Reset Code</h4>
        </div>
        <form id="submit-new-pass" name="submit-new-pass">
          <div class="modal-body">
            <div id="resetPasswordError" class="alert alert-danger" role="alert" style="display: none;"></div>
            <label for="pinInput" class="form-label">Reset Code <span>*</span></label>
            <input type="text" class="form-control" id="pinInput" placeholder="Enter reset code here" name="pinInput" required minlength="6" maxlength="6" oninput="validateContactNumber(event)">
            <div class="valid-feedback">
              <!-- Looks good! -->
            </div>
            <div class="invalid-feedback">
              Please provide a valid pin.
            </div>
            <label for="password" class="form-label">Password <span>*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" name="new-password" id="new-password" placeholder="Enter password here" required oninput="checkPasswordStrength(this.value)" />
              <button class="btn btn-secondary eye-toggle" type="button" id="password-toggle-1">
                <i class="fas fa-eye-slash"></i>
              </button>
            </div>
            <div id="password-strength-indicator"></div>
            <label for="confirmPassword" class="form-label">Confirm Password <span>*</span></label>
            <div class="input-group">
              <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Re-enter password here" required />
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
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="submitPinButton" name="submitPinButton" class="btn btn-primary continue-button">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Success Change Password Modal -->
  <div class="modal fade" id="success-forget-password" name="success-forget-password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-custom" id="">
        <div class="modal-header">
          <h4 class="modal-title fw-bold text-center" id="success">Success!</h4>
        </div>
        <div class="modal-body">
          You have successfully changed your password. Try to log in again.
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary continue-button" onclick="location.reload();" id="proceed" data-bs-target="#" data-bs-toggle="modal">Continue</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End of Modals -->
  <script>
    $(document).ready(function() {
      // $('.toggle-password').click(function () {
      //   const input = $(this).siblings('input');
      //   const icon = $(this).children('i');
      //   const type = input.attr('type') === 'password' ? 'text' : 'password';
      //   input.attr('type', type);
      //   icon.toggleClass('fa-eye-slash fa-eye');
      // });

      // Handle AJAX for sending reset PIN
      $('#forgetPassButton').click(function() {
        const form = $('#send-pin-form');
        $.ajax({
          url: 'customer_send_pin.php',
          type: 'POST',
          data: form.serialize(),
          success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
              $('#forget-password-modal').modal('hide');
              $('#continue-forget-password').modal('show');
            } else {
              $('#sendPinError').text(res.message).show();
            }
          },
          error: function() {
            $('#sendPinError').text('Error sending PIN.').show();
          }
        });
      });

      // Handle AJAX for submitting new password
      $('#submitPinButton').click(function() {
        const form = $('#submit-new-pass');
        if ($('#new-password').val() !== $('#confirm-password').val()) {
          $('#resetPasswordError').text('Passwords do not match.').show();
          return;
        }
        $.ajax({
          url: 'customer_submit_new_password.php',
          type: 'POST',
          data: form.serialize(),
          success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
              $('#continue-forget-password').modal('hide');
              $('#success-forget-password').modal('show');
            } else {
              $('#resetPasswordError').text(res.message).show();
            }
          },
          error: function() {
            $('#resetPasswordError').text('Error resetting password.').show();
          }
        });
      });
    });

    // Password Strength Indicator
    function checkPasswordStrength(password) {
      const strength = document.getElementById('password-strength-indicator');
      const strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})");
      const mediumRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})");

      if (strongRegex.test(password)) {
        strength.innerHTML = '<span style="color:green">Strong password</span>';
      } else if (mediumRegex.test(password)) {
        strength.innerHTML = '<span style="color:orange">Moderate password</span>';
      } else {
        strength.innerHTML = '<span style="color:red">Weak password</span>';
      }
    }

    // Password Match Validation
    document.addEventListener("DOMContentLoaded", function() {
      const passwordInput = document.querySelector("#new-password");
      const confirmPasswordInput = document.querySelector("#confirm-password");
      const passwordMatch = document.querySelector("#passwordMatch");
      const passwordMismatch = document.querySelector("#passwordMismatch");

      function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        if (password === confirmPassword) {
          passwordMatch.style.display = "block";
          passwordMismatch.style.display = "none";
        } else {
          passwordMatch.style.display = "none";
          passwordMismatch.style.display = "block";
        }
      }

      passwordInput.addEventListener("input", validatePasswordMatch);
      confirmPasswordInput.addEventListener("input", validatePasswordMatch);
    });
  </script>





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
    document.addEventListener("DOMContentLoaded", function() {
      const togglePassword1 = document.querySelector("#password-toggle-1");
      const passwordInput1 = document.querySelector("#new-password"); // Corrected selector for password input

      togglePassword1.addEventListener("click", function() {
        const type = passwordInput1.getAttribute("type") === "password" ? "text" : "password";
        passwordInput1.setAttribute("type", type);

        // Toggle eye icon classes
        togglePassword1.querySelector("i").classList.toggle("fa-eye-slash");
        togglePassword1.querySelector("i").classList.toggle("fa-eye");
      });

      const togglePassword2 = document.querySelector("#password-toggle-2");
      const passwordInput2 = document.querySelector("#confirm-password"); // Corrected selector for confirm password input

      togglePassword2.addEventListener("click", function() {
        const type = passwordInput2.getAttribute("type") === "password" ? "text" : "password";
        passwordInput2.setAttribute("type", type);

        // Toggle eye icon classes
        togglePassword2.querySelector("i").classList.toggle("fa-eye-slash");
        togglePassword2.querySelector("i").classList.toggle("fa-eye");
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

  <script>
    function validatePassword(event) {
      // Allow only alphabetic characters, numbers, and specified special characters
      const regex = /^[a-zA-Z0-9._%+\-!@#$^&*]*$/;
      if (!regex.test(event.target.value)) {
        event.target.value = event.target.value.replace(/[^a-zA-Z0-9._%+\-!@#$^&*]/g, '');
      }
    }


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
  </script>
  <script>
    function validateControlNumber2(event) {
      const input = event.target;
      let value = input.value;

      // Allow only numeric characters and a single hyphen
      value = value.replace(/[^0-9-]/g, '');

      // Ensure there's only one hyphen and it's in the correct position (after two digits)
      const parts = value.split('-');
      if (parts.length > 2 || (parts[1] && parts[1].length > 4) || (parts[0] && parts[0].length > 2)) {
        input.setCustomValidity('Please provide a valid contact number (format: 00-0000).');
      } else {
        // Reconstruct the value ensuring the correct format
        value = parts[0].slice(0, 2);
        if (parts.length > 1) {
          value += '-' + parts[1].slice(0, 4);
        }

        input.value = value;

        // Check if the pattern is valid: two digits, one hyphen, four digits
        const pattern = /^\d{2}-\d{4}$/;
        if (pattern.test(input.value) && input.value !== '-') {
          input.setCustomValidity(''); // Valid input
        } else {
          input.setCustomValidity('Please provide a valid contact number (format: 00-0000).');
        }
      }
    }
  </script>

  <script src="src/js/add_new_admin.js"></script>

</body>

</html>