//For File Upload
function validateImageUpload(input) {
  const file = input.files[0];
  const allowedTypes = ["image/jpeg", "image/png", "image/gif"];

  if (file && allowedTypes.includes(file.type)) {
    input.setCustomValidity("");
  } else {
    input.setCustomValidity(
      "Please select a valid image file (JPEG, PNG, or GIF)."
    );
  }
}

//Ddata table
$(document).ready(function () {
  $("#example").DataTable({
    paging: true,
    lengthChange: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
  });
});

$(document).ready(function () {
  // Function to update table content
  function updateTable() {
    $.ajax({
      url: "pool_table.php",
      type: "GET",
      success: function (response) {
        $("#updateTable").html(response);
      },
    });
  }

  // Initial table update
  updateTable();

  // Refresh table every 5 seconds
  setInterval(updateTable, 1000); // Adjust interval as needed
});

// Reset the form
function resetForm() {
  document.querySelector("form").reset();
  location.reload();
}

//add walk in details
$(document).ready(function () {
  $("#submitWalkin").click(function (e) {
    e.preventDefault();

    var formData = new FormData($("#booking-form")[0]);

    $.ajax({
      type: "POST",
      url: "walkin_crud.php", // Replace 'process_form.php' with the URL of your PHP script
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Handle success response here
        //alert(response); // For demonstration purposes, you can display an alert with the response
        location.reload();
      },
      error: function (xhr, status, error) {
        // Handle error
        console.error(xhr.responseText);
      },
    });
  });
});

//   get available pool tables
$(document).ready(function () {
  $("#selectEndTime, #selectStartTime, #selectDate").change(function () {
    var startTime = $("#selectStartTime").val();
    var endTime = $("#selectEndTime").val();
    var date = $("#selectDate").val();

    if (startTime && endTime) {
      $.ajax({
        type: "POST",
        url: "src/get_data_from_database/get_available_table.php",
        data: {
          startTime: startTime,
          endTime: endTime,
          date: date,
        },
        success: function (response) {
          $("#selectTable").html(response);
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error: " + status + error);
        },
      });
    } else {
      $("#selectTable").html('<option value="">Select Table</option>');
    }
  });
});

//   For trimming whitespaces
function handleInput(event) {
  const inputValue = event.target.value;
  event.target.value = inputValue.trim(); // Remove leading and trailing whitespaces
}

function validateName(event) {
  const inputValue = event.target.value;
  const validPattern = /^[A-Za-z]+(?:[\s\-&][A-Za-z]+)*$/; // Only allow letters, hyphens, and ampersands

  if (!validPattern.test(inputValue) || /^[\-&]+$/.test(inputValue)) {
    event.target.setCustomValidity(
      "Please enter a valid name with alphabetic characters and optionally hyphens or ampersands."
    );
  } else {
    event.target.setCustomValidity("");
  }
}

function validateContactNumber(event) {
  const inputValue = event.target.value;
  const validPattern = /^09\d{9}$/; // Must start with 09 and have 11 digits in total

  if (!validPattern.test(inputValue)) {
    event.target.setCustomValidity(
      "Please enter a valid contact number starting with 09 and followed by 9 digits."
    );
  } else {
    event.target.setCustomValidity("");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const trimInputs = document.querySelectorAll(".trim-input");
  trimInputs.forEach((input) => {
    input.addEventListener("input", handleInput);
  });

  const validateInputs = document.querySelectorAll(".validate-input");
  validateInputs.forEach((input) => {
    input.addEventListener("input", validateName);
  });

  const validateContact = document.querySelectorAll(".validate-contact");
  validateContact.forEach((input) => {
    input.addEventListener("input", validateContactNumber);
  });
});

//For birthdate
document.addEventListener("DOMContentLoaded", function () {
  var birthDateInput = document.getElementById("birthDate");

  // Set min and max date for birthdate input
  var currentDate = new Date();
  var minDate = new Date("1950-01-01");
  var maxDate = new Date(currentDate);
  maxDate.setFullYear(currentDate.getFullYear() - 18); // 18 years ago from current year

  birthDateInput.min = minDate.toISOString().split("T")[0]; // Minimum date is 1900-01-01
  birthDateInput.max = maxDate.toISOString().split("T")[0]; // Maximum date is 18 years ago

  birthDateInput.addEventListener("input", function () {
    var selectedDate = new Date(this.value);

    if (selectedDate < minDate || selectedDate > maxDate) {
      this.setCustomValidity(
        "Please enter a valid birthdate (minimum 1900 and at least 18 years ago)."
      );
    } else {
      this.setCustomValidity("");
    }
  });
});

// For Form Validation
(() => {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll(".needs-validation");

  // Loop over them and prevent submission
  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();

// For Email validation
document.getElementById("email").addEventListener("input", function () {
  var emailInput = this.value.trim();
  var isValid = /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(emailInput);

  if (!isValid) {
    document.getElementById("emailError").style.display = "block";
    this.setCustomValidity("Please enter a valid email address.");
  } else {
    document.getElementById("emailError").style.display = "none";
    this.setCustomValidity("");
  }
});

// For Time End
const endTimesMap = {
  "10:00:00": [
    "12:00nn",
    "1:00pm",
    "2:00pm",
    "3:00pm",
    "4:00pm",
    "5:00pm",
    "6:00pm",
    "7:00pm",
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
  "11:00:00": [
    "1:00pm",
    "2:00pm",
    "3:00pm",
    "4:00pm",
    "5:00pm",
    "6:00pm",
    "7:00pm",
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
  "12:00:00": [
    "2:00pm",
    "3:00pm",
    "4:00pm",
    "5:00pm",
    "6:00pm",
    "7:00pm",
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
  "13:00:00": [
    "3:00pm",
    "4:00pm",
    "5:00pm",
    "6:00pm",
    "7:00pm",
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
  "14:00:00": [
    "4:00pm",
    "5:00pm",
    "6:00pm",
    "7:00pm",
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
    "4:00am",
    "5:00am",
  ],
  "15:00:00": [
    "5:00pm",
    "6:00pm",
    "7:00pm",
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
    "4:00am",
    "5:00am",
  ],
  "16:00:00": [
    "6:00pm",
    "7:00pm",
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
  "17:00:00": [
    "7:00pm",
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
  "18:00:00": [
    "8:00pm",
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
  "19:00:00": [
    "9:00pm",
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
  "20:00:00": [
    "10:00pm",
    "11:00pm",
    "12:00 midnight",
    "1:00am",
    "2:00am",
    "3:00am",
  ],
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
  endTimeSelect.innerHTML =
    '<option value="" selected disabled>Select end time</option>';

  // Define available end times based on selected start time
  const endTimes = endTimesMap[selectedStartTime] || [];

  // Add options to select end time
  endTimes.forEach(function (time) {
    const option = document.createElement("option");

    var timeSplit = time.split(":"); // split hour from minutes
    if (timeSplit[1] == "00am" || timeSplit[1] == "00nn") {
      var actualTime = timeSplit[0] + ":00:00";
    } else if (timeSplit[1] == "00pm") {
      var actualTime = 12 + parseInt(timeSplit[0]) + ":00:00";
    } else {
      var actualTime = "00:00:00";
    }
    option.text = time;
    option.value = actualTime;
    endTimeSelect.add(option);
  });
}

// disabling of create button when fields are empty
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("booking-form");
  const createButton = document.getElementById("submitReserve");

  form.addEventListener("input", function () {
    const inputs = form.querySelectorAll(".validate-input");
    let isValid = true;

    inputs.forEach((input) => {
      if (!input.checkValidity()) {
        isValid = false;
      }
    });

    createButton.disabled = !isValid;
  });

  // Initial check on page load
  createButton.disabled = true;
});
