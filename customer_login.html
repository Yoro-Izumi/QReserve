<?php
session_start();
include 'connect_database.php';
include 'get_data_from_database/get_member_account.php';

//encryptData($data,$key); decryptData($data,$key);
$key = "TheGreatestNumberIs73";

if (isset($_SESSION['username'])){
	header('location:customer_dashboard.php');
	die();
}

if(isset($_POST['login_member'])){                                                                
  $username=mysqli_real_escape_string($conn,$_POST['username']);
  $password=mysqli_real_escape_string($conn,$_POST['password']);
    if(mysqli_num_rows($memberAccountConn) > 0){
        foreach($arrayMemberAccount as $membershipAccount){
          if(decryptData($membershipAccount['membershipID'],$key) == $username){
            echo '<script language="javascript">';
            echo 'alert("You are now logged in!")';
            echo '</script>';
            $_SESSION['username'] = $username;
            header("location:customer_dashboard.php");
            exit();
        }
          else{
            echo '<script language="javascript">';
            echo 'alert("Username and Password does not exist")';
            echo '</script>';
          }
        }
    }
    else{
      echo '<script language="javascript">';
      echo 'alert("Username and Password does not exist")';
      echo '</script>';
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="./css/landing.css">
    <link rel="stylesheet" href="./css/style.css">

    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

      <!-- Bootstrap 5 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Montserrat Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />

    <style>
      .toggle-password {
        height: 20px;
        border: none;
        outline: none;
        padding: 0;
        display: flex;
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
      }

      .toggle-password:focus {
        outline: none;
        border: none;
      }

      .toggle-password:hover {
        background-color: transparent;
        border: none;
        color: black;
      }

      .toggle-password i {
        pointer-events: none;
        border: none;
      }

      /* Additional styles to adjust the icon size */
      .toggle-password i {
        font-size: 1.2rem; /* Adjust the size as needed */
      }
    </style>

  </head>
  <body id="customer-landing">

    <!-- <section class="homepage" id="home"> -->
      <section class="homepage" id="home">
      <div class="content container-fluid">
        <div class="text">
          <img src="./images/Bevitore Billiards Hall Logo.png" alt="" height="150px">
          <h1 class="krona-one-regular mb-0">QReserve</h1>
          <h6 class="m-0 pb-0 index-sub">BEVITORE SANTA ROSA</h6>
        </div>
        <div class="container-fluid login">
          <div class="row">
            <form action="customer_login.php" method="POST">
              <h5 class="text-center fw-bold">Welcome!</h5>
              <div class="form-floating mb-3">
                <input
                  type="email"
                  class="form-control"
                  id="floatingInput"
                  placeholder="name@example.com"
                  name = "username"
                  required
                />
                <label for="floatingInput">Email address</label>
              </div>
              <div class="form-floating mb-3 position-relative">
                <input
                  type="password"
                  class="form-control"
                  id="floatingPassword"
                  placeholder="Password"
                  name = "password"
                  required
                />
                <label for="floatingPassword">Password</label>
                <button
                  class="btn btn-outline-secondary toggle-password position-absolute end-0 top-50 translate-middle-y p-4"
                  type="button"
                >
                  <i class="fas fa-eye"></i>
                </button>
              </div>
              <div class="">
                <button
                  type ="submit"
                  class="btn btn-primary w-100 login-button"
                  name = "login_member"
                  href="#" role="button"
                  >Sign In</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <script>// For password togggle
      document.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.querySelector(".toggle-password");
        const passwordInput = document.querySelector("#floatingPassword");
        const eyeIcon = togglePassword.querySelector("i");

        togglePassword.addEventListener("click", function () {
          const type =
            passwordInput.getAttribute("type") === "password"
              ? "text"
              : "password";
          passwordInput.setAttribute("type", type);

          // Toggle eye icon classes
          eyeIcon.classList.toggle("fa-eye-slash");
          eyeIcon.classList.toggle("fa-eye");
        });
      });
    </script>
  </body>
</html>
