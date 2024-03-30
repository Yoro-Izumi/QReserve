<?php
include "connect_database.php";
include "get_data_from_database/get_pool_table_info.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Montserrat Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body id="booking-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="krona-one-regular mb-0">QReserve</h1>
                <h6 id="booking-sub">BEVITORE SANTA ROSA</h6>
                <hr class="my-4">
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-12" id="hello">
                <h3 class="fw-bold ps-4">Fill up the form</h3>
                <form class="needs-validation" id="booking-form" novalidate action="submit_customer_reservation.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <label for="firstName" class="form-label">First Name <span>*</span></label>
                            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')" />
                            <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                            <div class="invalid-feedback">
                                Please enter a valid first name.
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label for="middleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Enter middle name here" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid middle name')" oninput="this.setCustomValidity('')" />
                            <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                            <div class="invalid-feedback">
                                Please enter a valid middle name.
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label for="lastName" class="form-label">Last Name <span>*</span></label>
                            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter last name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid last name')" oninput="this.setCustomValidity('')" />
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
                            <label for="contactNumber" class="form-label">Contact Number <span>*</span></label>
                            <input type="text" class="form-control" name="contactNumber" id="contactNumber" placeholder="Enter contact number here" required pattern="^09\d{9}$" minlength="11" maxlength="11" oninvalid="this.setCustomValidity('Please enter a valid contact number starting with 09 and exactly 11 digits long')" oninput="this.setCustomValidity('')" />
                            <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                            <div class="invalid-feedback">
                                Please enter a valid contact number.
                            </div>
                        </div>                                                                
                        <div class="col-12 col-md-4 mb-3">
                            <label for="email" class="form-label">Email Address <span>*</span></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address here" required oninvalid="this.setCustomValidity('Please enter a valid email address')" oninput="this.setCustomValidity('')" />
                            <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <label for="selectDate" class="form-label">Select Date <span>*</span></label>
                            <input type="date" class="form-control" name="selectDate" id="selectDate" placeholder="" required oninvalid="this.setCustomValidity('Please enter a valid date within the next 30 days')" oninput="this.setCustomValidity('')" />
                            <!-- <div class="valid-feedback">
                                Looks good!
                            </div> -->
                            <div class="invalid-feedback">
                                Please enter a valid date within the next 30 days.
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <label for="startTime" class="form-label">Start Time <span>*</span></label>
                            <input type="time" class="form-control" name="startTime" id="startTime" placeholder="" required disabled />
                            <div class="invalid-feedback" id="timeRangeError">
                                Please enter a valid time range (end time must be after start time).
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <label for="endTime" class="form-label">End Time <span>*</span></label>
                            <input type="time" class="form-control" name="endTime" id="endTime" placeholder="" required disabled />
                            <input type="hidden" name="timeDifference" id="timeDifference" value="">
                            <div class="invalid-feedback" id="timeRangeError">
                                Please enter a valid time range (end time must be after start time).
                            </div>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <label for="selectTable" class="form-label">Select Table <span>*</span></label>
                            <select class="form-control" name="selectTable" id="selectTable" required onchange="this.setCustomValidity('')" disabled>
                                <option value="" selected disabled>Select table</option>
                                <?php foreach($arrayPoolTables as $dataPT){?>
                                <option value="<?php echo $dataPT['poolTableID'];?>"><?php echo $dataPT['poolTableNumber'];?></option>
                                <?php }?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a table.
                            </div>
                        </div>                                                                    
                        <div class="col-12 col-md-6 mb-3 mb-4">
                            <h6 class="mb-0 pb-0">Bevitore 2D Map</h6>
                            <img src="./images/Seamless-Wavy-lines-Pattern-digital-Graphics-30696202-1.jpg" alt="" style="width: 100%; height: 100%;">
                        </div>
                        <div class="col-12 col-md-12 mb-5">
                            <label for="validId" class="form-label">Valid ID <span>*</span></label>
                            <input type="file" class="form-control" name="validId" id="validId" accept="image/*" required onchange="validateImageUpload(this)" />
                            <div class="invalid-feedback">
                                Please select a valid image file.
                            </div>
                        </div>                                                             
                        <div class="col-12 col-md-2 mb-3 mb-md-0">
                            <button class="btn btn-primary w-100" name="submitReserve" type="submit">Submit form</button>
                        </div>
                     </form>
                        <div class="col-12 col-md-2">
                            <button class="btn btn-outline-primary w-100" type="reset" onclick="resetForm()">Reset</button>
                        </div>
            </div>
        </div>
    </div>

    <script> // For Birthdate
        document.getElementById('birthDate').addEventListener('keydown', function (event) {
            // Prevent typing numbers directly into the input field
            if (event.key >= '0' && event.key <= '9') {
                event.preventDefault();
            }
        });
    
        
        document.getElementById('birthDate').addEventListener('input', function () {
            var birthDate = new Date(this.value);
            var currentDate = new Date();
            var minDate = new Date('1900-01-01');
            var maxDate = new Date();
            maxDate.setFullYear(currentDate.getFullYear() - 18);
    
            if (birthDate < minDate || birthDate > maxDate) {
                this.setCustomValidity('Please enter a valid birthdate (minimum 1900 and at least 18 years ago).');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>

    <script>// For Select Date
        document.getElementById('selectDate').addEventListener('keydown', function (event) {
            // Prevent typing numbers directly into the input field
            if (event.key >= '0' && event.key <= '9') {
                event.preventDefault();
            }
        });
        
        document.getElementById('selectDate').addEventListener('input', function () {
            var selectedDate = new Date(this.value);
            var currentDate = new Date();
            var maxDate = new Date();
            maxDate.setDate(currentDate.getDate() + 30);

            if (selectedDate < currentDate || selectedDate > maxDate) {
                this.setCustomValidity('Please enter a valid date within the next 30 days');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>

    <script> //For Time Start and Time End
        document.getElementById('startTime').addEventListener('input', validateTimeRange);
        document.getElementById('endTime').addEventListener('input', validateTimeRange);

        function roundToNearestHour(time) {
            var splitTime = time.split(':');
            var hours = parseInt(splitTime[0], 10);
            var roundedHours = Math.round(hours);
            return roundedHours.toString().padStart(2, '0') + ':00';
        }

        function validateTimeRange() {
            var startTimeInput = document.getElementById('startTime');
            var endTimeInput = document.getElementById('endTime');

            var startTime = roundToNearestHour(startTimeInput.value);
            var endTime = roundToNearestHour(endTimeInput.value);

            startTimeInput.value = startTime;
            endTimeInput.value = endTime;

            if (startTime >= endTime) {
                document.getElementById('timeRangeError').style.display = 'block';
                this.setCustomValidity('Please enter a valid time range (end time must be after start time).');
            } else {
                document.getElementById('timeRangeError').style.display = 'none';
                this.setCustomValidity('');
            }
        }
    </script>

    <script> //For File Upload
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

    <script> //For Form Validation
        (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
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
        document.getElementById('selectDate').addEventListener('input', function () {
            var startTimeInput = document.getElementById('startTime');
            var endTimeInput = document.getElementById('endTime');
            var selectTableInput = document.getElementById('selectTable');

            if (this.value) {
                startTimeInput.disabled = false;
                startTimeInput.focus();
            } else {
                startTimeInput.value = '';
                startTimeInput.disabled = true;
                endTimeInput.value = '';
                endTimeInput.disabled = true;
                selectTableInput.value = '';
                selectTableInput.disabled = true;
            }
        });

        document.getElementById('startTime').addEventListener('input', function () {
            var endTimeInput = document.getElementById('endTime');
            var selectTableInput = document.getElementById('selectTable');

            if (this.value) {
                endTimeInput.disabled = false;
                endTimeInput.focus();
            } else {
                endTimeInput.value = '';
                endTimeInput.disabled = true;
                selectTableInput.value = '';
                selectTableInput.disabled = true;
            }
        });

        document.getElementById('endTime').addEventListener('input', function () {
            var selectTableInput = document.getElementById('selectTable');

            if (this.value) {
                selectTableInput.disabled = false;
                selectTableInput.focus();
            } else {
                selectTableInput.value = '';
                selectTableInput.disabled = true;
            }
        });
    </script>

    <script> // for getting the difference between startTime and endTime 
    // after getting difference, we set the value of timeDifference hidden input field
    document.getElementById('endTime').addEventListener('change', function() {
        var startTime = document.getElementById('startTime').value;
        var endTime = this.value;

        if (startTime && endTime) {
            var startDate = new Date('1970-01-01T' + startTime + 'Z');
            var endDate = new Date('1970-01-01T' + endTime + 'Z');

            if (endDate < startDate) {
                endDate.setDate(endDate.getDate() + 1); // Add one day if end time is earlier than start time
            }

            var difference = endDate - startDate;
            var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            document.getElementById('timeDifference').value = hours;
        } else {
            document.getElementById('timeDifference').value = 0;
        }
    });
    </script>

    <script> // Reset the form
        function resetForm() {
            document.querySelector('form').reset();
            location.reload();
        }
    </script>
</body>
</html>