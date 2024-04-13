<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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

    <link rel="stylesheet" href="./css/style.css" />
    <title>Document</title>

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
  <body id="booking-page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 text-center">
          <img
            src="./images/Bevitore-logo.png"
            class="img-fluid"
            id="index-logo"
          />
          <h1 class="krona-one-regular mb-0">QReserve</h1>
          <h6 class="mb-4" id="index-sub">BEVITORE SANTA ROSA</h6>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" id="hello">
          <form class="needs-validation" id="login-form" novalidate action="login_admin_code.php" method="POST">
            <h5 class="text-center mb-3 fw-bold">Welcome!</h5>
            <div class="form-floating mb-3">
              <input
                type="email"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
                name="username"
              />
              <label for="floatingInput">Email address</label>
            </div>

            <div class="form-floating mb-3 position-relative">
              <input
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Password"
                name="password"
              />
              <label for="floatingPassword">Password</label>
              <button
                class="btn btn-outline-secondary toggle-password position-absolute end-0 top-50 translate-middle-y p-4"
                type="button" name="login_button"
              >
                <i class="fas fa-eye"></i>
              </button>
            </div>

            <div class="col-12 col-md-12 mb-3 mb-md-0 mt-4">
              <a
                href="dashboard.html"
                type="button"
                class="btn btn-primary w-100"
                id="login-button"
                >Sign In</a
              >
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap 5 JS and Font Awesome JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <!-- Custom JavaScript for password toggle -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const togglePassword = document.querySelector(".toggle-password");
        const passwordInput = document.querySelector("#floatingPassword");

        togglePassword.addEventListener("click", function () {
          const type =
            passwordInput.getAttribute("type") === "password"
              ? "text"
              : "password";
          passwordInput.setAttribute("type", type);

          // Toggle eye icon classes
          const eyeIcon = this.querySelector("i");
          eyeIcon.classList.toggle("fa-eye");
          eyeIcon.classList.toggle("fa-eye-slash");
        });
      });
    </script>
  </body>
</html>
