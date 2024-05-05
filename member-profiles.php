<?php 
session_start();
date_default_timezone_set('Asia/Manila');
include "connect_database.php";
include "src/get_data_from_database/get_member_account.php";
include "src/get_data_from_database/get_customer_information.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";

if(isset($_SESSION["userSuperAdminID"])){
  $superAdminID = $_SESSION["userSuperAdminID"];
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Member Profile</title>
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Online Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />

    <!-- Datatables -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"
    />

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
  </head>
  <body>
  <?php include "superadmin_sidebar.php"; ?>

    <section class="home-section">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="krona-one-regular">Member Accounts</h4>
        <a href="add_new_member.php" type="button" class="btn btn-primary fw-bold mb-0" id="add-new-profile">Add New Member</a>
      </div>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab" id="profile-management">
        <table id="example" class="table table-striped" style="width: 100%">
          <thead>
            <tr>
              <tr>
                <th>Actions</th>
                <th>Name</th>
                <th>Username</th>
                <th>Birthday</th>
                <th>Contact Number</th>
                <th>Email Address</th>
                <th>Validity</th>
              </tr>
          </thead>
          <tbody>
          <?php
            foreach($arrayMemberAccount as $memberAccount){ //get membership details as well as information of member
              $memberID = $memberAccount["memberID"];
              $memberUsername = decryptData($memberAccount["membershipID"],$key);
              $membershipValidity = $memberAccount["validityDate"];
              $customerName = decryptData($memberAccount['customerFirstName'],$key)." ".decryptData($memberAccount['customerMiddleName'],$key)." ".decryptData($memberAccount['customerLastName'],$key);
              $customerBirthdate = decryptData($memberAccount['customerBirthdate'],$key);
              $customerPhone = decryptData($memberAccount['customerNumber'],$key);                      
              $customerEmail = decryptData($memberAccount['customerEmail'],$key);
                      
          ?>
            <tr>
              <td><input type="checkbox" value = "<?php echo $memberID;?>"></td> 
              <td><?php echo $customerName;?></td>
              <td><?php echo $memberUsername;?></td>
              <td><?php echo $customerBirthdate;?></td>
              <td><?php echo $customerPhone;?></td>
              <td><?php echo $customerEmail;?></td>
              <td><?php echo $membershipValidity;?></td>
            </tr>
          <?php }?>
          </tbody>
        </table>
        <div class="mt-3">
          <button type="button" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button>
          <button type="button" class="btn btn-primary" onclick="editSelected()">Edit Selected</button>
        </div>        
      </div>  
    </section>

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
  </body>
</html>
<?php }else{header("location:dashboard.php");}?>