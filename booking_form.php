<?php
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION['userMemberID'])) {
    $userID = $_SESSION['userMemberID'];
    include "connect_database.php";
    include "src/get_data_from_database/get_member_account.php";
    include "src/get_data_from_database/get_customer_information.php";
    include "encodeDecode.php";
    $key = "TheGreatestNumberIs73";

    foreach ($arrayMemberAccount as $memberAccount) {
        if ($memberAccount["memberID"] == $userID) {
            $memberControlNumber = $memberAccount['membershipID'];
            $membershipValidity = $memberAccount['validityDate'];
            $customerID = $memberAccount['customerID'];
            foreach ($arrayCustomerInformation as $customerInformation) {
                if ($customerInformation["customerID"] == $customerID) {
                    $customerFirstName = decryptData($customerInformation['customerFirstName'], $key);
                    $customerLastName = decryptData($customerInformation['customerLastName'], $key);
                    $customerMiddleName = decryptData($customerInformation['customerMiddleName'], $key);
                    $customerBirthdate = decryptData($customerInformation['customerBirthdate'], $key);
                    $customerNumber = decryptData($customerInformation['customerNumber'], $key);
                    $customerEmail = decryptData($customerInformation['customerEmail'], $key);
                }
            }
        }
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>Book a Reservation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="src/css/style.css">
        <link rel="stylesheet" href="src/css/landing.css">

        <!-- Fontawesome Link for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


        <!-- Montserrat Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

        <!-- jQuery -->
        <script src="src/js/jquery-3.7.1.js"></script>
        <!-- Datatables JS -->
        <script src="src/js/jquery.dataTables.min.js"></script>
        <script src="src/js/dataTables.bootstrap5.min.js"></script>

        <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
    </head>

    <body class="body">
        <?php include "customer_header.php";
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="qreserve mt-5 mb-0">QReserve</h1>
                    <h6 id="booking-sub">BEVITORE SANTA ROSA</h6>
                    <hr class="my-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="fw-bold ps-4">Fill up the form</h3>
                    <form class="needs-validation dashboard-square-kebab" id="booking-form" novalidate>
                        <div class="row">
                            <div class="col-12 col-md-4 mb-3">
                                <label for="firstName" class="form-label">First Name <span>*</span></label>
                                <!-- <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')" value="<?php echo $customerFirstName; ?>" /> -->
                                <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name here" readonly value="<?php echo $customerFirstName; ?>" />
                                <input type="hidden" name="hiddenFirstName" id="hiddenFirstName" value="<?php echo $customerFirstName; ?>" />
                                <div class="invalid-feedback">
                                    Please enter a valid first name.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <!-- <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Enter middle name here" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid middle name')" oninput="this.setCustomValidity('')" value="<?php echo $customerMiddleName; ?>" /> -->
                                <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Enter middle name here" readonly value="<?php echo $customerMiddleName; ?>" />
                                <input type="hidden" name="hiddenMiddleName" id="hiddenMiddleName" value="<?php echo $customerMiddleName; ?>" />
                                <div class="invalid-feedback">
                                    Please enter a valid middle name.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="lastName" class="form-label">Last Name <span>*</span></label>
                                <!-- <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter last name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid last name')" oninput="this.setCustomValidity('')" value="<?php echo $customerLastName; ?>" /> -->
                                <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter last name here" readonly value="<?php echo $customerLastName; ?>" />
                                <input type="hidden" name="hiddenLastName" id="hiddenLastName" value="<?php echo $customerLastName; ?>" />
                                <div class="invalid-feedback">
                                    Please enter a valid last name.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="birthDate" class="form-label">Birthday<span>*</span></label>
                                <!-- <input type="date" class="form-control" name="birthDate" id="birthDate" placeholder="Enter birthdate name here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" value="<?php echo $customerBirthdate; ?>" /> -->
                                <input type="date" class="form-control" name="birthDate" id="birthDate" placeholder="Enter birthdate name here" readonly value="<?php echo $customerBirthdate; ?>" />
                                <input type="hidden" name="hiddenBirthDate" id="hiddenBirthDate" value="<?php echo $customerBirthdate; ?>" />

                                <div class="invalid-feedback">
                                    Please enter a valid birthdate.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
                                <!-- <input type="text" class="form-control" name="contactNumber" id="contactNumber" placeholder="Enter contact number here" required pattern="^09\d{9}$" minlength="11" maxlength="11" oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long')" oninput="this.setCustomValidity('')" value="<?php echo $customerNumber; ?>" /> -->
                                <input type="text" class="form-control" name="contactNumber" id="contactNumber" placeholder="Enter contact number here" readonly value="<?php echo $customerNumber; ?>" />
                                <input type="hidden" name="hiddenContactNumber" id="hiddenContactNumber" value="<?php echo $customerNumber; ?>" />

                                <div class="invalid-feedback">
                                    Please enter a valid contact number.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="email" class="form-label">Email Address <span>*</span></label>
                                <!-- <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address here" required oninvalid="this.setCustomValidity('Please enter a valid email address')" oninput="this.setCustomValidity('')" value="<?php echo $customerEmail; ?>" /> -->
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address here" readonly value="<?php echo $customerEmail; ?>" />
                                <input type="hidden" name="hiddenEmail" id="hiddenEmail" value="<?php echo $customerEmail; ?>" />
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="validity" class="form-label">Select Date <span>*</span></label>
                                <input type="date" class="form-control" name="selectDate" id="selectDate" placeholder="Enter membership validity here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" value="<?php echo $customerValidity; ?>" min="<?php echo date('Y-m-d'); ?>" />
                                <div class="invalid-feedback">
                                    Please select a date.
                                </div>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
    <label for="selectStartTime" class="form-label">Start Time <span>*</span></label>
    <input type="time" class="form-control" name="selectStartTime" id="selectStartTime" required onchange="updateEndTime()" />
    <div class="invalid-feedback">
        Please select a start time.
    </div>
</div>
<div class="col-12 col-md-3 mb-3">
    <label for="selectEndTime" class="form-label">End Time <span>*</span></label>
    <input type="time" class="form-control" name="selectEndTime" id="selectEndTime" required />
    <div class="invalid-feedback">
        Please select an end time at least 2 hours after the start time.
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const startTimeInput = document.getElementById("selectStartTime");
    const endTimeInput = document.getElementById("selectEndTime");

    startTimeInput.addEventListener("change", function () {
        const startTime = new Date(`2024-06-14T${this.value}`);
        const minEndTime = new Date(startTime.getTime() + 2 * 60 * 60 * 1000); // Add 2 hours

        const minEndTimeFormatted = minEndTime.toTimeString().slice(0, 5);
        endTimeInput.min = minEndTimeFormatted;
        endTimeInput.value = minEndTimeFormatted; // Set the end time to the minimum allowed

        calculatePrice();
    });

    endTimeInput.addEventListener("change", function () {
        if (this.value < startTimeInput.value) {
            this.setCustomValidity("End time must be at least 2 hours after the start time.");
        } else {
            this.setCustomValidity("");
        }

        calculatePrice();
    });

    function calculatePrice() {
        const startTime = new Date(`2024-06-14T${startTimeInput.value}`);
        const endTime = new Date(`2024-06-14T${endTimeInput.value}`);
        const durationInMinutes = (endTime - startTime) / (1000 * 60);
        const durationInHours = durationInMinutes / 60;

        const basePrice = 300; // Base price in pesos
        const extraCostPerHalfHour = 75; // Extra cost per 30 minutes in pesos

        let totalPrice = basePrice;

        if (durationInHours > 2) {
            const extraHalfHours = Math.ceil((durationInMinutes - 2 * 60) / 30); // Calculate extra 30-minute intervals beyond 2 hours
            totalPrice += extraHalfHours * extraCostPerHalfHour;
        }

        // Format the price as PHP currency
        const formattedPrice = new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(totalPrice);

        document.getElementById('total').textContent = formattedPrice; // Update total price in the modal
    }
});


</script>



                            <!-- <div class="col-12 col-md-3 mb-3">
                                <label for="selectStartTime" class="form-label">Start Time <span>*</span></label>
                                <select class="form-control" name="selectStartTime" id="selectStartTime" required onchange="updateEndTime()">
                                    <option value="" selected disabled>Select start time</option>
                                    <option value="10:00:00">10:00am</option>
                                    <option value="11:00:00">11:00am</option>
                                    <option value="12:00:00">12:00 noon</option>
                                    <option value="13:00:00">1:00pm</option>
                                    <option value="14:00:00">2:00pm</option>
                                    <option value="15:00:00">3:00pm</option>
                                    <option value="16:00:00">4:00pm</option>
                                    <option value="17:00:00">5:00pm</option>
                                    <option value="18:00:00">6:00pm</option>
                                    <option value="19:00:00">7:00pm</option>
                                    <option value="20:00:00">8:00pm</option>
                                    <option value="21:00:00">9:00pm</option>
                                    <option value="22:00:00">10:00pm</option>
                                    <option value="23:00:00">11:00pm</option>
                                    <option value="00:00:00">12:00 midnight</option>
                                    <option value="1:00:00">1:00am</option>
                                    <option value="2:00:00">2:00am</option>
                                    <option value="3:00:00">3:00am</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a start time.
                                </div>
                            </div> -->
                            <!-- <div class="col-12 col-md-3 mb-3">
                                <label for="selectEndTime" class="form-label">End Time <span>*</span></label>
                                <select class="form-control" name="selectEndTime" id="selectEndTime" required>
                                    <option value="" selected disabled>Select end time</option>
                                    <!-- Options will be dynamically added based on selected start time 
                                </select>
                                <div class="invalid-feedback">
                                    Please select an end time.
                                </div>
                            </div> -->
                            <div class="col-12 col-md-3 mb-3">
                                <label for="selectTable" class="form-label">Select Table <span>*</span></label>
                                <select class="form-control" name="selectTable" id="selectTable" required>
                                    <!-- Options will be dynamically added based on selected start time onchange="this.setCustomValidity('')"-->
                                </select>
                                <div class="invalid-feedback">
                                    Please select a table.
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-3 mb-4">
                                <h6 class="mb-0 pb-0">Bevitore 2D Map</h6>
                                <img src="src/images/map.png" alt="" style="width: 100%; height: 100%;">
                            </div>
                        </div>
                        <div class="row justify-content-end mt-5">
                            <div class="col-12 col-md-2 mb-3 mb-md-0">
                                <button type="button" class="btn btn-primary w-100 create-button" data-bs-toggle="modal" data-bs-target="#confirm-add-walkin-modal" id="create-reservation-button">Create</button>
                            </div>
                            <div class="col-12 col-md-2">
                                <button class="btn btn-outline-primary w-100 cancel-button" id="member-cancel" type="reset" onclick="resetForm()">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Confirmation Add Service Modal -->
            <div class="modal fade" id="confirm-add-walkin-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" id="add-new-service-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title fw-bold text-center" id="wait"><img src="src/images/icons/hourglass.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
                            <h6 class="mt-2 mb-0 pb-0">Here's what we received:</h6>
                        </div>
                        <div class="modal-body">
                            <!-- The content will be dynamically generated here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary cancel-button" id="member-cancel" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary create-button" data-bs-toggle="modal" data-bs-target="#success-add-walkin-modal" id="success-reservation-button">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Success Add New Service Modal -->
            <div class="modal fade" id="success-add-walkin-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" id="wait">
                        <div class="modal-header">
                            <h2 class="modal-title  fw-bold text-center" id="success"><img src="src/images/icons/file.gif" alt="Pending Icon" class="modal-icons">Pending...</h2>
                        </div>
                        <div class="modal-body text-center">
                            <p class="fw-bold mb-0 pb-0">Your booking is now on process!</p>
                            Please check your email for the details of your reservation.
                            <div class="mt-3">
                                <p class="he">Proceed to pay your reservation through the provided Payment Details<br></p>

                                <p class="gcash mb-3">GCash: 09123456789</p>
                                Send your proof of payment to <a href="https://www.facebook.com/Bevitore.Sta.Rosa">Bevitore’s Facebook Page.</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button class="btn btn-primary create-button" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button> -->
                            <button class="btn btn-primary  create-button" name="submitReserve" id="submitReserve" type="submit">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div id="updateTable" style="display:none;"><!--this div's only purpose is to help table update--></div>
        <script src="src/js/booking_form.js"></script>

    </body>

    </html>
<?php
} else {
    header('location:customer_login.php');
    exit();
}
?>