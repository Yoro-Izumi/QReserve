<?php
session_start();
if (isset($_SESSION['userMemberID'])) {
    $userID = $_SESSION['userMemberID'];
    include "connect_database.php";
    include "get_data_from_database/get_member_account.php";
    include "get_data_from_database/get_customer_information.php";
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
                    $customerBirthdate = $customerInformation['customerBirthdate'];
                    $customerNumber = decryptData($customerInformation['customerNumber'], $key);
                    $customerEmail = decryptData($customerInformation['customerEmail'], $key);
                }
            }
        }
    }
    include "submit_customer_reservation.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>Book a Reservation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/landing.css">

        <!-- Fontawesome Link for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


        <!-- Montserrat Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    </head>

    <body class="body">
        <header>
            <nav class="navbar p-0">
                <img src="./images/Bevitore-logo.png" id="customer-landing-logo" />
                <input type="checkbox" id="menu-toggler">
                <label for="menu-toggler" id="hamburger-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24px" height="24px">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 18h18v-2H3v2zm0-5h18V11H3v2zm0-7v2h18V6H3z" />
                    </svg>
                </label>
                <ul class="all-links">
                    <li><a href="customer_dashboard.php">Home</a></li>
                    <li><a href="customer_account.php">Account</a></li>
                    <li><a href="customer_logout.php">Log Out</a></li>
                </ul>
            </nav>
        </header>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="krona-one-regular mt-5 mb-0">QReserve</h1>
                    <h6 id="booking-sub">BEVITORE SANTA ROSA</h6>
                    <hr class="my-4">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="fw-bold ps-4">Fill up the form</h3>
                    <form class="needs-validation dashboard-square-kebab" id="booking-form" novalidate action="booking_form.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-3">
                                <label for="firstName" class="form-label">First Name <span>*</span></label>
                                <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')" value="<?php echo $customerFirstName; ?>" />
                                <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                                <div class="invalid-feedback">
                                    Please enter a valid first name.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Enter middle name here" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid middle name')" oninput="this.setCustomValidity('')" value="<?php echo $customerMiddleName; ?>" />
                                <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                                <div class="invalid-feedback">
                                    Please enter a valid middle name.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="lastName" class="form-label">Last Name <span>*</span></label>
                                <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter last name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid last name')" oninput="this.setCustomValidity('')" value="<?php echo $customerLastName; ?>" />
                                <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                                <div class="invalid-feedback">
                                    Please enter a valid last name.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="birthDate" class="form-label">Birthday<span>*</span></label>
                                <input type="date" class="form-control" name="birthDate" id="birthDate" placeholder="Enter birthdate name here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" value="<?php echo $customerBirthdate ?>;" />
                                <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                                <div class="invalid-feedback">
                                    Please enter a valid birthdate.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
                                <input type="text" class="form-control" name="contactNumber" id="contactNumber" placeholder="Enter contact number here" required pattern="^09\d{9}$" minlength="11" maxlength="11" oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long')" oninput="this.setCustomValidity('')" value="<?php echo $customerNumber; ?>" />
                                <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                                <div class="invalid-feedback">
                                    Please enter a valid contact number.
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="email" class="form-label">Email Address <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address here" required oninvalid="this.setCustomValidity('Please enter a valid email address')" oninput="this.setCustomValidity('')" value="<?php echo $customerEmail; ?>" />
                                <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="validity" class="form-label">Validity Date <span>*</span></label>
                                <input type="date" class="form-control" name="validity" id="validity" placeholder="Enter membership validity here" required oninvalid="this.setCustomValidity('Please enter a valid birthdate')" oninput="this.setCustomValidity('')" value="<?php echo $customerValidity; ?>" />
                                <div class="invalid-feedback">
                                    Please enter a valid birthdate.
                                </div>
                            </div>

                            <!-- <div class="col-12 col-md-3 mb-3">
                            <label for="selectStartTime" class="form-label">Start Time <span>*</span></label>
                            <select class="form-control" name="selectStartTime" id="selectStartTime" required>
                                <option value="" selected disabled>Select table</option>
                                <option value="10:00am">10:00am</option>
                                <option value="11:00am">11:00am</option>
                                <option value="12:00 noon">12:00 noon</option>
                                <option value="1:00pm">1:00pm</option>
                                <option value="2:00pm">2:00pm</option>
                                <option value="3:00pm">3:00pm</option>
                                <option value="4:00pm">4:00pm</option>
                                <option value="5:00pm">5:00pm</option>
                                <option value="6:00pm">6:00pm</option>
                                <option value="7:00pm">7:00pm</option>
                                <option value="8:00pm">8:00pm</option>
                                <option value="9:00pm">9:00pm</option>
                                <option value="10:00pm">10:00pm</option>
                                <option value="11:00pm">11:00pm</option>
                                <option value="12:00 midnight">12:00 midnight</option>
                                <option value="1:00am">1:00am</option>
                                <option value="2:00am">2:00am</option>
                                <option value="3:00am">3:00am</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a start time.
                            </div>
                        </div>   -->
                            <div class="col-12 col-md-3 mb-3">
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
                            </div>

                            <div class="col-12 col-md-3 mb-3">
                                <label for="selectEndTime" class="form-label">End Time <span>*</span></label>
                                <select class="form-control" name="selectEndTime" id="selectEndTime" required>
                                    <option value="" selected disabled>Select end time</option>
                                    <!-- Options will be dynamically added based on selected start time -->
                                </select>
                                <div class="invalid-feedback">
                                    Please select an end time.
                                </div>
                            </div>

                            <script>
                                const endTimesMap = {
                                    "10:00:00": ["12:00nn", "1:00pm", "2:00pm", "3:00pm", "4:00pm", "5:00pm", "6:00pm", "7:00pm", "8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "11:00:00": ["1:00pm", "2:00pm", "3:00pm", "4:00pm", "5:00pm", "6:00pm", "7:00pm", "8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "12:00:00": ["2:00pm", "3:00pm", "4:00pm", "5:00pm", "6:00pm", "7:00pm", "8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "13:00:00": ["3:00pm", "4:00pm", "5:00pm", "6:00pm", "7:00pm", "8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "14:00:00": ["4:00pm", "5:00pm", "6:00pm", "7:00pm", "8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am", "4:00am", "5:00am"],
                                    "15:00:00": ["5:00pm", "6:00pm", "7:00pm", "8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am", "4:00am", "5:00am"],
                                    "16:00:00": ["6:00pm", "7:00pm", "8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "17:00:00": ["7:00pm", "8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "18:00:00": ["8:00pm", "9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "19:00:00": ["9:00pm", "10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "20:00:00": ["10:00pm", "11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "21:00:00": ["11:00pm", "12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "22:00:00": ["12:00 midnight", "1:00am", "2:00am", "3:00am"],
                                    "23:00:00": ["1:00am", "2:00am", "3:00am"],
                                    "00:00:00": ["2:00am", "3:00am", "4:00am", "5:00am"],
                                    "1:00:00": ["3:00am", "4:00am", "5:00am"],
                                    "2:00:00": ["4:00am", "5:00am"],
                                };

                                function updateEndTime() {
                                    const startTimeSelect = document.getElementById("selectStartTime");
                                    const endTimeSelect = document.getElementById("selectEndTime");
                                    const selectedStartTime = startTimeSelect.value;

                                    // Clear previous options
                                    endTimeSelect.innerHTML = '<option value="" selected disabled>Select end time</option>';

                                    // Define available end times based on selected start time
                                    const endTimes = endTimesMap[selectedStartTime] || [];

                                    // Add options to select end time
                                    endTimes.forEach(function(time) {
                                        const option = document.createElement("option");

                                        var timeSplit = time.split(":"); // split hour from minutes
                                        if (timeSplit[1] == "00am" || timeSplit[1] == "00nn") {
                                            var actualTime = timeSplit[0] + ":00:00";
                                        } else if (timeSplit[1] == "00pm") {
                                            var actualTime = (12 + parseInt(timeSplit[0])) + ":00:00";
                                        } else {
                                            var actualTime = "00:00:00";
                                        }
                                        option.text = time;
                                        option.value = actualTime;
                                        endTimeSelect.add(option);
                                    });
                                }
                            </script>













                            <div class="col-12 col-md-3 mb-3">
                                <label for="selectTable" class="form-label">Select Table <span>*</span></label>
                                <select class="form-control" name="selectTable" id="selectTable" required onchange="this.setCustomValidity('')">
                                    <option value="" selected disabled>Select table</option>
                                    <option value="1">Table 1</option>
                                    <option value="2">Table 2</option>
                                    <option value="3">Table 3</option>
                                    <option value="4">Table 4</option>
                                    <option value="5">Table 5</option>
                                    <option value="6">Table 6</option>
                                    <option value="7">Table 7</option>
                                    <option value="8">Table 8</option>
                                    <option value="9">Table 9</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a table.
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-3 mb-4">
                                <h6 class="mb-0 pb-0">Bevitore 2D Map</h6>
                                <img src="./images/Seamless-Wavy-lines-Pattern-digital-Graphics-30696202-1.jpg" alt="" style="width: 100%; height: 100%;">
                            </div>
                        </div>
                            <div class="row justify-content-end mt-5">
                                <div class="col-12 col-md-2 mb-3 mb-md-0">
                                    <button class="btn btn-primary w-100 create-button" name="submitAdmin" type="submit">Create</button>
                                </div>
                    <div class="col-12 col-md-2">
                        <button class="btn btn-outline-primary w-100 cancel-button" type="reset" onclick="resetForm()">Cancel</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>

        <script>
            //For birthdate
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
            //For File Upload
            function validateImageUpload(input) {
                const file = input.files[0];
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if (file && allowedTypes.includes(file.type)) {
                    input.setCustomValidity('');
                } else {
                    input.setCustomValidity('Please select a valid image file (JPEG, PNG, or GIF).');
                }
            }
        </script>

        <script>
            //For Form Validation
            (function() {
                'use strict'

                var forms = document.querySelectorAll('.needs-validation')

                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>




        <script>
            // Reset the form
            function resetForm() {
                document.querySelector('form').reset();
                location.reload();
            }
        </script>
    </body>

    </html>
<?php
} else {
    header('location:customer_login.php');
    exit();
}
?>