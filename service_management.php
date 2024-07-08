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
        <!-- <button type="button" class="btn btn-primary fw-bold start-button" data-bs-toggle="modal" data-bs-target="#add-service-modal" id="add-new-profile">Add New Service</button> -->
        <a href="add_new_service.php" type="button" class="btn btn-primary fw-bold start-button" id="add-new-profile">Add New Service</a>
      </div>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab" id="profile-management">
        <table id="example" class="table table-striped" style="width: 100%">
          <thead>
            <tr>
              <th class="text-medium-brown">Action</th>
              <th class="text-medium-brown">Name</th>
              <th class="text-medium-brown">Capacity</th>
              <th class="text-medium-brown">Rate</th>
              <th class="text-medium-brown">Image</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($arrayServices as $services) : ?>
              <tr>
                <!-- <td><input type='checkbox' onchange='getSelected(this)' class='service-checkbox' name='serviceID[]' value='<?php echo $services['serviceID']; ?>'></td> -->
                <td><input type='checkbox' class='admin-checkbox' name='admin[]' value='<?php echo $services['serviceID']; ?>'></td>
                <td><?php echo htmlspecialchars(substr($services['serviceName'], 0, 15)) . '...'; ?></td>
                <td><?php echo htmlspecialchars($services['serviceCapacity']); ?></td>
                <td>₱<?php echo htmlspecialchars($services['serviceRate']); ?></td>
                <td>
    <a href="#" class="image-link" data-bs-toggle="modal" data-bs-target="#image-modal" 
       data-image="src/images/Services/<?php echo htmlspecialchars($services['serviceImage']); ?>">
       <?php echo htmlspecialchars(strlen($services['serviceImage']) > 15 ? substr($services['serviceImage'], 0, 15) . '...' : $services['serviceImage']); ?>
    </a>
</td>

            <?php endforeach; ?>
          </tbody>
        </table>
        <div>
            <form type="hidden" id="pass-admin" name="pass-admin">
                <input type="hidden" id="edit-admin-val" name="edit-admin-val" value="">
            </form>
        </div>
        <div class="mt-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-modal" id="edit-admin" onclick="trimRate()" disabled>Edit</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-service-modal" id="delete-admin" disabled>Delete</button>
        </div>
      </div>
    </section>

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
            <button onclick="reload()" class="btn btn-primary create-button" id="proceed-delete-button" data-bs-target="#" data-bs-toggle="modal">Proceed</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="image-modal" tabindex="-1" aria-labelledby="image-modal-label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="image-modal-label">Service Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <img id="image-modal-img" src="" alt="Service Image" class="img-fluid">
          </div>
        </div>
      </div>
    </div>

    <div id="updateTable" style="display:none;"></div>
    <script>
      $(document).ready(function() {
        function updateTable() {
          $.ajax({
            url: 'pool_table.php',
            type: 'GET',
            success: function(response) {
              $('#updateTable').html(response);
            }
          });
        }

        updateTable();
        setInterval(updateTable, 1000); 

        $('.image-link').on('click', function() {
          var imageUrl = $(this).data('image');
          $('#image-modal-img').attr('src', imageUrl);
        });
      });
    </script>

    <script src="src/js/service_management.js"></script>
    <script src="src/js/sidebar.js"></script>
  </body>

  </html>
<?php } else {
  header("location:login.php");
} ?>