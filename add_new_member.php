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
  <!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
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
      <div class="container-fluid dashboard-square-kebab" id="profmanage-add-new-profile">
      <!-- <form class="needs-validation" id="add-new-profile-form" novalidate action="add_new_member.php" method="POST" enctype="multipart/form-data"> -->
      <form class="needs-validation" id="add-new-profile-form" novalidate>
          <div class="row">
            <div class="col-12 col-md-4 mb-3">
              <label for="firstName" class="form-label">First Name <span>*</span></label>
              <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name here" required maxlength="30" pattern="^(?!\s*$)[A-Za-z\- ]" title="Please enter a valid first name." oninput="handleInput(event); this.value = this.value.replace(/[^A-Za-z\- ]/g, '')" />
              <!-- <div class="valid-feedback">
                      Looks good!
                  </div> -->
              <div class="invalid-feedback">
                Please enter a valid first name.
              </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
              <label for="middleName" class="form-label">Middle Name</label>
              <!-- <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Enter middle name here" required maxlength="30" pattern="^(?!\s*$)[A-Za-z\- ]+$" title="Please enter a valid middle name." oninput="this.value = this.value.replace(/[^A-Za-z\- ]/g, '')"> -->
              <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Enter middle name here" required maxlength="30" pattern="^(?!\s*$)[A-Za-z\- ]+$" title="Please enter a valid middle name." oninput="handleInput(event); this.value = this.value.replace(/[^A-Za-z\- ]/g, '')" />
              <!-- <div class="valid-feedback">
                      Looks good!
                  </div> -->
              <div class="invalid-feedback">
                Please enter a valid middle name.
              </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
              <label for="lastName" class="form-label">Last Name <span>*</span></label>
              <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter last name here" required maxlength="30" pattern="^(?!\s*$)[A-Za-z\- ]+$" title="Please enter a valid last name." oninput="handleInput(event); this.value = this.value.replace(/[^A-Za-z\- ]/g, '')" />
              <!-- <div class="valid-feedback">
                      Looks good!
                  </div> -->
              <div class="invalid-feedback">
                Please enter a valid last name.
              </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
              <label for="birthDate" class="form-label">Birthday<span>*</span></label>
              <input type="date" class="form-control" name="birthDate" id="birthDate" placeholder="Enter birthdate name here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" />
              <!-- <div class="valid-feedback">
                    Looks good!
                </div> -->
              <div class="invalid-feedback">
                Please enter a valid birthdate.
              </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
  <label for="email" class="form-label">Email Address <span>*</span></label>
  <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address here" required 
    oninvalid="this.setCustomValidity('Please enter a valid email address without spaces')" 
    oninput="this.setCustomValidity(''); this.value = this.value.replace(/\s/g, '')" 
    onkeyup="validateEmail(this.value)"
  />
  <div class="invalid-feedback">
    Please enter a valid Gmail address (e.g., yourname@gmail.com).
  </div>
</div>

<script>
function validateEmail(email) {
  var pattern = /^[\w-\.]+@gmail\.com$/i;
  var inputField = document.getElementById('email');
  if (!pattern.test(email)) {
    inputField.setCustomValidity('Please enter a valid Gmail address (e.g., yourname@gmail.com).');
  } else {
    inputField.setCustomValidity('');
    if (email.endsWith('@gmail.com')) {
      var atIndex = email.indexOf('@');
      inputField.value = email.substring(0, atIndex + 10); // +10 to include "@gmail.com"
    }
  }
}
</script>


            <div class="col-12 col-md-4 mb-3">
  <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
  <input type="text" class="form-control" name="contactNumber" id="contactNumber" placeholder="Enter contact number here" minlength="11" maxlength="11" required pattern="^09\d{9}$" 
    oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long without spaces')"
    oninput="this.setCustomValidity(''); if (!/^\d*$/.test(this.value)) this.value = ''; this.value = this.value.replace(/\s/g, '')"
    onkeypress="return /[0-9]/i.test(event.key) && (this.value.length < 2 || /^09/.test(this.value))"
  />
  <div class="invalid-feedback">
    Please enter a valid contact number starting with 09 and exactly 11 digits long without spaces.
  </div>
</div>
            <div class="col-12 col-md-6 mb-3">
              <label for="controlNumber" class="form-label">Control Number <span>*</span></label>
              <input type="text" class="form-control" name="controlNumber" id="controlNumber" placeholder="Enter control number here." pattern="\d{2}-\d{4}" title="" maxlength="7" minlength="7" required oninvalid="this.setCustomValidity('Please enter the code in the format 01-0001')" oninput="handleInput(event); this.value = this.value.replace(/[^0-9\- ]/g, '')" />
              <div class="invalid-feedback">
                Please enter a valid control number.
              </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="validity" class="form-label">Validity Date <span>*</span></label>
              <input type="date" class="form-control" name="validity" id="validity" placeholder="Enter membership validity here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" />
              <div class="invalid-feedback">
                Please enter a valid birthdate.
              </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="password" class="form-label">Password <span>*</span></label>
              <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password here" required oninput="checkPasswordStrength(this.value)" />
                <button class="btn btn-secondary eye-toggle" type="button" id="password-toggle-1">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
              <div id="password-strength-indicator"></div>
            </div>

            <div class="col-12 col-md-6 mb-5">
              <label for="confirmPassword" class="form-label">Confirm Password <span>*</span></label>
              <div class="input-group">
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Re-enter password here" required />
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
          </div>

        </form>
          <!-- Buttons section -->
          <div class="row justify-content-end">
            <div class="col-12 col-md-2 mb-3 mb-md-0">
              <!-- <button type="button" class="btn btn-primary w-100 create-button" name="submitAdmin" type="submit" data-bs-target="#confirm-add-new-member-modal" data-bs-toggle="modal">Create</button> -->
              <button class="btn btn-primary w-100 create-button" name="submitMember" id="submitMember" data-bs-target="#confirm-add-new-member-modal" data-bs-toggle="modal">Create</button>
            </div>
            <div class="col-12 col-md-2">
          <button type="button" class="btn btn-outline-primary w-100 cancel-button" type="reset" onclick="resetForm()">Cancel</button>
        </div>
        

      </div>

      </div>
    </section>



    <!-- Modals -->
    <!-- Confirmation Add Service Modal -->
    <div class="modal fade" id="confirm-add-new-member-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" id="add-new-service-modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="wait"><img src="src/images/icons/hourglass.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
            <h6 class="mt-2 mb-0 pb-0">Here's what we received:</h6>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="confirm-add-new-member-modal-button" class="btn btn-primary create-button" data-bs-target="#success-add-member-modal" data-bs-toggle="modal">Confirm</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Success Add New Service Modal -->
    <div class="modal fade" id="success-add-member-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="success"><img src="src/images/icons/available-worldwide.gif" alt="Wait Icon" class="modal-icons">Success!</h2>
          </div>
          <div class="modal-body">
            You have successfully registered a new account.
          </div>
          <div class="modal-footer">
            <a href="member-profiles.php" class="btn btn-primary create-button" id="proceed">Proceed</a>
          </div>
        </div>
      </div>
    </div>






        <!-- For trimming whitespacecs -->
        <script>
      function handleInput(event) {
        const inputValue = event.target.value.trim(); // Remove leading and trailing whitespaces
        const lastChar = inputValue.slice(-1); // Get the last character of the input

        // Check if the input is only whitespaces and it's not the last character
        if (inputValue === '' || (inputValue === ' ' && lastChar !== ' ')) {
          event.target.value = ''; // Clear the input if it's only whitespaces
        }
      }
    </script>


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

        passwordInput.addEventListener("input", function() {
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

    <!-- For Birthdate -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var birthDateInput = document.getElementById('birthDate');

        // Set min and max date for birthdate input
        var currentDate = new Date();
        var minDate = new Date('1900-01-01');
        var maxDate = new Date(currentDate);
        maxDate.setFullYear(currentDate.getFullYear() - 18); // 18 years ago from current year

        birthDateInput.min = minDate.toISOString().split('T')[0]; // Minimum date is 1900-01-01
        birthDateInput.max = maxDate.toISOString().split('T')[0]; // Maximum date is 18 years ago

        birthDateInput.addEventListener('input', function() {
          var selectedDate = new Date(this.value);

          if (selectedDate < minDate || selectedDate > maxDate) {
            this.setCustomValidity('Please enter a valid birthdate (minimum 1900 and at least 18 years ago).');
          } else {
            this.setCustomValidity('');
          }
        });
      });
    </script>

    <!-- For Validity Date -->
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const validityInput = document.querySelector("#validity");

        // Get today's date
        const today = new Date();
        const year = today.getFullYear();
        const month = today.getMonth() + 1; // Month is zero-indexed
        const day = today.getDate();

        // Set the minimum date to today's date
        const minDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
        validityInput.setAttribute("min", minDate);

        // Set the maximum date to 1 year from today's date
        const maxDate = new Date(today.getTime() + (365 * 24 * 60 * 60 * 1000));
        const maxYear = maxDate.getFullYear();
        const maxMonth = maxDate.getMonth() + 1; // Month is zero-indexed
        const maxDay = maxDate.getDate();
        const maxDateString = `${maxYear}-${maxMonth.toString().padStart(2, '0')}-${maxDay.toString().padStart(2, '0')}`;
        validityInput.setAttribute("max", maxDateString);
      });
    </script>

<script>
      //add admin
      $(document).ready(function() {
        $('#confirm-add-new-member-modal-button').click(function(e) {
          e.preventDefault(); 

          var formData = new FormData($('#add-new-profile-form')[0]);

          $.ajax({
            type: 'POST',
            url: 'member_crud.php', // Replace 'process_form.php' with the URL of your PHP script
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              // Handle success response here
              //alert(response); // For demonstration purposes, you can display an alert with the response
              //location.reload();
              $('#success-add-member-modal').modal('show');
            },
            error: function(xhr, status, error) {
              // Handle error
              console.error(xhr.responseText);
            }
          });
        });
      });
    </script>





    <!-- SPassword Strength Indicator -->
    <script>
      function checkPasswordStrength(password) {
        var strength = document.getElementById('password-strength-indicator');
        var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})");
        var mediumRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})");

        if (strongRegex.test(password)) {
          strength.innerHTML = '<span style="color:green">Strong password</span>';
        } else if (mediumRegex.test(password)) {
          strength.innerHTML = '<span style="color:orange">Moderate password</span>';
        } else {
          strength.innerHTML = '<span style="color:red">Weak password</span>';
        }
      }
    </script>




  </body>

  </html>
<?php  } else {
  header("location:login.php");
} ?>