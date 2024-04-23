<?php
include "connect_database.php";
include "get_data_from_database/get_services.php";
session_start();
if(isset($_SESSION["userSuperAdminID"])){
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
  <link
    href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />

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
  <link rel="stylesheet" href="./css/sidebar.css" />
  <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
<?php include "superadmin_sidebar.php"; ?>

  <section class="home-section">
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="krona-one-regular mt-">Service Management</h4>
      <!-- <a href="add_new_service.php" type="button" class="btn btn-primary fw-bold mb-0" id="add-new-profile">Add New Service</a> -->
      <button type="button" class="btn btn-primary fw-bold mb-0" data-bs-toggle="modal" data-bs-target="#add-service-modal" id="add-new-profile">Add New Service</button>
    </div>
    <hr class="my-4 mb-3 mt-3">
    <div class="container-fluid dashboard-square-kebab" id="profile-management">
      <table id="example" class="table table-striped" style="width: 100%">
        <thead>
          <tr>
          <tr>
            <th>Actions</th>
            <th>Service Name</th>
            <th>Rates</th>
            <th>Capacity</th>
            <th>Image</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($arrayServices as $services){?>
          <tr>
            <td><input type="checkbox" value="<?php echo $services['serviceID'];?>"></td>
            <td><?php echo $services['serviceName'];?></td>
            <td><?php echo $services['serviceRate'];?></td>
            <td> </td>
            <td><?php echo $services['serviceImage'];?></td>
          </tr>
        <?php }?>
        </tbody>
      </table>
      <div class="mt-3">
        <!-- <button type="button" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button> -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal" id="delete-service">Delete Selected</button>
        <button type="button" class="btn btn-primary" onclick="editSelected()">Edit Selected</button>
      </div>
    </div>
  </section>






<!-- Modals -->

<!-- Add New Service Modal -->
<div class="modal fade" id="add-service-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" id="add-new-service-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold text-center" id="staticBackdropLabel">Add New Service</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="needs-validation" id="add-new-profile-form" novalidate action="BABAGUHIN ITU.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12 col-md-12 mb-3">
            <label for="serviceName" class="form-label">Service Name <span>*</span></label>
            <input type="text" class="form-control" name="serviceName" id="serviceName" placeholder="Enter first name here" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')" />
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">
              Please enter a valid first name.
            </div>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <label for="serviceRate" class="form-label">Rate</label>
            <div class="input-group">
              <span class="input-group-text">₱</span>
              <input type="text" class="form-control" name="serviceRate" id="serviceRate" placeholder="Enter rate here" pattern="^\d+(\.\d{1,2})?$" required oninvalid="this.setCustomValidity('Please enter a valid rate')" oninput="this.setCustomValidity('')" />
            </div>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a valid rate.</div>
          </div>
          <div class="col-12 col-md-6 mb-3">
            <label for="text" class="form-label">Capacity <span>*</span></label>
            <input type="email" class="form-control" name="capacity" id="capacity" placeholder="Enter service capacity here" required oninvalid="this.setCustomValidity('Please enter a valid capacity')" oninput="this.setCustomValidity('')" />
            <!-- <div class="valid-feedback">
                Looks good!
            </div> -->
            <div class="invalid-feedback">
              Please enter a valid capacity.
            </div>
          </div>
          <div class="col-12 col-md-12 mb-3">
            <label for="image" class="form-label">Image <span>*</span></label>
            <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png" required>
            <div class="invalid-feedback">
              Please enter a valid capacity.
            </div>
          </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create-button">Submit</button>
        <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered" id="add-new-service-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold text-center" id="staticBackdropLabel">Delete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary create-button">Submit</button>
        <button type="button" class="btn btn-outline-primary cancel-button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>




  <script>
    $(document).ready(function () {
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
    //For Rate
    document.addEventListener("DOMContentLoaded", function() {
      const serviceRateInput = document.querySelector("#serviceRate");

      // Add event listener for input
      serviceRateInput.addEventListener("input", function() {
        // Get the input value
        let rate = serviceRateInput.value;

        // Remove non-numeric characters and leading zeroes
        rate = rate.replace(/\D/g, "").replace(/^0+/, "");

        // Format the rate with Philippine Peso sign and commas for thousands separator
        rate =
          "₱" +
          parseFloat(rate).toLocaleString(undefined, {
            minimumFractionDigits: 2,
          });

        // Update the input value
        serviceRateInput.value = rate;
      });
    });
  </script>
</body>

</html>
<?php } else{
header("location:login.php");
}?>