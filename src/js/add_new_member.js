$(document).ready(function() {
  // Function to update table content
  function updateTable() {
    $.ajax({
      url: 'pool_table.php',
      type: 'GET',
      success: function(response) {
        $('#updateTable').html(response);
      }
    });
  }

  // Initial table update
  updateTable();

  // Refresh table every 5 seconds
  setInterval(updateTable, 1000); // Adjust interval as needed
});

function handleInput(event) {
  const inputValue = event.target.value.trim(); // Remove leading and trailing whitespaces
  const lastChar = inputValue.slice(-1); // Get the last character of the input

  // Check if the input is only whitespaces and it's not the last character
  if (inputValue === '' || (inputValue === ' ' && lastChar !== ' ')) {
    event.target.value = ''; // Clear the input if it's only whitespaces
  }
}


//   Updated script for password toggle
document.addEventListener("DOMContentLoaded", function() {
  const togglePassword1 = document.querySelector("#password-toggle-1");
  const passwordInput1 = document.querySelector("#password");
  const eyeIcon1 = togglePassword1.querySelector("i");

  togglePassword1.addEventListener("click", function() {
    const type =
      passwordInput1.getAttribute("type") === "password" ?
      "text" :
      "password";
    passwordInput1.setAttribute("type", type);

    // Toggle eye icon classes
    eyeIcon1.classList.toggle("fa-eye-slash");
    eyeIcon1.classList.toggle("fa-eye");
  });

  const togglePassword2 = document.querySelector("#password-toggle-2");
  const passwordInput2 = document.querySelector("#confirmPassword");
  const eyeIcon2 = togglePassword2.querySelector("i");

  togglePassword2.addEventListener("click", function() {
    const type =
      passwordInput2.getAttribute("type") === "password" ?
      "text" :
      "password";
    passwordInput2.setAttribute("type", type);

    // Toggle eye icon classes
    eyeIcon2.classList.toggle("fa-eye-slash");
    eyeIcon2.classList.toggle("fa-eye");
  });
});


//   For password checking
document.addEventListener("DOMContentLoaded", function() {
  const passwordInput = document.querySelector("#password");
  const confirmPasswordInput = document.querySelector("#confirmPassword");
  const passwordMatchFeedback = document.querySelector("#passwordMatchFeedback");
  const passwordMatch = document.querySelector("#passwordMatch");
  const passwordMismatch = document.querySelector("#passwordMismatch");

  confirmPasswordInput.addEventListener("input", function() {
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

  passwordInput.addEventListener("input", function() {
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


//add member
// $(document).ready(function() {
//   $('#confirm-add-new-member-modal-button').click(function(e) {
//     e.preventDefault(); 

//     var formData = new FormData($('#add-new-profile-form')[0]);

//     $.ajax({
//       type: 'POST',
//       url: 'member_crud.php', // Replace 'process_form.php' with the URL of your PHP script
//       data: formData,
//       processData: false,
//       contentType: false,
//       success: function(response) {
//         // Handle success response here
//         //alert(response); // For demonstration purposes, you can display an alert with the response
//         //location.reload();
//         $('#success-add-member-modal').modal('show');
//       },
//       error: function(xhr, status, error) {
//         // Handle error
//         console.error(xhr.responseText);
//       }
//     });
//   });
// });
$(document).ready(function () {
  $("#submitAddMember").click(function (e) {
    e.preventDefault();

    var formData = new FormData($("#add-new-profile-form")[0]);

    $.ajax({
      type: "POST",
      url: "member_crud.php",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Handle success response here
        // For demonstration purposes, you can display an alert with the response
        // alert(response); 
        window.location.href = "add_new_member.php";
      },
      error: function (xhr, status, error) {
        // Handle error
        console.error(xhr.responseText);
      },
    });
  });
});


//   SPassword Strength Indicator
function checkPasswordStrength(password) {
  var strength = document.getElementById('password-strength-indicator');
  var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})");
  var mediumRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})");

  if (strongRegex.test(password)) {
    strength.innerHTML = '<span style="color:green">Strong password</span>';
  } else if (mediumRegex.test(password)) {
    strength.innerHTML = '<span style="color:orange">Moderate password</span>';
  } else {
    strength.innerHTML = '<span style="color:red">Weak password</span>';
  }
}







// Disables the create button
$(document).ready(function() {
  // Function to check if all required fields are filled
  function checkInputs() {
      var firstName = $('#firstName').val();
      var lastName = $('#lastName').val();
      var birthDate = $('#birthDate').val();
      var controlNumber = $('#controlNumber').val();
      var email = $('#email').val();
      var contactNumber = $('#contactNumber').val();
      var validity = $('#validity').val();
      var password = $('#password').val();
      var confirmPassword = $('#confirmPassword').val();

      // Enable/disable create button based on input values
      if (firstName && lastName && birthDate && controlNumber && email && contactNumber && validity && password && confirmPassword) {
          $('#create-new-admin-button').prop('disabled', false);
      } else {
          $('#create-new-admin-button').prop('disabled', true);
      }
  }

  // Call checkInputs on input change
  $('#firstName, #lastName, #birthDate, #controlNumber, #email, #contactNumber, #validity, #password, #confirmPassword').on('change', function() {
      checkInputs();
  });

  // Initial check on page load
  checkInputs();
});









$(document).ready(function() {
  $("#create-new-admin-button").click(function() {
      $("#confirm-add-new-admin-modal .modal-body").html(getUserInputs());
  });
});

function getUserInputs() {
  const firstName = $("#firstName").val();
  const middleName = $("#middleName").val();
  const lastName = $("#lastName").val();
  const birthDate = $("#birthDate").val();
  const controlNumber = $("#controlNumber").val();
  const email = $("#email").val();
  const contactNumber = $("#contactNumber").val();
  const validity = $("#validity").val();


  return `
      <div class="modal-content-wrapper">
          <p><span class="modal-label">Name:</span> <span class="modal-input">${firstName} ${middleName} ${lastName}</span></p>
          <p><span class="modal-label">Birthdate:</span> <span class="modal-input">${birthDate}</span></p>
          <p><span class="modal-label">Control Number:</span> <span class="modal-input">${controlNumber}</span></p>
          <p><span class="modal-label">Email Address:</span> <span class="modal-input">${email}</span></p>
          <p><span class="modal-label">Contact Number:</span> <span class="modal-input">${contactNumber}</span></p>
          <p><span class="modal-label">Validity Date:</span> <span class="modal-input">${validity}</span></p>
      </div>
  `;
}
