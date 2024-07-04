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
        <thead>
            <tr>
              <th>Actions</th>
              <th>Name</th>
              <th>Control Number</th>
              <th>Birthday</th>
              <th>Contact Number</th>
              <th>Email Address</th>
              <th>Validity</th>
            </tr>
          </thead>
          <tbody>
                <?php foreach ($arrayMemberAccount as $memberAccount) { if($memberAccount['validity']  === "Valid"){ ?>
                    <tr>
                        <td><input type='checkbox' class='member-checkbox' name='member[]' value='<?php echo $memberAccount['customerID']; ?>'></td>
                        <td><?php echo htmlspecialchars(decryptData($memberAccount['customerFirstName'], $key) . " " . decryptData($memberAccount['customerMiddleName'], $key) . " " . decryptData($memberAccount['customerLastName'], $key)); ?></td>
                        <td><?php echo htmlspecialchars(decryptData($memberAccount['membershipID'], $key)); ?></td>
                        <td><?php echo htmlspecialchars(decryptData($memberAccount['customerBirthdate'], $key)); ?></td>
                        <td><?php echo htmlspecialchars(decryptData($memberAccount['customerNumber'], $key)); ?></td>
                        <td><?php echo htmlspecialchars(decryptData($memberAccount['customerEmail'], $key)); ?></td>
                        <td><?php echo htmlspecialchars($memberAccount['validityDate']); ?></td>
                    </tr>
                <?php } else {} } ?>
            </tbody>
        </table>
        <div>
            <form type="hidden" id="pass-member" name="pass-member">
                <input type="hidden" id="edit-member-val" name="edit-member-val" value="">
            </form>
        </div>
        <div class="mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-modal" id="edit-member" onclick="trimRate()" disabled>Edit</button>    
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-member-account-modal" id="delete-member" disabled>Delete</button>
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




    
    <div id="updateTable" style="display:none;"><!--this div's only purpose is to help table update--></div>
    <script>
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

    </script> 

    <script src="src/js/member_profiles.js"></script>
    <script src="src/js/sidebar.js"></script>


  </body>

  </html>
<?php } else {
  header("location:dashboard.php");
} ?>