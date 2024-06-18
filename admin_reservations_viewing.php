<?php
session_start();
if (isset($_SESSION["userSuperAdminID"]) || isset($_SESSION["userAdminID"])) { // Check for admin session too
  $visitors = 0;
  date_default_timezone_set('Asia/Manila');
?>
  <!DOCTYPE html>
  <!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <title>Reservations</title>
    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Online Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

    <!-- Datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Datatables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- External CSS -->
    <link rel="stylesheet" href="src/css/sidebar.css" />
    <link rel="stylesheet" href="src/css/style.css" />

    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
  </head>

  <body class="body">
  <?php include "admin_sidebar.php"; ?>

    <section class="home-section">
      <h4 class="qreserve">Reservations</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab">
        <table id="example" class="table table-striped" style="width: 100%">
          <!--dynamically updates table when new data is entered-->
        </table>
      </div>
    </section>


    <!-- Modals -->
    <!-- Accept Reservation Modals -->
    <div class="modal fade" id="accept-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="warning"><img src="src/images/icons/alert.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
          </div>
          <div class="modal-body">
            Are you sure you want to accept this reservation?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="confirm-accept-reservation" class="btn btn-primary create-button" data-bs-target="#success-accept-modal" data-bs-toggle="modal">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Accept Reservation Modals -->
    <div class="modal fade" id="success-accept-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="success"><img src="src/images/icons/available-worldwide.gif" alt="Success Icon" class="modal-icons">Sucess!</h2>
          </div>
          <div class="modal-body">
            You have successfully accepted this reservation.
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary create-button" onclick="reload()" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Reject Reservation Modals -->
    <div class="modal fade" id="reject-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="warning"><img src="src/images/icons/alert.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
          </div>
          <div class="modal-body">
            Are you sure you want to reject this reservation?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="confirm-reject-reservation" class="btn btn-primary create-button" data-bs-target="#success-reject-modal" data-bs-toggle="modal">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Reject Reservation Modals -->
    <div class="modal fade" id="success-reject-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="deleted"><img src="src/images/icons/cancel.gif" alt="Wait Icon" class="modal-icons">Rejected!</h2>
          </div>
          <div class="modal-body">
            You have successfully rejected this reservation.
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary create-button" onclick="reload()" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>


    <input type="text" id="qrInput" autofocus>
      <div id="result" type='hidden'></div>

    <!-- Modal for showing the reservation details on qr scan-->
    <div class="modal fade" id="reservation_details" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="wait">
                <div class="modal-header">
                    <h2 class="modal-title fw-bold text-center" id="success">
                        <img src="src/images/icons/available-worldwide.gif" alt="Wait Icon" class="modal-icons">Reservation Details
                    </h2>
                </div>
                <div class="modal-body text-center" id="modal-body-content">
                    (Details Here)
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary create-button" id="submitReserve" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>



    <style>
        /* Hide div result */
        #result {
            position: absolute;
            left: -9999px;
        }
    </style>
    <style>
        /* Hide the QR input field */
        #qrInput {
            position: absolute;
            left: -9999px;
        }
    </style>













    <script>
      $(document).ready(function() {
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

      let sidebar = document.querySelector(".sidebar");
      let closeBtn = document.querySelector("#btn");
      let searchBtn = document.querySelector(".bx-search");

      closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");
        menuBtnChange(); //calling the function(optional)
      });

      searchBtn.addEventListener("click", () => {
        // Sidebar open when you click on the search icon
        sidebar.classList.toggle("open");
        menuBtnChange(); //calling the function(optional)
      });

      // following are the code to change sidebar button(optional)
      function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
          closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the icons class
        } else {
          closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the icons class
        }
      }
    </script>

<script>
  $(document).ready(function() {
    var intervalID; // Define intervalID variable outside to make it accessible across functions

    // Function to update table content
    function updateTable() {
      $.ajax({
        url: 'reservation_table.php', // Change this to the PHP file that contains the table content
        type: 'GET',
        success: function(response) {
          $('#example').html(response);
          attachCheckboxListeners(); // Attach event listeners for checkboxes after AJAX call
        }
      });
    }

    // Function to start interval
    function startInterval() {
      intervalID = setInterval(updateTable, 1000); // Adjust interval as needed
    }

    // Function to stop interval
    function stopInterval() {
      clearInterval(intervalID);
    }

    // Attach event listeners for checkboxes
function attachCheckboxListeners() {
    const checkboxes = document.querySelectorAll('.reservation-checkbox');
    //var editReservationButton = document.getElementById('edit-reservation');
    //var deleteReservationButton = document.getElementById('delete-reservation');
    var checkedCount = 0; var checkBoxValue;

    //editAdminButton.disabled = true;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                checkedCount++;
                if (checkedCount === 1) {
                    // If only one checkbox is checked, set its value
                    // Ensure that checkboxValue is defined and refers to the appropriate element
                    checkboxValue = this.value; // You need to define checkboxValue
                }
            } else {
                checkedCount--;
                if (checkedCount === 1) {
                    // If only one checkbox remains checked after unchecking this one, find and set its value
                    const remainingCheckbox = [...checkboxes].find(checkbox => checkbox.checked);
                    if (remainingCheckbox) {
                        checkboxValue.value = remainingCheckbox.value; // You need to define checkboxValue
                    }
                } else {
                    // If no or multiple checkboxes are checked, clear the value
                    checkboxValue.value = " "; // You need to define checkboxValue
                }
            }
            //editAdminButton.disabled = checkedCount !== 1; // Disable button if no checkbox is checked or more than one checkbox is checked

            // Stop or start interval based on checkbox status
            if (checkedCount > 0) {
                stopInterval();
            } else {
                startInterval();
            }
        });
    });
}


    // Initial table update and start interval
    updateTable();
    startInterval();
  });
</script>

<!--script updating reservation status-->
<script>
  $(document).ready(function(){
        // AJAX code to handle reject reservation
        $("#confirm-reject-reservation").click(function(){
            // Array to store IDs of selected rows
            var selectedRowsReject = [];

            // Iterate through each checked checkbox
            $(".reservation-checkbox:checked").each(function(){
                // Push the value (ID) of checked checkbox into the array
                selectedRowsReject.push($(this).val());
            });

            // AJAX call to send selected rows IDs to delete script
            $.ajax({
                url: "reservation_crud.php",
                type: "POST",
                data: {selectedRowsReject: selectedRowsReject},
                success: function(response){
                    // Reload the page or update the table as needed
                   // location.reload(); // For example, reload the page after deletion
                },
                error: function(xhr, status, error){
                    //console.error("Error:", error);
                }
            });
        });
    });

    $(document).ready(function(){
        // AJAX code to handle accept reservation
        $("#confirm-accept-reservation").click(function(){
            // Array to store IDs of selected rows
            var selectedRowsAccept = [];

            // Iterate through each checked checkbox
            $(".reservation-checkbox:checked").each(function(){
                // Push the value (ID) of checked checkbox into the array
                selectedRowsAccept.push($(this).val());
            });

            // AJAX call to send selected rows IDs to delete script
            $.ajax({
                url: "reservation_crud.php",
                type: "POST",
                data: {selectedRowsAccept: selectedRowsAccept},
                success: function(response){
                    // Reload the page or update the table as needed
                   // location.reload(); // For example, reload the page after deletion
                },
                error: function(xhr, status, error){
                    //console.error("Error:", error);
                }
            });
        });
    });

function reload(){
  location.reload();
}



  // Function to fetch data based on the scanned QR code ID
  function fetchInfo(id) {
      fetch('zgetInfo.php?id=' + id)
          .then(response => response.json())
          .then(data => {
              if (data.error) {
                  document.getElementById('result').innerText = data.error;
                  document.getElementById('modal-body-content').innerText = data.error;
              } else {
                  const info = data.info;
                  const infoText = `
                      <p><strong>Reservation ID:</strong> ${info.reservationID}</p>
                      <p><strong>Member ID:</strong> ${info.memberID}</p>
                      <p><strong>Table Number:</strong> ${info.tableNumber}</p>
                      <p><strong>Reservation Status:</strong> ${info.reservationStatus}</p>
                      <p><strong>Reservation Date:</strong> ${info.reservationDate}</p>
                      <p><strong>Reservation Time Start:</strong> ${info.reservationTimeStart}</p>
                      <p><strong>Reservation Time End:</strong> ${info.reservationTimeEnd}</p>
                  `;
                  document.getElementById('result').innerText = infoText;

                  // Show the modal with the fetched data
                  document.getElementById('modal-body-content').innerHTML = infoText;
                  $('#reservation_details').modal('show');
              }
          })
          .catch(error => {
              console.error('Error:', error);
              document.getElementById('result').innerText = 'An error occurred while fetching the data.';
              document.getElementById('modal-body-content').innerText = 'An error occurred while fetching the data.';
          });
  }

  // Function to hide the keyboard on mobile devices
  function hideMobileKeyboard() {
      // Temporarily create an input, focus it, then blur it
      const field = document.createElement('input');
      field.setAttribute('type', 'text');
      field.setAttribute('style', 'position: absolute; top: -9999px;');
      document.body.appendChild(field);
      field.focus();
      field.blur();
      document.body.removeChild(field);
  }

  // Event listener for the input field
  document.addEventListener('DOMContentLoaded', () => {
      const qrInput = document.getElementById('qrInput');
      const formInputs = document.querySelectorAll('form input');

      // Ensure the QR input field is always focused
      function focusQrInput() {
          if (document.activeElement !== qrInput) {
              qrInput.focus();
          }
      }

      qrInput.addEventListener('input', () => {
          const id = qrInput.value.trim();
              if (id) {
                  fetchInfo(id);
                  qrInput.value = '';  // Clear the input field after scanning
                  hideMobileKeyboard();  // Hide the mobile keyboard
              }
      });

      // Add event listeners to all form inputs to manage focus
      formInputs.forEach(input => {
          input.addEventListener('focus', () => {
              // Temporarily disable QR input focus
              document.removeEventListener('click', focusQrInput);
          });

          input.addEventListener('blur', () => {
              // Re-enable QR input focus
              document.addEventListener('click', focusQrInput);
          });
      });

      // Initial focus on the QR input field
      focusQrInput();
      // Ensure the QR input field remains focused after interactions
      document.addEventListener('click', focusQrInput);

      // Close button in the modal
      document.getElementById('submitReserve').addEventListener('click', () => {
          $('#reservation_details').modal('hide');
      });
  });

  
</script>
    


  </body>

  </html>
<?php } else {
  header("location:login.php");
} ?>