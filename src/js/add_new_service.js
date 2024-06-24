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


  //For Image upload
  function validateImage(event) {
    const input = event.target;
    const file = input.files[0];
    const validImageTypes = ["image/jpeg", "image/jpg", "image/png"];
    const imagePreview = document.getElementById('imagePreview');

    if (file) {
        const fileType = file.type;
        
        if (validImageTypes.includes(fileType)) {
            input.classList.add("is-valid");
            input.classList.remove("is-invalid");

            // Preview the image
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            input.classList.add("is-invalid");
            input.classList.remove("is-valid");
            input.value = ""; // Clear the input value to remove the invalid file
            imagePreview.style.display = 'none';
        }
    }
}

// Other functions for form validation
function handleInput(event) {
    const inputValue = event.target.value;
    event.target.value = inputValue.trim(); // Remove leading and trailing whitespaces
}

function validateName(event) {
    const regex = /^[A-Za-z\s]*$/; // Allow only alphabetic characters and spaces
    if (!regex.test(event.target.value)) {
        event.target.value = event.target.value.replace(/[^A-Za-z\s]/g, '');
    }
}

function validateRate(event) {
  const input = event.target;
  let value = input.value.replace(/,/g, ''); // Remove existing commas
  const numericValue = value.replace(/[^0-9]/g, ''); // Allow only numeric characters

  if (numericValue.length <= 4) { // Limit the length to 4 digits
      const formattedValue = new Intl.NumberFormat().format(numericValue);
      input.value = formattedValue;

      // Check for minimum value
      if (parseInt(numericValue, 10) < 100) {
          input.classList.remove('is-valid');
          input.classList.add('is-invalid');
          input.setCustomValidity('Rate must be at least 100'); // Add custom validity message
      } else {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
          input.setCustomValidity(''); // Clear custom validity message
      }
  } else {
      // If the input exceeds 4 digits, truncate the value
      const truncatedValue = numericValue.slice(0, 4);
      const formattedTruncatedValue = new Intl.NumberFormat().format(truncatedValue);
      input.value = formattedTruncatedValue;

      // Check for minimum value
      if (parseInt(truncatedValue, 10) < 100) {
          input.classList.remove('is-valid');
          input.classList.add('is-invalid');
          input.setCustomValidity('Rate must be at least 100'); // Add custom validity message
      } else {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
          input.setCustomValidity(''); // Clear custom validity message
      }
  }
}

function handleInput2(event) {
  const input = event.target;
  let value = input.value.replace(/,/g, ''); // Remove existing commas
  const numericValue = value.replace(/[^0-9]/g, ''); // Allow only numeric characters

  if (parseInt(numericValue, 10) < 100) {
      input.classList.remove('is-valid');
      input.classList.add('is-invalid');
      input.setCustomValidity('Rate must be at least 100'); // Add custom validity message
  } else {
      input.classList.remove('is-invalid');
      input.classList.add('is-valid');
      input.setCustomValidity(''); // Clear custom validity message
  }
}




function validateCapacity(event) {
  const input = event.target;
  let value = input.value.replace(/[^0-9]/g, ''); // Allow only numeric characters

  // Check for minimum value
  if (parseInt(value, 10) < 2) {
      input.value = ''; // Clear the input if the value is less than 2
      input.classList.remove('is-valid');
      input.classList.add('is-invalid');
      input.setCustomValidity('Capacity must be at least 2'); // Add custom validity message
  } else {
      input.classList.remove('is-invalid');
      input.classList.add('is-valid');
      input.setCustomValidity(''); // Clear custom validity message
  }
}


// For calling the modal
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('booking-form');
    const confirmAddWalkin = new bootstrap.Modal(document.getElementById('confirmAddWalkin'));

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        if (form.checkValidity()) {
            // Form is valid, show success modal
            confirmAddWalkin.show();
        } else {
            form.classList.add('was-validated'); // Show validation messages
        }
    });

    // Optional: Reset form validation on modal close
    confirmAddWalkin.addEventListener('hidden.bs.modal', function () {
        form.classList.remove('was-validated');
    });
});

// For Modal Body
$(document).ready(function() {
    $("#create-walkin-button").click(function() {
        $("#confirmAddWalkin .modal-body").html(getUserInputs());
    });
});

function getUserInputs() {
    const serviceName = $("#serviceName").val();
    const serviceRate = $("#serviceRate").val();
    const capacity = $("#capacity").val();
    const serviceImage = $("#serviceImage").val();

    return `
      <div class="modal-content-wrapper">
          <p><span class="modal-label">Name:</span> <span class="modal-input">${serviceName}</span></p>
          <p><span class="modal-label">Rate:</span> <span class="modal-input">${serviceRate}</span></p>
          <p><span class="modal-label">Capacity:</span> <span class="modal-input">${capacity}</span></p>
          <p><span class="modal-label">Image:</span> <span class="modal-input">${serviceImage}</span></p>
      </div>
    `;
}

  


  // For calling the modal
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('booking-form');
    const submitButton = document.getElementById('submitWalkin');
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
    const serviceName = $("#serviceName").val();
    const serviceRate = $("#serviceRate").val();
    const capacity = $("#capacity").val();
    const serviceImage = $("#serviceImage").val();
  
  
    return `
      <div class="modal-content-wrapper">
          <p><span class="modal-label">Name:</span> <span class="modal-input">${serviceName}</span></p>
          <p><span class="modal-label">Rate:</span> <span class="modal-input">${serviceRate}</span></p>
          <p><span class="modal-label">Capacity:</span> <span class="modal-input">${capacity}</span></p>
          <p><span class="modal-label">Image:</span> <span class="modal-input">${serviceImage}</span></p>
      </div>
    `;
  }


      //add reservation
$(document).ready(function () {
    $("#submitWalkin").click(function (e) {
      e.preventDefault();
  
      var formData = new FormData($("#booking-form")[0]);
  
      $.ajax({
        type: "POST",
        url: "service_crud.php", // Replace 'process_form.php' with the URL of your PHP script
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Handle success response here
          //alert(response); // For demonstration purposes, you can display an alert with the response
          window.location.href = "service_management.php";
        },
        error: function (xhr, status, error) {
          // Handle error
          console.error(xhr.responseText);
        },
      });
    });
  });
  