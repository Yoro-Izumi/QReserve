$(document).ready(function () {
  $('.toggle-password').click(function () {
    const input = $(this).siblings('input');
    const icon = $(this).children('i');
    const type = input.attr('type') === 'password' ? 'text' : 'password';
    input.attr('type', type);
    icon.toggleClass('fa-eye-slash fa-eye');
  });

  // Handle AJAX for sending reset PIN
  $('#forgetPassButton').click(function () {
    const form = $('#send-pin-form');
    $.ajax({
      url: 'send_pin.php',
      type: 'POST',
      data: form.serialize(),
      success: function (response) {
        const res = JSON.parse(response);
        if (res.status === 'success') {
          $('#forget-password-modal').modal('hide');
          $('#continue-forget-password').modal('show');
        } else {
          $('#sendPinError').text(res.message).show();
        }
      },
      error: function () {
        $('#sendPinError').text('Error sending PIN.').show();
      }
    });
  });

  // Handle AJAX for submitting new password
  $('#submitPinButton').click(function () {
    const form = $('#submit-new-pass');
    if ($('#new-password').val() !== $('#confirm-password').val()) {
      $('#resetPasswordError').text('Passwords do not match.').show();
      return;
    }
    $.ajax({
      url: 'submit_new_password.php',
      type: 'POST',
      data: form.serialize(),
      success: function (response) {
        const res = JSON.parse(response);
        if (res.status === 'success') {
          $('#continue-forget-password').modal('hide');
          $('#success-forget-password').modal('show');
        } else {
          $('#resetPasswordError').text(res.message).show();
        }
      },
      error: function () {
        $('#resetPasswordError').text('Error resetting password.').show();
      }
    });
  });
});

// Password Strength Indicator
function checkPasswordStrength(password) {
  const strength = document.getElementById('password-strength-indicator');
  const strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})");
  const mediumRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})");

  if (strongRegex.test(password)) {
    strength.innerHTML = '<span style="color:green">Strong password</span>';
  } else if (mediumRegex.test(password)) {
    strength.innerHTML = '<span style="color:orange">Moderate password</span>';
  } else {
    strength.innerHTML = '<span style="color:red">Weak password</span>';
  }
}

// Password Match Validation
document.addEventListener("DOMContentLoaded", function() {
  const passwordInput = document.querySelector("#new-password");
  const confirmPasswordInput = document.querySelector("#confirm-password");
  const passwordMatch = document.querySelector("#passwordMatch");
  const passwordMismatch = document.querySelector("#passwordMismatch");

  function validatePasswordMatch() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    if (password === confirmPassword) {
      passwordMatch.style.display = "block";
      passwordMismatch.style.display = "none";
    } else {
      passwordMatch.style.display = "none";
      passwordMismatch.style.display = "block";
    }
  }

  passwordInput.addEventListener("input", validatePasswordMatch);
  confirmPasswordInput.addEventListener("input", validatePasswordMatch);
});$(document).ready(function () {
      $('.toggle-password').click(function () {
        const input = $(this).siblings('input');
        const icon = $(this).children('i');
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        icon.toggleClass('fa-eye-slash fa-eye');
      });

      // Handle AJAX for sending reset PIN
      $('#forgetPassButton').click(function () {
        const form = $('#send-pin-form');
        $.ajax({
          url: 'send_pin.php',
          type: 'POST',
          data: form.serialize(),
          success: function (response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
              $('#forget-password-modal').modal('hide');
              $('#continue-forget-password').modal('show');
            } else {
              $('#sendPinError').text(res.message).show();
            }
          },
          error: function () {
            $('#sendPinError').text('Error sending PIN.').show();
          }
        });
      });

      // Handle AJAX for submitting new password
      $('#submitPinButton').click(function () {
        const form = $('#submit-new-pass');
        if ($('#new-password').val() !== $('#confirm-password').val()) {
          $('#resetPasswordError').text('Passwords do not match.').show();
          return;
        }
        $.ajax({
          url: 'submit_new_password.php',
          type: 'POST',
          data: form.serialize(),
          success: function (response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
              $('#continue-forget-password').modal('hide');
              $('#success-forget-password').modal('show');
            } else {
              $('#resetPasswordError').text(res.message).show();
            }
          },
          error: function () {
            $('#resetPasswordError').text('Error resetting password.').show();
          }
        });
      });
    });

    // Password Strength Indicator
    function checkPasswordStrength(password) {
      const strength = document.getElementById('password-strength-indicator');
      const strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})");
      const mediumRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})");

      if (strongRegex.test(password)) {
        strength.innerHTML = '<span style="color:green">Strong password</span>';
      } else if (mediumRegex.test(password)) {
        strength.innerHTML = '<span style="color:orange">Moderate password</span>';
      } else {
        strength.innerHTML = '<span style="color:red">Weak password</span>';
      }
    }

    // Password Match Validation
    document.addEventListener("DOMContentLoaded", function() {
      const passwordInput = document.querySelector("#new-password");
      const confirmPasswordInput = document.querySelector("#confirm-password");
      const passwordMatch = document.querySelector("#passwordMatch");
      const passwordMismatch = document.querySelector("#passwordMismatch");

      function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        if (password === confirmPassword) {
          passwordMatch.style.display = "block";
          passwordMismatch.style.display = "none";
        } else {
          passwordMatch.style.display = "none";
          passwordMismatch.style.display = "block";
        }
      }

      passwordInput.addEventListener("input", validatePasswordMatch);
      confirmPasswordInput.addEventListener("input", validatePasswordMatch);
    });



    function validatePassword(event) {
      // Allow only alphabetic characters, numbers, and specified special characters
      const regex = /^[a-zA-Z0-9._%+\-!@#$^&*]*$/;
      if (!regex.test(event.target.value)) {
        event.target.value = event.target.value.replace(/[^a-zA-Z0-9._%+\-!@#$^&*]/g, '');
      }
    }
    



          //For Email 
// function validateEmail(event) {
//   var emailInput = event.target.value;

//   event.target.value = emailInput.replace(/\s+/g, '');

//   emailInput = event.target.value.trim();

//   var isValid = /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(emailInput);

//   if (!isValid) {
//     document.getElementById("emailError").style.display = "block";
//     event.target.setCustomValidity("Please enter a valid email address.");
//   } else {
//     document.getElementById("emailError").style.display = "none";
//     event.target.setCustomValidity("");
//   }
// }
// document.getElementById("email").addEventListener("input", validateEmail);

//           <div id="sendPinError" class="alert alert-danger" role="alert" style="display: none;"></div>





              // Validation for Control Number
    function validateControlNumber() {
      const controlNumber = document.getElementById('controlNumber').value;
      const errorMessageDiv = document.getElementById('error-message');
      const pattern = /^[0-9]{1,4}-[0-9]{1,4}$/;

      if (!pattern.test(controlNumber)) {
        errorMessageDiv.textContent = 'Please input a valid control number.';
        errorMessageDiv.classList.remove('d-none');
        return false;
      }

      errorMessageDiv.classList.add('d-none');
      return true;
    }




    function validatePassword(event) {
      // Allow only alphabetic characters, numbers, and specified special characters
      const regex = /^[a-zA-Z0-9._%+\-!@#$^&*]*$/;
      if (!regex.test(event.target.value)) {
        event.target.value = event.target.value.replace(/[^a-zA-Z0-9._%+\-!@#$^&*]/g, '');
      }
    }

























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