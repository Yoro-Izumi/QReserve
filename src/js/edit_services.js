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
  const regex = /^[A-Za-z0-9\s]*$/; // Allow alphabetic, numeric characters, and spaces
  if (!regex.test(event.target.value)) {
    event.target.value = event.target.value.replace(/[^A-Za-z0-9\s]/g, '');
  }
}


// For Rate
function validateRate(event) {
  const input = event.target;
  let value = input.value.replace(/,/g, ''); // Remove existing commas
  const numericValue = value.replace(/[^0-9]/g, ''); // Allow only numeric characters

  if (numericValue.length <= 4) { // Limit the length to 4 digits
      input.value = numericValue;

      // Check for minimum value
      if (numericValue === '' || parseInt(numericValue, 10) < 100) {
          input.classList.remove('is-valid');
          input.classList.add('is-invalid');
      } else {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
      }
  } else {
      // If the input exceeds 4 digits, truncate the value
      const truncatedValue = numericValue.slice(0, 4);
      input.value = truncatedValue;

      // Check for minimum value
      if (parseInt(truncatedValue, 10) < 100) {
          input.classList.remove('is-valid');
          input.classList.add('is-invalid');
      } else {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
      }
  }
}

function handleRateInput(event) {
  const input = event.target;
  let value = input.value.replace(/,/g, ''); // Remove existing commas
  const numericValue = value.replace(/[^0-9]/g, ''); // Allow only numeric characters

  if (numericValue === '' || parseInt(numericValue, 10) < 100) {
      input.classList.remove('is-valid');
      input.classList.add('is-invalid');
  } else {
      input.classList.remove('is-invalid');
      input.classList.add('is-valid');
  }
}


//For Capacity
function validateCapacity(event) {
  const input = event.target;
  const value = input.value;

  // Ensure the input is numeric and within the valid range
  if (/^\d*$/.test(value)) {
      if (value < 1 || value > 50) {
          input.classList.remove('is-valid');
          input.classList.add('is-invalid');
      } else {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
      }
  } else {
      input.classList.remove('is-valid');
      input.classList.add('is-invalid');
  }
}

function handleCapacityInput(event) {
  const input = event.target;
  const value = parseInt(input.value, 10);

  // Ensure the value is within the range
  if (value < 1) {
      input.value = 1;
  } else if (value > 50) {
      input.value = 50;
  }

  // Trigger the validation again to update feedback
  validateCapacity(event);
}


//For Image upload
function validateImage(event) {
  const input = event.target;
  const file = input.files[0];
  const validImageTypes = ["image/jpeg", "image/jpg", "image/png"];
  const maxSize = 5 * 1024 * 1024; // 5MB in bytes
  const imagePreview = document.getElementById('imagePreview');
  const imageFeedback = document.getElementById('imageFeedback');

  if (file) {
      const fileType = file.type;
      const fileSize = file.size;

      if (validImageTypes.includes(fileType) && fileSize <= maxSize) {
          input.classList.add("is-valid");
          input.classList.remove("is-invalid");
          imageFeedback.textContent = "";

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

          if (!validImageTypes.includes(fileType)) {
              imageFeedback.textContent = "Invalid file type. Please upload an image file (jpeg, jpg, png).";
          } else if (fileSize > maxSize) {
              imageFeedback.textContent = "File size exceeds 5MB. Please upload a smaller image.";
          }
      }
  }
}


// For calling the modal
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('edit-service-form');
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



    //add reservation
    $(document).ready(function() {
      $('#submitWalkin').click(function(e) {
        e.preventDefault();
    
        var formData = new FormData($('#edit-service-form')[0]);
    
        // Disable the button to prevent multiple clicks
        $(this).prop('disabled', true);
    
        $.ajax({
          type: 'POST',
          url: 'service_crud.php', // Replace 'process_form.php' with the URL of your PHP script
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            // Handle success response here
            //alert(response); // For demonstration purposes, you can display an alert with the response
            window.location.href = "service_management.php";
          },
          error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
            // Re-enable the button if there's an error
            $('#submitWalkin').prop('disabled', false);
          }
        });
      });
    });
    



document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('edit-service-form');
  let isFormDirty = false;

  form.addEventListener('input', () => {
    isFormDirty = true;
  });

  const cancelButton = document.querySelector('.cancel-button');
  cancelButton.addEventListener('click', () => {
    if (isFormDirty) {
      // Ensure the modal is shown using Bootstrap's modal instance
      const unsavedChangesModal = new bootstrap.Modal(document.getElementById('unsavedChangesModal'));
      unsavedChangesModal.show();
    } else {
      // Directly redirect if form is not dirty
      window.location.href = 'service_management.php';
    }
  });

  const proceedButton = document.getElementById('proceedButton');
  proceedButton.addEventListener('click', () => {
    // Handle the proceed button action
    window.location.href = 'service_management.php';
  });
});