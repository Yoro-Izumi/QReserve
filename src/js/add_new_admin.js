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


//   For trimming whitespacecs
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




   //add admin
//    $(document).ready(function() {
//     $('#submitAdmin').click(function(e) {
//       e.preventDefault();
//       $('#confirm-add-new-admin-modal').modal('show');
//     });
    
//     $('#confirm-add-new-admin-modal-button').click(function(e) {
//       e.preventDefault();
//       var formData = new FormData($('#add-new-profile-form')[0]);

//       $.ajax({
//         type: 'POST',
//         url: 'admin_crud.php', // Replace 'process_form.php' with the URL of your PHP script
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//           // Handle success response here
//           //alert(response); // For demonstration purposes, you can display an alert with the response
//           //location.reload();
//           $('#success-add-admin-modal').modal('show');
//         },
//         error: function(xhr, status, error) {
//           // Handle error
//           console.error(xhr.responseText);
//         }
//       });
//     });
//   });

$(document).ready(function () {
    $("#submitAddAdmin").click(function (e) {
      e.preventDefault();
  
      var formData = new FormData($("#add-new-profile-form")[0]);
  
      $.ajax({
        type: "POST",
        url: "admin_crud.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Handle success response here
          // For demonstration purposes, you can display an alert with the response
          // alert(response); 
          window.location.href = "add_new_admin.php";
        },
        error: function (xhr, status, error) {
          // Handle error
          console.error(xhr.responseText);
        },
      });
    });
  });
  



  //reload page
//   function reloadPage() {
//     location.reload();
//   }






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
        var endTime = $('#username').val();
        var adminSex = $('#adminSex').val();
        var email = $('#email').val();
        var contactNumber = $('#contactNumber').val();
        var adminShift = $('#adminShift').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();
  
        // Enable/disable create button based on input values
        if (firstName && lastName && endTime && adminSex && email && contactNumber && adminShift && password && confirmPassword) {
            $('#create-new-admin-button').prop('disabled', false);
        } else {
            $('#create-new-admin-button').prop('disabled', true);
        }
    }
  
    // Call checkInputs on input change
    $('#firstName, #lastName, #username, #adminSex, #email, #contactNumber, #adminShift, #password, #confirmPassword').on('change', function() {
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
    const username = $("#username").val();
    const adminSex = $("#adminSex").val();
    const email = $("#email").val();
    const contactNumber = $("#contactNumber").val();
    const adminShift = $("#adminShift").val();
  
  
    return `
        <div class="modal-content-wrapper">
            <p><span class="modal-label">Name:</span> <span class="modal-input">${firstName} ${middleName} ${lastName}</span></p>
            <p><span class="modal-label">Username:</span> <span class="modal-input">${username}</span></p>
            <p><span class="modal-label">Sex:</span> <span class="modal-input">${adminSex}</span></p>
            <p><span class="modal-label">Email Address:</span> <span class="modal-input">${email}</span></p>
            <p><span class="modal-label">Contact Number:</span> <span class="modal-input">${contactNumber}</span></p>
            <p><span class="modal-label">Shift:</span> <span class="modal-input">${adminShift}</span></p>
        </div>
    `;
  }
  