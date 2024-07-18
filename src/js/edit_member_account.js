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

//   For trimming whitespaces
function handleInput(event) {
  const inputValue = event.target.value;
  event.target.value = inputValue.trim(); // Remove leading and trailing whitespaces
}

// For first names that it wont accept any numeric and special characters
function validateName(event) {
  const regex = /^[A-Za-z\s]*$/; // Allow only alphabetic characters and spaces
  if (!regex.test(event.target.value)) {
    event.target.value = event.target.value.replace(/[^A-Za-z\s]/g, "");
  }
}

    //   For Birthdate
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

//For Contact Number
function validateContactNumber(event) {
  const input = event.target;
  const value = input.value;

  // Allow only numeric characters
  input.value = value.replace(/[^0-9]/g, "");

  // Check if the length is exactly 11 and starts with '09'
  if (input.value.length === 11 && input.value.startsWith("09")) {
    input.setCustomValidity(""); // Valid input
  } else {
    input.setCustomValidity(
      "Please provide a valid contact number (11 digits, starts with 09)."
    );
  }
}

//For Email
function validateEmail(event) {
  var emailInput = event.target.value;

  event.target.value = emailInput.replace(/\s+/g, "");

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


 //   For Validity Date
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


//   Updated script for password toggle
document.addEventListener("DOMContentLoaded", function () {
  const togglePassword1 = document.querySelector("#password-toggle-1");
  const passwordInput1 = document.querySelector("#password");
  const eyeIcon1 = togglePassword1.querySelector("i");

  togglePassword1.addEventListener("click", function () {
    const type =
      passwordInput1.getAttribute("type") === "password" ? "text" : "password";
    passwordInput1.setAttribute("type", type);

    // Toggle eye icon classes
    eyeIcon1.classList.toggle("fa-eye-slash");
    eyeIcon1.classList.toggle("fa-eye");
  });

  const togglePassword2 = document.querySelector("#password-toggle-2");
  const passwordInput2 = document.querySelector("#confirmPassword");
  const eyeIcon2 = togglePassword2.querySelector("i");

  togglePassword2.addEventListener("click", function () {
    const type =
      passwordInput2.getAttribute("type") === "password" ? "text" : "password";
    passwordInput2.setAttribute("type", type);

    // Toggle eye icon classes
    eyeIcon2.classList.toggle("fa-eye-slash");
    eyeIcon2.classList.toggle("fa-eye");
  });
});

//   For password checking
document.addEventListener("DOMContentLoaded", function () {
  const passwordInput = document.querySelector("#password");
  const confirmPasswordInput = document.querySelector("#confirmPassword");
  const passwordMatchFeedback = document.querySelector(
    "#passwordMatchFeedback"
  );
  const passwordMatch = document.querySelector("#passwordMatch");
  const passwordMismatch = document.querySelector("#passwordMismatch");

  confirmPasswordInput.addEventListener("input", function () {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (password === confirmPassword) {
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "block";
      passwordMismatch.style.display = "none";
    } else {
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "none";
      passwordMismatch.style.display = "block";
    }
  });

  passwordInput.addEventListener("input", function () {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (password === confirmPassword) {
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "block";
      passwordMismatch.style.display = "none";
    } else {
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "none";
      passwordMismatch.style.display = "block";
    }
  });
});

//   SPassword Strength Indicator
function checkPasswordStrength(password) {
  var strength = document.getElementById("password-strength-indicator");
  var strongRegex = new RegExp(
    "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
  );
  var mediumRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})");

  if (strongRegex.test(password)) {
    strength.innerHTML = '<span style="color:green">Strong password</span>';
  } else if (mediumRegex.test(password)) {
    strength.innerHTML = '<span style="color:orange">Moderate password</span>';
  } else {
    strength.innerHTML = '<span style="color:red">Weak password</span>';
  }
}

// For calling the modal
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('edit-admin-form');
  const submitButton = document.getElementById('submitEditAdmin');
  const confirmEditAdmin = new bootstrap.Modal(document.getElementById('confirmEditAdmin'));

  form.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission
    if (form.checkValidity()) {
      // Form is valid, show success modal
      confirmEditAdmin.show();
      // You can also submit the form via AJAX here if needed
    } else {
      form.classList.add('was-validated'); // Show validation messages
    }
  });

  // Optional: Reset form validation on modal close
  confirmEditAdmin.addEventListener('hidden.bs.modal', function () {
    form.classList.remove('was-validated');
  });
});


//For Modal Body
$(document).ready(function() {
  $("#create-admin-button").click(function() {
      $("#confirmEditAdmin .modal-body").html(getUserInputs());
  });
});



    //add reservation
$(document).ready(function () {
  $("#submitEditAdmin").click(function (e) {
    e.preventDefault();

    var formData = new FormData($("#edit-admin-form")[0]);

                // Disable the button to prevent multiple clicks
                $(this).prop("disabled", true);

    $.ajax({
      type: "POST",
      url: "member_crud.php", // Replace 'process_form.php' with the URL of your PHP script
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Handle success response here
        //alert(response); // For demonstration purposes, you can display an alert with the response
        window.location.href = "member-profiles.php";
      },
      error: function (xhr, status, error) {
        // Handle error
        console.error(xhr.responseText);
      },
    });
  });
});





//   set default value for password field in case if super admin does not want to edit password
document.addEventListener("DOMContentLoaded", () => {
  const passwordField = document.getElementById("password");
  const confirmPasswordField = document.getElementById("confirmPassword");
  const defaultValue = ".";

  // Ensure the default value is set when the page loads
  passwordField.value = defaultValue;
  confirmPasswordField.value = defaultValue;

  // Event listener to check if the input is empty
  passwordField.addEventListener("change", () => {
    if (
      passwordField.value.trim() === "" &&
      confirmPasswordField.value.trim() === "."
    ) {
      passwordField.value = defaultValue;
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "block";
      passwordMismatch.style.display = "none";
    } else if (
      passwordField.value.trim() !== "" &&
      confirmPasswordField.value.trim() === "."
    ) {
      //passwordField.value = defaultValue;
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "none";
      passwordMismatch.style.display = "block";
    } else if (
      passwordField.value.trim() === "" &&
      confirmPasswordField.value.trim() === ""
    ) {
      passwordField.value = defaultValue;
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "block";
      passwordMismatch.style.display = "none";
    } else if (
      passwordField.value.trim() === "" &&
      confirmPasswordField.value.trim() !== ""
    ) {
      passwordField.value = defaultValue;
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "none";
      passwordMismatch.style.display = "block";
    }
  });

  confirmPasswordField.addEventListener("change", () => {
    if (
      passwordField.value.trim() === "." &&
      confirmPasswordField.value.trim() === ""
    ) {
      confirmPasswordField.value = defaultValue;
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "block";
      passwordMismatch.style.display = "none";
    } else if (
      passwordField.value.trim() === "" &&
      confirmPasswordField.value.trim() !== "."
    ) {
      //passwordField.value = defaultValue;
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "none";
      passwordMismatch.style.display = "block";
    } else if (
      passwordField.value.trim() === "" &&
      confirmPasswordField.value.trim() === ""
    ) {
      confirmPasswordField.value = defaultValue;
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "block";
      passwordMismatch.style.display = "none";
    } else if (
      passwordField.value.trim() !== "" &&
      confirmPasswordField.value.trim() === ""
    ) {
      confirmPasswordField.value = defaultValue;
      passwordMatchFeedback.innerHTML = "";
      passwordMatch.style.display = "none";
      passwordMismatch.style.display = "block";
    }
  });
});

//edit admin
//   $(document).ready(function() {
//     $('#submitAdmin').click(function(e) {
//       e.preventDefault();

//       var formData = new FormData($('#edit-admin-form')[0]);

//       $.ajax({
//         type: 'POST',
//         url: 'admin_crud.php', // Replace 'process_form.php' with the URL of your PHP script
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//           // Handle success response here
//           //alert(response); // For demonstration purposes, you can display an alert with the response
//           window.location.href = "admin-profiles.php";
//         },
//         error: function(xhr, status, error) {
//           // Handle error
//           console.error(xhr.responseText);
//         }
//       });
//     });
//   });
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('edit-admin-form');
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
      window.location.href = 'member-profiles.php';
    }
  });

  const proceedButton = document.getElementById('proceedButton');
  proceedButton.addEventListener('click', () => {
    // Handle the proceed button action
    window.location.href = 'member-profiles.php';
  });
});
