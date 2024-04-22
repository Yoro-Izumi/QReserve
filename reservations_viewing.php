<?php
include "connect_database.php";
include "get_data_from_database/get_reservation_info.php";
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
    <div class="sidebar">
      <div class="logo-details">
        <img
          src="./images/Bevitore-logo.png"
          class="img-fluid icon"
          id="sidebar-logo"
        />
        <div class="logo_name krona-one-regular ms-2 mb-0">QReserve</div>
        <i class="bx bx-menu" id="btn"></i>
      </div>
      <ul class="nav-list">
        <!-- <li>
          <i class='bx bx-search' ></i>
         <input type="text" placeholder="Search...">
         <span class="tooltip">Search</span>
      </li> -->
        <li>
          <a href="dashboard.html">
            <i class="bx bx-home"></i>
            <span class="links_name">Home</span>
          </a>
          <span class="tooltip">Home</span>
        </li>
        <li>
          <a href="reservations_viewing.html">
            <i class="bx bx-book"></i>
            <span class="links_name">Reservations Viewing</span>
          </a>
          <span class="tooltip">Reservations</span>
        </li>
        <li>
          <a href="service management.html">
            <i class="bx bx-aperture"></i>
            <span class="links_name">Service Management</span>
          </a>
          <span class="tooltip">Services</span>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-user"></i>
            <span class="links_name dropdown-toggle">Profile Management </span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="profileDropdown">
          </ul>
        </li>
        <li>
          <a href="reports.php"> 
            <i class="bx bx-pie-chart-alt-2"></i>
            <span class="links_name">Reports</span>
          </a>
          <span class="tooltip">Reports</span>
        </li>

        <li class="profile">
          <div class="profile-details">
            <div class="name_job">
              <div class="name">Prem Shahi</div>
              <div class="job">Web designer</div>
            </div>
          </div>
          <a href="logout.php">
            <i class="bx bx-log-out" id="log_out"></i>
          </a>
        </li>        
      </ul>
    </div>

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