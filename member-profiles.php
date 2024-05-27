<?php
session_start();
date_default_timezone_set('Asia/Manila');
include "connect_database.php";
include "src/get_data_from_database/get_member_account.php";
include "src/get_data_from_database/get_customer_information.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";

if (isset($_SESSION["userSuperAdminID"])) {
  $superAdminID = $_SESSION["userSuperAdminID"];
?>
  <!DOCTYPE html>
  <!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <title>Member Profile</title>
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
        <h4 class="qreserve">Member Accounts</h4>
        <a href="add_new_member.php" type="button" class="btn btn-primary fw-bold start-button" id="add-new-profile">Add New Member</a>
      </div>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab" id="profile-management">
        <table id="example" class="table table-striped" style="width: 100%">
          <!--member will dynamically update when new data is inserted-->
        </table>
        <div class="mt-3">
          <!-- <button type="button" class="btn btn-primary" onclick="editSelected()">Edit Selected</button>
          <button type="button" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button>          -->
          <button type="button" class="btn btn-primary" id="edit-member">Edit Selected</button>
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-member-account-modal" id="delete-member">Delete Selected</button>
          <input type="hidden" id="edit-member-val" value="">
        </div>
      </div>
    </section>



    <!-- Delete Modal -->
    <div class="modal fade" id="delete-member-account-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="warning"><img src="src/images/icons/alert.gif" alt="Wait Icon" class="modal-icons">Warning!</h2>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this account?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
            <button type="button" id="confirm-delete-member" class="btn btn-primary create-button" data-bs-target="#success-delete-member-account-modal" data-bs-toggle="modal">Confirm</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Delete Modal -->
    <div class="modal fade" id="success-delete-member-account-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="wait">
          <div class="modal-header">
            <h2 class="modal-title  fw-bold text-center" id="deleted"><img src="src/images/icons/trash-bin.gif" alt="Delete Icon" class="modal-icons">Deleted!</h2>
          </div>
          <div class="modal-body">
            You have successfully deleted this account.
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary create-button" id="proceed" data-bs-target="#" data-bs-toggle="modal" onclick="reload()">Proceed</button>
          </div>
        </div>
      </div>
    </div>






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
<script>
  $(document).ready(function() {
    var intervalID; // Define intervalID variable outside to make it accessible across functions

    // Function to update table content
    function updateTable() {
      $.ajax({
        url: 'member_table.php', // Change this to the PHP file that contains the table content
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
    const checkboxes = document.querySelectorAll('.member-checkbox');
    var editMemberButton = document.getElementById('edit-member');
    //var deleteReservationButton = document.getElementById('delete-reservation');
    var checkedCount = 0; var checkBoxValue;

    editMemberButton.disabled = true;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                checkedCount++;
                if (checkedCount === 1) {
                    // If only one checkbox is checked, set its value
                    // Ensure that checkboxValue is defined and refers to the appropriate element
                    checkboxValue = this.value; // You need to define checkboxValue
                    document.getElementById('edit-member-val').value =  this.value;
                }
            } else {
                checkedCount--;
                if (checkedCount === 1) {
                    // If only one checkbox remains checked after unchecking this one, find and set its value
                    const remainingCheckbox = [...checkboxes].find(checkbox => checkbox.checked);
                    if (remainingCheckbox) {
                        checkboxValue.value = remainingCheckbox.value; // You need to define checkboxValue
                        document.getElementById('edit-member-val').value =  remainingCheckbox.value;
                      }
                } else {
                    // If no or multiple checkboxes are checked, clear the value
                    checkboxValue.value = " "; // You need to define checkboxValue
                }
            }
            editMemberButton.disabled = checkedCount !== 1; // Disable button if no checkbox is checked or more than one checkbox is checked

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

<!--script for deleting admin-->
<script>
  $(document).ready(function(){
        // AJAX code to handle deletion
        $("#confirm-delete-member").click(function(){
            // Array to store IDs of selected rows
            var selectedRows = [];

            // Iterate through each checked checkbox
            $(".member-checkbox:checked").each(function(){
                // Push the value (ID) of checked checkbox into the array
                selectedRows.push($(this).val());
            });

            // AJAX call to send selected rows IDs to delete script
            $.ajax({
                url: "member_crud.php",
                type: "POST",
                data: {selectedRows: selectedRows},
                success: function(response){
                    // Reload the page or update the table as needed
                    //location.reload(); // For example, reload the page after deletion
                },
                error: function(xhr, status, error){
                    //console.error("Error:", error);
                }
            });
        });
    });

//reload page
function reload(){
  location.reload();
}
//send data to edit member page
$("#edit-member").click(function(){
            // Get the value from the input field
            var value = document.getElementById('edit-member-val').value;

            // Redirect to the PHP file with the value as a query parameter
            window.location.href = 'edit_member_account.php?value=' + encodeURIComponent(value);
        });
</script>

  </body>

  </html>
<?php } else {
  header("location:dashboard.php");
} ?>