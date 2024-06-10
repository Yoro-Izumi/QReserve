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
              event.preventDefault();
              event.stopPropagation();
  
              if (form.checkValidity()) {
                // Form is valid, submit via AJAX
                var formData = new FormData(form);
  
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
              }
  
              form.classList.add("was-validated");
            },
            false
          );
        });
      })();

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
// $(document).ready(function () {
//   $("#submitReserve").click(function (e) {
//     e.preventDefault();

//     var formData = new FormData($("#booking-form")[0]);

//     $.ajax({
//       type: "POST",
//       url: "reservation_crud.php",
//       data: formData,
//       processData: false,
//       contentType: false,
//       success: function (response) {
//         // Handle success response here
//         //alert(response); // For demonstration purposes, you can display an alert with the response
//         location.reload();
//       },
//       error: function (xhr, status, error) {
//         // Handle error
//         console.error(xhr.responseText);
//       },
//     });
//   });
// });

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
  