// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()


//   For trimming whitespaces
function handleInput(event) {
  const inputValue = event.target.value;
  event.target.value = inputValue.trim(); // Remove leading and trailing whitespaces
}


// For first names that it wont accept any numeric and special characters
function validateName(event) {
  const regex = /^[A-Za-z\s]*$/; // Allow only alphabetic characters and spaces
  if (!regex.test(event.target.value)) {
    event.target.value = event.target.value.replace(/[^A-Za-z\s]/g, '');
  }
}


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


//For Contact Number
function validateContactNumber(event) {
  const input = event.target;
  const value = input.value;

  // Allow only numeric characters
  input.value = value.replace(/[^0-9]/g, '');

  // Check if the length is exactly 11 and starts with '09'
  if (input.value.length === 11 && input.value.startsWith('09')) {
    input.setCustomValidity(''); // Valid input
  } else {
    input.setCustomValidity('Please provide a valid contact number (11 digits, starts with 09).');
  }
}


//For Email 
function validateEmail(event) {
  var emailInput = event.target.value;

  event.target.value = emailInput.replace(/\s+/g, '');

  emailInput = event.target.value.trim();

  var isValid = /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(emailInput);

  if (!isValid) {
    document.getElementById("emailError").style.display = "block";
    event.target.setCustomValidity("Please enter a valid email address.");
  } else {
    document.getElementById("emailError").style.display = "none";
    event.target.setCustomValidity("");
  }
}


document.getElementById("email").addEventListener("input", validateEmail);



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
      $("#selectTable").html('<option value="">Select table</option>');
    }
  });
});


//For End Time
function adjustEndTime() {
  const startTimeInput = document.getElementById('selectStartTime');
  const endTimeInput = document.getElementById('selectEndTime');

  if (startTimeInput.value) {
    const [startHour, startMinute] = startTimeInput.value.split(':').map(Number);
    
    if (startHour < 10 || (startHour >= 24 && startHour < 34)) {
      // If start time is invalid (before 10:00 AM or after 3:00 AM next day), clear the end time input
      endTimeInput.value = '';
      startTimeInput.setCustomValidity('Start time must be between 10:00 AM and 3:00 AM.');
    } else {
      startTimeInput.setCustomValidity('');
      let endHour = startHour + 2; // Adding 2 hours for minimum duration
      const endMinute = startMinute;

      // Handle hour overflow for the next day
      if (endHour >= 24) {
        endHour = endHour - 24;
      }

      // Ensure the end time does not exceed 3:00 AM the following day
      if (startHour >= 12 && endHour >= 3 && endMinute > 0) {
        endHour = 3;
        endMinute = 0;
      }

      // Format end hour and minute
      const formattedEndHour = endHour.toString().padStart(2, '0');
      const formattedEndMinute = endMinute.toString().padStart(2, '0');
      endTimeInput.value = `${formattedEndHour}:${formattedEndMinute}`;
      endTimeInput.min = `${formattedEndHour}:${formattedEndMinute}`;
      endTimeInput.max = '03:00';
    }
  } else {
    // Clear the end time input if the start time is empty
    endTimeInput.value = '';
  }
}

// Add event listener
document.getElementById('selectStartTime').addEventListener('input', adjustEndTime);


// Prevent typing in the date input fields
document.getElementById('selectDate').addEventListener('keydown', function(event) {
  event.preventDefault();
});

document.getElementById('birthDate').addEventListener('keydown', function(event) {
  event.preventDefault();
});

document.getElementById('selectStartTime').addEventListener('keydown', function(event) {
  event.preventDefault();
});

document.getElementById('selectEndTime').addEventListener('keydown', function(event) {
  event.preventDefault();
});







// For calling the modal
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('booking-form');
  const submitButton = document.getElementById('submitReserve');
  const confirmAddWalkin = new bootstrap.Modal(document.getElementById('confirmAddWalkin'));

  form.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission
    if (form.checkValidity()) {
      // Form is valid, show success modal
      confirmAddWalkin.show();
      // You can also submit the form via AJAX here if needed
    } else {
      form.classList.add('was-validated'); // Show validation messages
    }
  });

  // Optional: Reset form validation on modal close
  confirmAddWalkin.addEventListener('hidden.bs.modal', function () {
    form.classList.remove('was-validated');
  });
});


//For Modal Body
$(document).ready(function() {
  $("#create-walkin-button").click(function() {
      $("#confirmAddWalkin .modal-body").html(getUserInputs());
  });
});

function getUserInputs() {
  const firstName = $("#firstName").val();
  const middleName = $("#middleName").val();
  const lastName = $("#lastName").val();
  const birthDate = $("#birthDate").val();
  const contactNumber = $("#contactNumber").val();
  const email = $("#email").val();
  const selectDate = $("#selectDate").val();
  const selectStartTime = $("#selectStartTime").val();
  const selectEndTime = $("#selectEndTime").val();
  const selectTable = $("#selectTable").val();

  // Calculate total price based on selected start and end times
  const startTime = new Date(`2024-06-14T${selectStartTime}`);
  let endTime = new Date(`2024-06-14T${selectEndTime}`);

  // If end time is earlier than start time, it means it extends to the next day
  if (endTime < startTime) {
    endTime.setDate(endTime.getDate() + 1);
  }

  const durationInMinutes = (endTime - startTime) / (1000 * 60);
  const durationInHours = durationInMinutes / 60;

  const basePrice = 100; // Base price in pesos
  const additionalHourPrice = 100; // Additional cost per hour in pesos

  let totalPrice = basePrice;

  if (durationInHours > 1) {
    const extraHours = Math.ceil(durationInHours - 1); // Calculate extra hours beyond the first hour
    totalPrice += extraHours * additionalHourPrice;
  }

  // Format the total price as PHP currency
  const formattedPrice = new Intl.NumberFormat('en-PH', {
    style: 'currency',
    currency: 'PHP'
  }).format(totalPrice);

  return `
    <div class="modal-content-wrapper">
        <p><span class="modal-label">Name:</span> <span class="modal-input">${firstName} ${middleName} ${lastName}</span></p>
        <p><span class="modal-label">Birthdate:</span> <span class="modal-input">${birthDate}</span></p>
        <p><span class="modal-label">Contact Number:</span> <span class="modal-input">${contactNumber}</span></p>
        <p><span class="modal-label">Email Address:</span> <span class="modal-input">${email}</span></p>
        <p><span class="modal-label mt-3">- Reservation -</span> <span class="modal-input"></span></p>
        <p><span class="modal-label">Date:</span> <span class="modal-input">${selectDate}</span></p>
        <p><span class="modal-label">Time:</span> <span class="modal-input">${selectStartTime} - ${selectEndTime}</span></p>
        <p><span class="modal-label">Table:</span> <span class="modal-input">${selectTable}</span></p>
        <p><span class="modal-total mt-3">Total:</span> <span class="modal-input mt-3" id="total">${formattedPrice}</span></p>
    </div>
  `;
}


// For the readonly fields
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("hiddenFirstName").value =
    document.getElementById("firstName").value;
  document.getElementById("hiddenMiddleName").value =
    document.getElementById("middleName").value;
  document.getElementById("hiddenLastName").value =
    document.getElementById("lastName").value;
  document.getElementById("hiddenBirthDate").value =
    document.getElementById("birthDate").value;
  document.getElementById("hiddenContactNumber").value =
    document.getElementById("contactNumber").value;
  document.getElementById("hiddenEmail").value =
    document.getElementById("email").value;
});


//add reservation
$(document).ready(function () {
  $("#submitReserve").click(function (e) {
    e.preventDefault();

    var formData = new FormData($("#booking-form")[0]);


                    // Disable the button to prevent multiple clicks
                    $(this).prop("disabled", true);

    $.ajax({
      type: "POST",
      url: "reservation_crud.php", // Replace 'process_form.php' with the URL of your PHP script
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










// For the save changes
// let formChanged = false;
// document.querySelectorAll('input, select').forEach(item => {
//     item.addEventListener('input', () => {
//         formChanged = true;
//     });
// });

// // Function to handle cancel button click
// function handleCancel() {
//     if (formChanged) {
//         $('#cancelModal').modal('show'); // Show modal if form has changes
//     } else {
//         window.location.href = 'customer_dashboard.php'; // Directly redirect if no changes
//     }
// }


document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('booking-form');
  let isFormDirty = false;

  form.addEventListener('input', () => {
    isFormDirty = true;
  });

  const cancelButton = document.querySelector('.cancel-button-member');
  cancelButton.addEventListener('click', () => {
    if (isFormDirty) {
      const unsavedChangesModal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
      unsavedChangesModal.show();
    } else {
      window.location.href = 'customer_dashboard.php';
    }
  });

  const proceedButton = document.getElementById('proceedButton');
  proceedButton.addEventListener('click', () => {
    window.location.href = 'customer_dashboard.php';
  });
});


//For reloading na nagana kaso default
// document.addEventListener('DOMContentLoaded', () => {
//   let isFormDirty = false; // Track if form has unsaved changes

//   // Track form changes (example)
//   document.getElementById('booking-form').addEventListener('input', () => {
//     isFormDirty = true;
//   });

//   // Handle page reload attempt
//   window.addEventListener('beforeunload', (e) => {
//     if (isFormDirty) {
//       // Customize the message shown by the browser
//       e.returnValue = 'may unsaved ka bobo';
//     }
//   });

//   // Optional: Clear form dirty flag on form submission or other action
//   document.getElementById('booking-form').addEventListener('submit', () => {
//     isFormDirty = false;
//   });

//   // Show modal for custom interaction when leaving page
//   document.getElementById('reloadPageBtn').addEventListener('click', () => {
//     if (isFormDirty) {
//       const unsavedChangesModal = new bootstrap.Modal(document.getElementById('confirmUnsavedReloadModal'));
//       unsavedChangesModal.show();

//       // Handle modal buttons
//       document.getElementById('proceedReloadBtn').addEventListener('click', () => {
//         window.location.reload(); // Reload the page
//       });
//     } else {
//       window.location.reload(); // Directly reload if no unsaved changes
//     }
//   });
// });

// document.addEventListener('DOMContentLoaded', () => {
//   let isFormDirty = false; // Track if form has unsaved changes

//   // Track form changes (example)
//   document.getElementById('booking-form').addEventListener('input', () => {
//     isFormDirty = true;
//   });

//   // Handle page reload attempt
//   window.addEventListener('beforeunload', (e) => {
//     if (isFormDirty) {
//       // Customize the message shown by the browser
//       e.returnValue = 'tanga.';
//     }
//   });

//   // Optional: Clear form dirty flag on form submission or other action
//   document.getElementById('booking-form').addEventListener('submit', () => {
//     isFormDirty = false;
//   });

//   // Show modal for custom interaction when leaving page
//   document.getElementById('reloadPageBtn').addEventListener('click', () => {
//     if (isFormDirty) {
//       const unsavedChangesModal = new bootstrap.Modal(document.getElementById('confirmUnsavedReloadModal'));
//       unsavedChangesModal.show();

//       // Handle modal buttons
//       document.getElementById('proceedReloadBtn').addEventListener('click', () => {
//         window.location.reload(); // Reload the page
//       });
//     } else {
//       window.location.reload(); // Directly reload if no unsaved changes
//     }
//   });
// });

