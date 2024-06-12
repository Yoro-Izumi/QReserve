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

// For Form Validation
    // (() => {
    //     "use strict";
  
    //     // Fetch all the forms we want to apply custom Bootstrap validation styles to
    //     const forms = document.querySelectorAll(".needs-validation");
  
    //     // Loop over them and prevent submission
    //     Array.from(forms).forEach((form) => {
    //       form.addEventListener(
    //         "submit",
    //         (event) => {
    //           event.preventDefault();
    //           event.stopPropagation();
  
    //           if (form.checkValidity()) {
    //             // Form is valid, submit via AJAX
    //             var formData = new FormData(form);
  
    //             $.ajax({
    //               type: "POST",
    //               url: "reservation_crud.php",
    //               data: formData,
    //               processData: false,
    //               contentType: false,
    //               success: function (response) {
    //                 // Handle success response here
    //                 //alert(response); // For demonstration purposes, you can display an alert with the response
    //                 location.reload();
    //               },
    //               error: function (xhr, status, error) {
    //                 // Handle error
    //                 console.error(xhr.responseText);
    //               },
    //             });
    //           }
  
    //           form.classList.add("was-validated");
    //         },
    //         false
    //       );
    //     });
    //   })();

// Reset the form
function resetForm() {
  document.querySelector("form").reset();
  location.reload();
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

    $.ajax({
      type: "POST",
      url: "reservation_crud.php",
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

// get available pool tables
$(document).ready(function () {
  $("#selectEndTime, #selectStartTime, #selectDate").change(function () {
    var startTime = $("#selectStartTime").val();
    var endTime = $("#selectEndTime").val();
    var date = $("#selectDate").val();

    if (startTime && endTime) {
      $.ajax({
        type: "POST",
        url: "src/get_data_from_database/get_available_table.php",
        data: { startTime: startTime, endTime: endTime, date: date },
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




// For End Time
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



// Disables the create button
$(document).ready(function() {
  // Function to check if all required fields are filled
  function checkInputs() {
      var date = $('#selectDate').val();
      var startTime = $('#selectStartTime').val();
      var endTime = $('#selectEndTime').val();
      var table = $('#selectTable').val();

      // Enable/disable create button based on input values
      if (date && startTime && endTime && table) {
          $('#create-reservation-button').prop('disabled', false);
      } else {
          $('#create-reservation-button').prop('disabled', true);
      }
  }

  // Call checkInputs on input change
  $('#selectDate, #selectStartTime, #selectEndTime, #selectTable').on('change', function() {
      checkInputs();
  });

  // Initial check on page load
  checkInputs();
});






$(document).ready(function() {
  $("#create-reservation-button").click(function(e) {
    e.preventDefault();
    if (validateForm()) {
      $("#confirm-add-walkin-modal").modal("show");
    }
  });
});

function validateForm() {
  const form = document.getElementById("booking-form");
  const inputs = form.querySelectorAll("input, select");
  let isValid = true;

  inputs.forEach(input => {
    if (input.required && !input.value.trim()) {
      input.classList.add("is-invalid");
      isValid = false;
    } else {
      input.classList.remove("is-invalid");
    }
  });

  return isValid;
}





$(document).ready(function() {
  $("#confirm-add-new-walkin-button").click(function() {
    // Here, you can perform AJAX to insert data into the database
    // For demonstration, I'll reload the page
    location.reload();
  });

  $("#submitReserve").click(function(e) {
    e.preventDefault();
    $("#success-add-walkin-modal").modal("show");
  });
});






// $(document).ready(function() {
//   $("#create-reservation-button").click(function() {
//       $("#confirm-add-walkin-modal .modal-body").html(getUserInputs());
//   });
// });

// function getUserInputs() {
//   const firstName = $("#firstName").val();
//   const middleName = $("#middleName").val();
//   const lastName = $("#lastName").val();
//   const birthDate = $("#birthDate").val();
//   const contactNumber = $("#contactNumber").val();
//   const email = $("#email").val();
//   const selectDate = $("#selectDate").val();
//   const selectStartTime = $("#selectStartTime").val();
//   const selectEndTime = $("#selectEndTime").val();
//   const selectTable = $("#selectTable").val();

//   return `
//       <div class="modal-content-wrapper">
//           <p><span class="modal-label">Name:</span> <span class="modal-input">${firstName} ${middleName} ${lastName}</span></p>
//           <p><span class="modal-label">Birthdate:</span> <span class="modal-input">${birthDate}</span></p>
//           <p><span class="modal-label">Contact Number:</span> <span class="modal-input">${contactNumber}</span></p>
//           <p><span class="modal-label">Email Address:</span> <span class="modal-input">${email}</span></p>
//           <p><span class="modal-label mt-3">- Reservation -</span> <span class="modal-input"></span></p>
//           <p><span class="modal-label">Date:</span> <span class="modal-input">${selectDate}</span></p>
//           <p><span class="modal-label">Time:</span> <span class="modal-input">${selectStartTime} - ${selectEndTime}</span></p>
//           <p><span class="modal-label">Table:</span> <span class="modal-input">${selectTable}</span></p>
//           <p><span class="modal-total mt-3">Total:</span> <span class="modal-input mt-3" id="total">₱300</span></p>
//       </div>
//   `;
// }


$(document).ready(function() {
  $("#create-reservation-button").click(function() {
      $("#confirm-add-walkin-modal .modal-body").html(getUserInputs());
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
  const endTime = new Date(`2024-06-14T${selectEndTime}`);
  const durationInMinutes = (endTime - startTime) / (1000 * 60);
  const durationInHours = durationInMinutes / 60;

  const basePrice = 300; // Base price in pesos
  const extraCostPerHalfHour = 75; // Extra cost per 30 minutes in pesos

  let totalPrice = basePrice;

  if (durationInHours > 2) {
    const extraHours = Math.ceil(durationInHours - 2);
    totalPrice += extraHours * (extraCostPerHalfHour / 2); // Divide by 2 for 30-minute intervals
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






document.addEventListener("DOMContentLoaded", function() {
  const startTimeInput = document.getElementById("selectStartTime");
  const endTimeInput = document.getElementById("selectEndTime");

  startTimeInput.addEventListener("change", function() {
      const startTime = new Date(`2024-06-14T${this.value}`);
      const minEndTime = new Date(startTime.getTime() + 2 * 60 * 60 * 1000); // Add 2 hours

      const minEndTimeFormatted = minEndTime.toTimeString().slice(0, 5);
      endTimeInput.min = minEndTimeFormatted;
      endTimeInput.value = minEndTimeFormatted; // Set the end time to the minimum allowed

      calculatePrice();
  });

  endTimeInput.addEventListener("change", function() {
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