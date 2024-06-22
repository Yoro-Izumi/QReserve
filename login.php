<?php
session_start();
date_default_timezone_set('Asia/Manila');

include 'connect_database.php';
include 'encodeDecode.php';
include 'src/get_data_from_database/get_super_admin_accounts.php';
include 'src/get_data_from_database/get_admin_accounts.php';

//encryptData($data,$key); decryptData($data,$key);
$key = "TheGreatestNumberIs73";

if (isset($_SESSION['userSuperAdminID'])) {
  header('location:dashboard.php');
  die();
}
if (isset($_SESSION['userAdminID'])) {
  header('location:admin_dashboard.php');
  die();
}

$error_message = ""; // Initialize error message variable

if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Validate email domain
  if (substr($username, -10) !== '@gmail.com') {
    $error_message = "Please enter a valid email address.";
  } else {
    // Check if the username exists in either super admin or admin accounts
    $usernameExists = false;
    if (mysqli_num_rows($superAdminAccountConn) > 0) {
      foreach ($arraySuperAdminAccount as $superAdminAccount) {
        if (decryptData($superAdminAccount['superAdminEmail'], $key) == $username) {
          $usernameExists = true;
          break;
        }
      }
    }
    if (!$usernameExists && mysqli_num_rows($adminAccountConn) > 0) {
      foreach ($arrayAdminAccount as $adminAccount) {
        if (decryptData($adminAccount['adminEmail'], $key) == $username) {
          $usernameExists = true;
          break;
        }
      }
    }

    if (!$usernameExists) {
      $error_message = "Account does not exist."; // Set error message
    } else {
      // Username exists, now check password
      $loggedIn = false;

      if (mysqli_num_rows($superAdminAccountConn) > 0) {
        foreach ($arraySuperAdminAccount as $superAdminAccount) {
          if (decryptData($superAdminAccount['superAdminEmail'], $key) == $username && password_verify($password, $superAdminAccount['superAdminPassword'])) {
            $_SESSION['userSuperAdminID'] = $superAdminAccount['superAdminID'];
            $loggedIn = true;
            $logUser = "superAdmin:" . $superAdminAccount['$superAdminID'];
            break;
          }
        }
      }

      if (!$loggedIn && mysqli_num_rows($adminAccountConn) > 0) {
        foreach ($arrayAdminAccount as $adminAccount) {
          if (decryptData($adminAccount['adminEmail'], $key) == $username && password_verify($password, $adminAccount['adminPassword'])) {
            $_SESSION['userAdminID'] = $adminAccount['adminID'];
            $loggedIn = true;
            $logUser = "admin:" . $adminAccount['$adminID'];
            break;
          }
        }
      }

      if ($loggedIn) {
        echo '<script language="javascript">';
        echo 'alert("You are now logged in!")';
        echo '</script>';

        $accountType = explode(":", $logUser);

        if ($accountType[0] == "admin") {
          $_SESSION['userAdmin'] = $accountType[1];
          header("location:admin_dashboard.php");
          exit();
        } else if ($accountType[0] == "superAdmin") {
          $_SESSION['userSuperAdmin'] = $accountType[1];
          header("location:dashboard.php");
          exit();
        }
      } else {
        $error_message = "Username and Password are mismatched."; // Set error message
      }
    }
  }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

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

<link rel="stylesheet" href="src/loader/loader.css">
</head>

<body class="index-landing">
<?php include "src/loader/loader.html"; ?>
  <div class="container-fluid homepage">
    <div class="home">
      <img src="src/images/Bevitore Billiards Hall Logo.png" alt="Bevitore Logo" class="bevitore-logo">
      <h1 class="qreserve" id="index-qreserve">QReserve</h1>
      <h6 class="bevitore">BEVITORE SANTA ROSA</h6>
      <div class="container-fluid login">
        <div class="row">
          <form action="login.php" method="POST">
            <h5 class="text-center fw-bold">Welcome!</h5>

            <?php if (!empty($error_message)) : ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
              </div>
            <?php endif; ?>

            <div class="form-floating mb-3">
              <input type="email" name="username" class="form-control" id="floatingInput" placeholder="name@example.com" required />
              <label for="floatingInput">Email address <span>*</span></label>
            </div>
            <div class="form-floating mb-2 position-relative">
              <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required oninput="validatePassword(event)"/>
              <label for="floatingPassword">Password <span>*</span></label>
              <button class="btn btn-secondary toggle-password position-absolute end-0 top-50 translate-middle-y " type="button">
                <i class="fas fa-eye-slash"></i>
              </button>
            </div>

            <a href="" class="forgot-password">Forgot Password</a>
            <div class="">
              <button type="submit" name="login" class="btn btn-primary w-100 login-button mt-4">Sign In</button>
            </div>
          </form>

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
  function validatePassword(event) {
  // Allow only alphabetic characters, numbers, and specified special characters
  const regex = /^[a-zA-Z0-9._%+\-!@#$^&*]*$/;
  if (!regex.test(event.target.value)) {
    event.target.value = event.target.value.replace(/[^a-zA-Z0-9._%+\-!@#$^&*]/g, '');
  }
}

</script>

<script src="src/loader/loader.js"></script>
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
  </script>
</body>

</html>