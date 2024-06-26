<?php
include "connect_database.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";
include "src/get_data_from_database/get_shifts.php";
include "src/get_data_from_database/get_admin_accounts.php";
include "src/get_data_from_database/get_admin_info.php";

session_start();
date_default_timezone_set('Asia/Manila');

 // Initialize variables with default values
 $ID = $adminID = $adminInfoID = $adminUsername = $adminName = $adminSex = $adminPhone = $adminEmail = $shiftTimeStart = $shiftTimeEnd = "";
  

if (isset($_SESSION["userSuperAdminID"])) {
  $superAdminID = $_SESSION["userSuperAdminID"];
  $ID = isset($_GET['value']) ? $_GET['value'] : ' ';
  
  foreach($arrayAdminAccount as $adminAccount){ 
  //if(isset($_GET['edit-admin-val'])){//if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Retrieve the value of 'passID'
    
      if($adminAccount['adminInfoID'] == $ID){
          // Populate variables with data from $adminAccount array
          $adminID = $adminAccount['adminID'];
          $adminInfoID = $adminAccount['adminInfoID'];
          $adminUsername = decryptData($adminAccount['adminUsername'], $key);
          $adminFirstName = decryptData($adminAccount['adminFirstName'], $key);
          $adminMiddleName = decryptData($adminAccount['adminMiddleName'], $key);
          $adminLastName = decryptData($adminAccount['adminLastName'], $key);
          $adminSex = decryptData($adminAccount['adminSex'], $key);
          $adminPhone = decryptData($adminAccount['adminContactNumber'], $key);
          $adminEmail = decryptData($adminAccount['adminEmail'], $key);
          $shiftTimeStart = $adminAccount['shiftTimeStart'];
          $shiftTimeEnd = $adminAccount['shiftTimeEnd'];
          $adminShift = $adminAccount['adminShiftID'];
      }// else {
          // Handle the case where $_POST['passID'] does not match
          // For example, you could return an error response or set variables to default values
      //}
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
    <link rel="stylesheet" href="src/css/sidebar.css" />
    <link rel="stylesheet" href="src/css/style.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
  </head>

  <body>
    <?php include "superadmin_sidebar.php"; ?>

    <section class="home-section">
      <h4 class="qreserve mt-5">Edit Admin Account</h4>
      <hr class="my-4">
      <div class="container-fluid" id="profmanage-add-new-profile">
        <form class="needs-validation dashboard-square-kebab" id="edit-admin-form" novalidate>
          <div class="row">
            <div class="col-12 col-md-3 mb-3">
              <!--<input name="adminID" id="adminID" value="">-->
              <label for="firstName" class="form-label">First Name <span>*</span></label>
              <input type="text" value="<?php echo $adminFirstName;?>" class="form-control" name="FirstName" id="FirstName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="handleInput(event); this.value = this.value.replace(/[^A-Za-z\- ]/g, '')" />
              <div class="invalid-feedback">
                Please enter a valid first name.
              </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
              <label for="middleName" class="form-label">Middle Name</label>
              <input type="text" value="<?php echo $adminMiddleName;?>" class="form-control" name="middleName" id="middleName" placeholder="Enter middle name here" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid middle name')" oninput="handleInput(event); this.value = this.value.replace(/[^A-Za-z\- ]/g, '')" />
              <!-- <div class="valid-feedback">
                      Looks good!
                  </div> -->
              <div class="invalid-feedback">
                Please enter a valid middle name.
              </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
              <label for="lastName" class="form-label">Last Name <span>*</span></label>
              <input type="text" value="<?php echo $adminLastName;?>" class="form-control" name="lastName" id="lastName" placeholder="Enter last name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid last name')" oninput="handleInput(event); this.value = this.value.replace(/[^A-Za-z\- ]/g, '')" />
              <!-- <div class="valid-feedback">
                      Looks good!
                  </div> -->
              <div class="invalid-feedback">
                Please enter a valid last name.
              </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
              <label for="contactNumber" class="form-label">Username <span>*</span></label>
              <input type="text" value="<?php echo $adminUsername;?>" class="form-control" name="username" id="username" placeholder="Enter last name here" required maxlength="50" oninput="this.setCustomValidity(''); this.value = this.value.replace(/\s/g, '')" />
              <!-- <div class="valid-feedback">
                      Looks good!
                  </div> -->
              <div class="invalid-feedback">
                Please enter a valid username.
              </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
              <label for="adminSex" class="form-label">Sex <span>*</span></label>
              <select class="form-control" name="adminSex" id="adminSex" required onchange="this.setCustomValidity('')">
                <option value="" selected disabled>Select Sex</option>
                <option value="Male" <?php if($adminSex == 'Male') echo 'selected';?>>Male</option>
                <option value="Female" <?php if($adminSex == 'Female') echo 'selected';?>>Female</option>
                <option value="Others" <?php if($adminSex == 'Others') echo 'selected';?>>Others</option>
              </select>
              <div class="invalid-feedback">
                Please select a shift.
              </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
              <label for="email" class="form-label">Email Address <span>*</span></label>
              <input type="email" value="<?php echo $adminEmail;?>" class="form-control" name="email" id="email" placeholder="Enter email address here" required oninvalid="this.setCustomValidity('Please enter a valid email address without spaces')" oninput="this.setCustomValidity(''); this.value = this.value.replace(/\s/g, '')" />
              <div class="invalid-feedback">
                Please enter a valid Gmail address (e.g., yourname@gmail.com).
              </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
              <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
              <input type="text" value="<?php echo $adminPhone;?>" class="form-control" name="contactNumber" id="contactNumber" placeholder="Enter contact number here" minlength="11" maxlength="11" required pattern="^09\d{9}$" oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long without spaces')" oninput="this.setCustomValidity(''); if (!/^\d*$/.test(this.value)) this.value = ''; this.value = this.value.replace(/\s/g, '')" />
              <div class="invalid-feedback">
                Please enter a valid contact number.
              </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
              <label for="adminShift" class="form-label">Shift <span>*</span></label>
              <select class="form-control" name="adminShift" id="adminShift" required onchange="this.setCustomValidity('')">
                <option value="" selected disabled>Select shift</option>
                <?php // get the shifts in the db so that select shift will be dynamic in case shifts are edited
                foreach ($arrayShifts as $shift) {
                  $tempShiftStart = explode(":", $shift['shiftTimeStart']);
                  $tempShiftEnd = explode(":", $shift['shiftTimeEnd']);
                  //convert tempShift variables to integers
                  $shiftStartHour = intval($tempShiftStart[0]);
                  $shiftEndHour = intval($tempShiftEnd[0]);

                  if ($shiftStartHour >= 13) {
                    $shiftStart = ($shiftStartHour - 12) . ":" . $tempShiftStart[1] . " PM";
                  } else {
                    $shiftStart = $shiftStartHour . ":" . $tempShiftStart[1] . " AM";
                  }

                  if ($shiftEndHour >= 13) {
                    $shiftEnd = ($shiftEndHour - 12) . ":" . $tempShiftEnd[1] . " PM";
                  } else {
                    $shiftEnd = $shiftEndHour . ":" . $tempShiftEnd[1] . " AM";
                  } ?>
                  <option value="<?php echo $shift['adminShiftID']; ?>" <?php if($adminShift == $shift['adminShiftID']) echo 'selected'?>><?php echo $shiftStart . " - " . $shiftEnd; ?></option>
                <?php } ?>
              </select>
              <div class="invalid-feedback">
                Please select a shift.
              </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="password" class="form-label">Password <span>*</span></label>
              <div class="input-group">
                <input type="password"  class="form-control" name="password" id="password" placeholder="Enter password here" required />
                <button class="btn btn-secondary eye-toggle" type="button" id="password-toggle-1">
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
                <button class="btn btn-secondary eye-toggle" type="button" id="password-toggle-2">
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
              <input type="hidden" id="updateAdmin" name="updateAdmin" value="<?php echo $ID;?>">
              <button class="btn btn-primary w-100 create-button" name="submitAdmin" id="submitAdmin" type="submit">Create</button>
            </div>
            <div class="col-12 col-md-2">
              <!-- <button class="btn btn-outline-primary w-100 cancel-button" type="reset" onclick="resetForm()">Cancel</button> -->
              <a href="admin-profiles.php" class="btn btn-outline-primary w-100 cancel-button">Cancel</a>
            </div>
          </div>



        </form>

      </div>
    </section>

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
      });
    </script>

<!--set default value for password field in case if super admin does not want to edit password-->
<script>
        document.addEventListener("DOMContentLoaded", () => {
            const passwordField = document.getElementById("password");
            const confirmPasswordField = document.getElementById("confirmPassword");
            const defaultValue = ".";

            
            // Ensure the default value is set when the page loads
            passwordField.value = defaultValue;
            confirmPasswordField.value = defaultValue;

            // Event listener to check if the input is empty
            passwordField.addEventListener("change", () => {
                if (passwordField.value.trim() === "" && confirmPasswordField.value.trim() === ".") {
                  passwordField.value = defaultValue;
                  passwordMatchFeedback.innerHTML = "";
                  passwordMatch.style.display = "block";
                  passwordMismatch.style.display = "none";
                  
                }
                else if (passwordField.value.trim() !== "" && confirmPasswordField.value.trim() === ".") {
                  //passwordField.value = defaultValue;
                  passwordMatchFeedback.innerHTML = "";
                  passwordMatch.style.display = "none";
                  passwordMismatch.style.display = "block";
                  
                }
                else if (passwordField.value.trim() === "" && confirmPasswordField.value.trim() === "") {
                  passwordField.value = defaultValue;
                  passwordMatchFeedback.innerHTML = "";
                  passwordMatch.style.display = "block";
                  passwordMismatch.style.display = "none";
                  
                }
                else if (passwordField.value.trim() === "" && confirmPasswordField.value.trim() !== "") {
                  passwordField.value = defaultValue;
                  passwordMatchFeedback.innerHTML = "";
                  passwordMatch.style.display = "none";
                  passwordMismatch.style.display = "block";
                  
                }
            });

            confirmPasswordField.addEventListener("change", () => {
              if (passwordField.value.trim() === "." && confirmPasswordField.value.trim() === "") {
                  confirmPasswordField.value = defaultValue;
                  passwordMatchFeedback.innerHTML = "";
                  passwordMatch.style.display = "block";
                  passwordMismatch.style.display = "none";
                  
                }
                else if (passwordField.value.trim() === "" && confirmPasswordField.value.trim() !== ".") {
                  //passwordField.value = defaultValue;
                  passwordMatchFeedback.innerHTML = "";
                  passwordMatch.style.display = "none";
                  passwordMismatch.style.display = "block";
                  
                }
                else if (passwordField.value.trim() === "" && confirmPasswordField.value.trim() === "") {
                  confirmPasswordField.value = defaultValue;
                  passwordMatchFeedback.innerHTML = "";
                  passwordMatch.style.display = "block";
                  passwordMismatch.style.display = "none";
                  
                }
                else if (passwordField.value.trim() !== "" && confirmPasswordField.value.trim() === "") {
                  confirmPasswordField.value = defaultValue;
                  passwordMatchFeedback.innerHTML = "";
                  passwordMatch.style.display = "none";
                  passwordMismatch.style.display = "block";
                  
                }
            });
        });
</script>

<script>
    //edit admin
    $(document).ready(function(){
        $('#submitAdmin').click(function(e){
            e.preventDefault();

            var formData = new FormData($('#edit-admin-form')[0]);

            $.ajax({
                type: 'POST',
                url: 'admin_crud.php', // Replace 'process_form.php' with the URL of your PHP script
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    // Handle success response here
                    //alert(response); // For demonstration purposes, you can display an alert with the response
                    location.reload();
                  },
                error: function(xhr, status, error){
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>


  </body>

  </html>
<?php  } else {
  header("location:login.php");
} ?>