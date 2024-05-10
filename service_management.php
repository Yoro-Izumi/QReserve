<?php
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION["userSuperAdminID"])) {
  include "connect_database.php";
  include "src/get_data_from_database/get_services.php";
?>
  <!DOCTYPE html>
  <!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <title>Services</title>
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

  <body>
    <?php include "superadmin_sidebar.php"; ?>

  <section class="home-section">
    <div class="d-flex justify-content-between align-items-center">
    <h4 class="qreserve">Service Management</h4>
        <!-- <a href="add_new_service.php" type="button" class="btn btn-primary fw-bold mb-0" id="add-new-profile">Add New Service</a> -->
        <button type="button" class="btn btn-primary fw-bold start-button" data-bs-toggle="modal" data-bs-target="#add-service-modal" id="add-new-profile">Add New Service</button>
    </div>
    <hr class="my-4 mb-3 mt-3">
    <div class="container-fluid dashboard-square-kebab" id="profile-management">
      <table id="example" class="table table-striped" style="width: 100%">
        <!--dynamically changes the table when new data is inserted-->
      </table>
      <div class="mt-3">
        <!-- <button type="button" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button> -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-service-modal" id="delete-service">Delete Selected</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-modal" id="edit-service">Edit Selected</button>
        <!-- <button type="button" class="btn btn-primary" onclick="editSelected()">Edit Selected</button> -->
      </div>
    </div>
  </section>






    <!-- Modals -->

    <!-- Add New Service Modal -->
    <div class="modal fade" id="add-service-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered service-modal" id="add-new-service-modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="staticBackdropLabel"><img src="src/images/icons/add.gif" alt="Wait Icon" class="modal-icons">Add New Service</h2>
          </div>
          <div class="modal-body">
          <form class="needs-validation" id="add-new-service-form" novalidate action="service_crud.php" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class="col-12 col-md-12 mb-3">
                  <label for="serviceName" class="form-label">Service Name <span>*</span></label>
                  <input type="text" class="form-control" name="serviceName" id="serviceName" placeholder="Enter service name here" required pattern="^\S(?:.*\S)?$" oninvalid="this.setCustomValidity('Please enter a valid service name.')" oninput="handleInput(event);" />
                  <div class="valid-feedback">Looks good!</div>
                  <div class="invalid-feedback">
                    Please enter a valid first name.
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <label for="serviceRate" class="form-label">Rate</label>
                  <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="text" class="form-control" name="serviceRate" id="serviceRate" placeholder="Enter rate here per hour" pattern="[0-9-]*" oninput="this.value = this.value.replace(/[^0-9-]/g, '')" title="" maxlength="7" minlength="7" required pattern="[0-9-]*" oninput="this.value = this.value.replace(/[^0-9-]/g, '')" title="" maxlength="7" minlength="7" required />
                  </div>
                  <div class="valid-feedback">Looks good!</div>
                  <div class="invalid-feedback">Please enter a valid rate.</div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <label for="text" class="form-label">Capacity <span>*</span></label>
                  <input type="text" class="form-control" name="capacity" id="capacity" placeholder="Enter service capacity here" maxlength="3" required oninvalid="this.setCustomValidity('Please enter a valid service capacity')" oninput="this.setCustomValidity(''); if (!/^\d*$/.test(this.value)) this.value = ''; this.value = this.value.replace(/\s/g, '')" />

                  <!-- <div class="valid-feedback">
                Looks good!
            </div> -->
                  <div class="invalid-feedback">
                    Please enter a valid capacity.
                  </div>
                </div>
                <div class="col-12 col-md-12 mb-3">
                  <label for="image" class="form-label">Image <span>*</span></label>
                  <input type="file" class="form-control" name="serviceImage" id="serviceImage" accept=".jpg, .jpeg, .png" required>
                  <div class="invalid-feedback">
                    Please enter a valid capacity.
                  </div>
                </div>
              </div>
              <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal" onclick="resetForm()">Cancel</button>
            <button type="button" class="btn btn-primary create-button" data-bs-target="#confirm-add-new-service-modal" data-bs-toggle="modal" id="confirm_add_service_button">Confirm</button>
          </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- Confirmation Add Service Modal -->
    <div class="modal fade" id="confirm-add-new-service-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" id="add-new-service-modal">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="wait"><img src="src/images/icons/hourglass.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
            <h6 class="mt-2 mb-0 pb-0">Here's what we received:</h6>
          </div>
          <div class="modal-body">
            dito nakalagay yung mga contents sa naunang modal
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" onclick="reload()" name="confirm_add_service_button" id="confirm_add_service_button" class="btn btn-primary create-button" data-bs-target="#success-add-service-modal" data-bs-toggle="modal">Confirm</button>
        </form>
          </div>
        </div>
      </div>
    </div>


    <!-- Success Add New Service Modal -->
    <div class="modal fade" id="success-add-service-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="success"><img src="src/images/icons/available-worldwide.gif" alt="Wait Icon" class="modal-icons">Success!</h2>
          </div>
          <div class="modal-body">
            You have successfully deleted this service.
          </div>
          <div class="modal-footer">
            <button onclick="reload()" class="btn btn-primary create-button" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="delete-service-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="warning"><img src="src/images/icons/alert.gif" alt="Wait Icon" class="modal-icons">Warning!</h2>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this service?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="confirm-delete-button" class="btn btn-primary create-button" data-bs-target="#success-delete-modal" data-bs-toggle="modal">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Delete Modal -->
    <div class="modal fade" id="success-delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="deleted"><img src="src/images/icons/trash-bin.gif" alt="Delete Icon" class="modal-icons">Deleted!</h2>
          </div>
          <div class="modal-body">
            You have successfully deleted this service.
          </div>
          <div class="modal-footer">
            <button onclick="reload()" class="btn btn-primary create-button" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade" id="edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered service-modal" id="add-new-service-modal">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title  fw-bold text-center" id="staticBackdropLabel"><img src="src/images/icons/pencil.gif" alt="Wait Icon" class="modal-icons">Edit Service</h1>
          </div>
          <div class="modal-body">
            
            <form class="needs-validation" id="edit-new-service-form" novalidate>
              <input type="hidden" name="editID" id="editID" value="">
              <div class="row">
                <div class="col-12 col-md-12 mb-3">
                  <label for="serviceName" class="form-label">Service Name <span>*</span></label>
                  <input type="text" class="form-control" name="editServiceName" id="editServiceName" placeholder="Enter service name here" required pattern="^\S(?:.*\S)?$" oninvalid="this.setCustomValidity('Please enter a valid service name.')" oninput="handleInput(event);" />
                  <div class="valid-feedback">Looks good!</div>
                  <div class="invalid-feedback">
                    Please enter a valid first name.
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <label for="serviceRate" class="form-label">Rate</label>
                  <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="text" class="form-control" name="editServiceRate" id="editServiceRate" placeholder="Enter rate here per hour" pattern="[0-9-]*" oninput="this.value = this.value.replace(/[^0-9-]/g, '')" title="" maxlength="7" minlength="7" required pattern="[0-9-]*" oninput="this.value = this.value.replace(/[^0-9-]/g, '')" title="" maxlength="7" minlength="7" required />
                  </div>
                  <div class="valid-feedback">Looks good!</div>
                  <div class="invalid-feedback">Please enter a valid rate.</div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <label for="text" class="form-label">Capacity <span>*</span></label>
                  <input type="text" class="form-control" name="capacity" id="capacity" placeholder="Enter service capacity here" maxlength="3" required oninvalid="this.setCustomValidity('Please enter a valid service capacity')" oninput="this.setCustomValidity(''); if (!/^\d*$/.test(this.value)) this.value = ''; this.value = this.value.replace(/\s/g, '')" />

                  <!-- <div class="valid-feedback">
                Looks good!
            </div> -->
                  <div class="invalid-feedback">
                    Please enter a valid capacity.
                  </div>
                </div>
                <div class="col-12 col-md-12 mb-3">
                  <label for="image" class="form-label">Image <span>*</span></label>
                  <input type="file" class="form-control" name="editImage" id="editImage" accept=".jpg, .jpeg, .png" required>
                  <div class="invalid-feedback">
                    Please enter a valid capacity.
                  </div>
                </div>
              </div>
              <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary create-button" data-bs-target="#confirm-edit-modal" data-bs-toggle="modal">Confirm</button>
          </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- Confirm Edit Modal -->
    <div class="modal fade" id="confirm-edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="wait"><img src="src/images/icons/hourglass.gif" alt="Wait Icon" class="modal-icons">Wait!</h2>
          </div>
          <div class="modal-body">
            Are you sure you want to edit this service?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-target="#edit-modal" data-bs-toggle="modal">Cancel</button>
            <button type="button" id="confirm-edit-service" class="btn btn-primary create-button" data-bs-target="#success-edit-modal" data-bs-toggle="modal">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="success-edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="success"><img src="src/images/icons/hourglass.gif" alt="Success Icon" class="modal-icons">Success!</h2>
          </div>
          <div class="modal-body">
            You have successfully edited this service.
          </div>
          <div class="modal-footer">
            <button onclick="reload()" class="btn btn-primary create-button" id="proceed" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>






    <!-- For trimming whitespacecs -->
    <script>
      function handleInput(event) {
        const inputValue = event.target.value.trim(); // Remove leading and trailing whitespaces
        const lastChar = inputValue.slice(-1); // Get the last character of the input

        // Check if the input is only whitespaces and it's not the last character
        if (inputValue === '' || (inputValue === ' ' && lastChar !== ' ')) {
          event.target.value = ''; // Clear the input if it's only whitespaces
        }
      }
    </script>


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

      // JavaScript functions for handling bulk actions
      function deleteSelected() {
        // Implement delete logic here
        console.log("Delete selected rows");
      }

      function editSelected() {
        // Implement edit logic here
        console.log("Edit selected rows");
      }
    </script>

    <script>
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

    <!--script for crud service-->
    <script>
      //add service
      $(document).ready(function() {
        $('#confirm_add_service_button').click(function(e) {
          e.preventDefault();

          var formData = new FormData($('#add-new-service-form')[0]);

          $.ajax({
            type: 'POST',
            url: 'service_crud.php', // Replace 'process_form.php' with the URL of your PHP script
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              // Handle success response here
              alert(response); // For demonstration purposes, you can display an alert with the response
              location.reload();
            },
            error: function(xhr, status, error) {
              // Handle error
              console.error(xhr.responseText);
            }
          });
        });
      });
    </script>
    <!--script that disables button if no check box is clicked-->
    <script>
      $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
          var anyChecked = $('input[type="checkbox"]:checked').length > 0;
          $('edit-service').prop('disabled', !anyChecked);
          $('delete-service').prop('disabled', !anyChecked);
        });
      });
    </script>
    <!--script for deleting service-->
    <script>
      $(document).ready(function() {
        // AJAX code to handle deletion
        $("#delete-service").click(function() {
          // Array to store IDs of selected rows
          var selectedRows = [];

          // Iterate through each checked checkbox
          $(".service-checkbox:checked").each(function() {
            // Push the value (ID) of checked checkbox into the array
            selectedRows.push($(this).val());
          });

          // AJAX call to send selected rows IDs to delete script
          $.ajax({
            url: "service_crud.php",
            type: "POST",
            data: {
              selectedRows: selectedRows
            },
            success: function(response) {
              // Reload the page or update the table as needed
              location.reload(); // For example, reload the page after deletion
            },
            error: function(xhr, status, error) {
              //console.error("Error:", error);
            }
          });
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        var intervalID; // Define intervalID variable outside to make it accessible across functions

        // Function to update table content
        function updateTable() {
          $.ajax({
            url: 'service_table.php', // Change this to the PHP file that contains the table content
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
          const checkboxes = document.querySelectorAll('.service-checkbox');
          const checkboxValue = document.getElementById('editID');
          var editServiceButton = document.getElementById('edit-service');
          var deleteServiceButton = document.getElementById('delete-service');
          var checkedCount = 0;

          editServiceButton.disabled = true;

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        if (this.checked) {
            checkedCount++;
            
            if (checkedCount === 1) {
                // If only one checkbox is checked, set its value
            checkboxValue.value = this.value;
                
                
            }
        } else {
            checkedCount--;
            if (checkedCount === 1) {
                // If only one checkbox remains checked after unchecking this one, find and set its value
                const remainingCheckbox = [...checkboxes].find(checkbox => checkbox.checked);
                if (remainingCheckbox) {
                    checkboxValue.value = remainingCheckbox.value;
                  }
                } else {
                  // If no or multiple checkboxes are checked, clear the value
                  checkboxValue.value = " ";
                }
              }
              editServiceButton.disabled = checkedCount !== 1; // Disable button if no checkbox is checked or more than one checkbox is checked

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


    <!-- For Service Rate -->
    <script>
      $(document).ready(function() {
        // Update the displayed value when the input changes
        $('#serviceRate').on('input', function() {
          // Get the entered value without the currency symbol and commas
          var inputValue = $(this).val().replace(/^₱|,/g, '');

          // Remove non-numeric characters
          var numericValue = inputValue.replace(/[^\d.]/g, '');

          // Remove leading zeros
          numericValue = numericValue.replace(/^0+(\d)/, '$1');

          // Format with commas for thousands or hundred thousands
          numericValue = numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

          // Limit to two decimal places
          var parts = numericValue.split('.');
          if (parts.length > 1) {
            numericValue = parts[0] + '.' + parts[1].slice(0, 2);
          }

          // Update the input value with the formatted value and add the currency symbol
          $(this).val(numericValue === '0' ? '' : '₱' + numericValue);
        });

        // Submit the form with the formatted value when needed
        $('#add-new-service').submit(function() {
          // Remove currency symbol and commas before submitting the form
          var inputValue = $('#serviceRate').val().replace(/^₱|,/g, '');
          var numericValue = inputValue.replace(/[^\d.]/g, '');

          // Remove leading zeros
          numericValue = numericValue.replace(/^0+(\d)/, '$1');

          // Store the numeric value separately for comparison
          $('#serviceRate').data('numericValue', numericValue);

          // Keep the formatted value with the currency symbol for display
          $('#serviceRate').val(numericValue === '0' ? '' : '₱' + numericValue);
        });
      });
    </script>

    <!-- Resets the Edit Modal when Cancel is selected -->
    <script>
      function resetForm() {
        document.getElementById('add-new-service-form').reset();
      }
    </script>



  </body>

  </html>
<?php } else {
  header("location:login.php");
} ?>