<?php
session_start();
    if (isset($_SESSION["userMemberID"])){
        $userID = $_SESSION['userMemberID'];
        include "connect_database.php";
        include "get_data_from_database/get_member_account.php";
        include "get_data_from_database/get_customer_information.php";
        include "encodeDecode.php";
        $key = "TheGreatestNumberIs73";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/landing.css">

    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


    <!-- Montserrat Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  </head>
  <body class="body">
    <header>
        <nav class="navbar p-0">
        <img src="./images/Bevitore-logo.png" id="customer-landing-logo" />
        <input type="checkbox" id="menu-toggler">
        <label for="menu-toggler" id="hamburger-btn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
            <path d="M0 0h24v24H0z" fill="none"/>
            <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z"/>
          </svg>
        </label>
        <ul class="all-links">
            <li><a href="customer_dashboard.php">Home</a></li>
            <li><a href="customer_account.php">Account</a></li>
            <li><a href="#contact">Log Out</a></li>
        </ul>
      </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="krona-one-regular mt-5 pt-3 mb-0">QReserve</h1>
                <h6 id="booking-sub">BEVITORE SANTA ROSA</h6>
                <hr class="my-4">
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-12">
                <h3 class="fw-bold ps-4">My Account</h3>
                <form class="needs-validation dashboard-square-kebab" id="booking-form" novalidate action="submit_customer_reservation.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <?php
                            foreach($arrayMemberAccount as $memberAccount){
                                if($memberAccount["memberID"] == $userID){
                                  $customerID = $memberAccount['customerID'];
                                    foreach($arrayCustomerInformation as $customerInformation){
                                        if($customerInformation["customerID"] == $customerID){
                        ?>
                                                                    <div class="col-12 col-md-3 mb-3">
                                                                        <label for="firstName" class="form-label fw-bold">First Name: ao3xjh</label>
                                                                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')" value="<?php echo decryptData($customerInformation['customerFirstName'],$key);?>" readonlyt/>
                                                                    </div>
                                                                    <div class="col-12 col-md-3 mb-3">
                                                                        <label for="middleName" class="form-label">Middle Name</label>
                                                                        <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Enter middle name here" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid middle name')" oninput="this.setCustomValidity('')" value="<?php echo decryptData($customerInformation['customerMiddleName'],$key);?>"/>
                                                                    </div>
                                                                    <div class="col-12 col-md-3 mb-3">
                                                                        <label for="lastName" class="form-label">Last Name</label>
                                                                        <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter last name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid last name')" oninput="this.setCustomValidity('')" value="<?php echo decryptData($customerInformation['customerLastName'],$key);?>" />
                                                                    </div>
                                                                    <div class="col-12 col-md-3 mb-3">
                                                                        <label for="firstName" class="form-label">Control Number</label>
                                                                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')" />
                                                                    </div>
                                                                    <div class="col-12 col-md-4 mb-3">
                                                                        <label for="birthDate" class="form-label">Birthday<span>*</span></label>
                                                                        <input type="date" class="form-control" name="birthDate" id="birthDate" placeholder="Enter birthdate name here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" value = "<?php echo $customerInformation['customerBirthdate'];?>"/>

                                                                    </div>  
                                                                    <div class="col-12 col-md-4 mb-3">
                                                                        <label for="contactNumber" class="form-label">Contact Number</label>
                                                                        <input type="text" class="form-control" name="contactNumber" id="contactNumber" placeholder="Enter contact number here" required pattern="^09\d{9}$" minlength="11" maxlength="11" oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long')" oninput="this.setCustomValidity('')" value = "<?php echo decryptData($customerInformation['customerNumber'],$key);?>" />
                                                                    </div>                                                                
                                                                    <div class="col-12 col-md-4 mb-3">
                                                                        <label for="email" class="form-label">Email Address</label>
                                                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address here" required oninvalid="this.setCustomValidity('Please enter a valid email address')" oninput="this.setCustomValidity('')" value="<?php echo decryptData($customerInformation['customerEmail'],$key);?>" />
                                                                    </div>
                        <?php 
                                        }
                                    }
                                }
                            }                
                        ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
 }
 else{
   header('location:customer_login.php');
   exit();
 } 
 ?>