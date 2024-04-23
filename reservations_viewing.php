<?php
include "connect_database.php";
include "get_data_from_database/get_reservation_info.php";
session_start();
if(isset($_SESSION["userSuperAdminID"])){
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Reservations</title>

    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet"/>
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
    <link rel="stylesheet" href="./css/sidebar.css" />
    <link rel="stylesheet" href="./css/style.css" />
  </head>
  <body class="body">
  <?php include "superadmin_sidebar.php"; ?>

    <section class="home-section">
      <h4 class="krona-one-regular">Reservations</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid" id="home-active-playing">
      <table id="example" class="table table-striped" style="width: 100%">
          <thead>
            <tr>
              <th>Actions</th>
              <th>Name</th>
              <th>Date of Reservation</th>
              <th>Time of Reservation</th>
              <th>Pool Table</th>
              <th>Contact Number</th>
              <th>Email Address</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($arrayReservationInfo as $reservations){
              $reservationDate = $reservations['reservationDate'];
              $reservationStatus = $reservation['reservationStatus'];
              $reservationTimeStart = $reservations['reservationTimeStart'];
                foreach($arrayCustomerInformation as $customerInfo){
                  if($reservation['customerID'] == $customerInfo['customerID']){
                    $customerName = decryptData($customerInfo['customerFirstName'],$key)." ".decryptData($customerInfo['customerMiddleName'],$key)." ".decryptData($customerInfo['customerLastName'],$key);
                    $contactNumber = decryptData($customerInfo['customerNumber'],$key);
                    $email = decryptData($customerInfo['customerEmail'],$key);
                  }
                  else{
                    $customerName = "";
                    $contactNumber = "";
                    $email = "";
                  }  
                }
            ?>
                <tr>
                  <td><input type="checkbox" value="<?php echo $reservations['reservationID'];?>"></td>
                  <td><?php echo $customerName;?></td>
                  <td><?php echo $reservationDate;?></td>
                  <td><?php echo $reservationTimeStart;?></td>
                  <td><?php echo $reservations['tableID'];?></td>
                  <td><?php echo $contactNumber;?></td>
                  <td><?php echo $email;?></td>
              <?php 
                if($reservationStatus == "Paid" || $reservationStatus == "Done"){
                  $status = "badge bg-success";
                }
                else if($poolTableStatus == "On Process" || $poolTableStatus == "Pending"){
                  $status = "badge bg-warning";
                }
                else{
                  $status = "badge bg-danger";
                }
              ?>
                  <td><span class="<?php echo $status;?>"><?php echo $reservationStatus;?></span></td>
              </tr>
            <?php }?>  
          </tbody>
        </table>
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
<?php } else{
header("location:login.php");
}?>