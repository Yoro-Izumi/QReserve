<?php
session_start();
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION['userMemberID'])) {
  $userID = $_SESSION['userMemberID'];
  include "connect_database.php";
  include "encodeDecode.php";
  include "src/get_data_from_database/get_pool_table_info.php";
  include "src/get_data_from_database/get_member_account.php";
  include "src/get_data_from_database/get_customer_information.php";
  $key = "TheGreatestNumberIs73";
  foreach ($arrayMemberAccount as $memberAccount) {
    if ($memberAccount["memberID"] == $userID) {
      $customerID = $memberAccount['customerID'];
      $validityDate = $memberAccount['validityDate'];
      foreach ($arrayCustomerInformation as $customerInformation) {
        if ($customerInformation["customerID"] == $customerID) {
          $customerName = decryptData($customerInformation['customerFirstName'], $key) . " " . decryptData($customerInformation['customerMiddleName'], $key) . " " . decryptData($customerInformation['customerLastName'], $key);
        }
      }
    }
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/css/landing.css">

    <!-- Fontawesome Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


    <!-- Montserrat Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Anton&family=Aoboshi+One&family=Audiowide&family=Black+Han+Sans&family=Braah+One&family=Bungee+Outline&family=Hammersmith+One&family=Krona+One&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="src/js/jquery-3.7.1.js"></script>
    <!-- Datatables JS -->
    <script src="src/js/jquery.dataTables.min.js"></script>
    <script src="src/js/dataTables.bootstrap5.min.js"></script>

    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
  </head>

  <body class="body">
    <?php include "customer_header.php";
    ?>


    <h3 class="qreserve mt-5 pt-3 mb-0">Welcome <?php echo $customerName; ?>!</h3>
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="fw-bold mt-4 mb-0">Active Playing</h4>
      <a href="booking_form.php" type="button" class="btn btn-primary fw-bold mb-0 mt-3 create-reservation" id="create-reservation">Create Reservation</a>
    </div>
    <hr class="my-4 mb-3 mt-3">
    <div class="container-fluid table-container dashboard-square-kebab" id="home-active-playing">
      <table id="example" class="table table-striped" style="width: 100%">
        <!--table data is dynamicaly updated and is from pool_table.php-->
      </table>
    </div>

    <div class="container-fluid mt-4">
      <div class="row justify-content-center text-center">
        <div class="col-md-4 mb-3">
          <div class="dashboard-square-kebab visitors-box">
          <h1 class="member-validity-date"><?php echo $validityDate; ?></h1>
          <h6 class="Visitors-today"> Membership valid until</h6>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="dashboard-square-kebab">
            <div id="service-carousel" class="carousel slide carousel-height" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="src/images/Services/Membership.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                  <img src="src/images/Services/Billiards Hall.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                  <img src="src/images/Services//KTV Room 1.jpg" class="d-block w-100" alt="..." />
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#service-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#service-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="dashboard-square-kebab">
            <div id="pubmat-carousel" class="carousel slide carousel-height" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="src/images/Pubmats/434190531_386131807641129_6896777236919307809_n.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                  <img src="src/images/Pubmats/434349874_384753677778942_8332027815166046702_n.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                  <img src="src/images/Pubmats/434361833_384754844445492_7151520115554376035_n.jpg" class="d-block w-100" alt="..." />
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#pubmat-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#pubmat-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
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





    <script>
      $(document).ready(function() {
        $("#example").DataTable({
          paging: true,
          lengthChange: false, // Disable length change
          searching: false, // Disable search
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
        // Function to update table content
        function updateTable() {
          $.ajax({
            url: 'customer_pool_table.php',
            type: 'GET',
            success: function(response) {
              $('#example').html(response);
            }
          });
        }

        // Initial table update
        updateTable();

        // Refresh table every 5 seconds
        setInterval(updateTable, 1000); // Adjust interval as needed
      });
    </script>

  </body>

  </html>
<?php
} else {
  header('location:customer_login.php');
  exit();
}
?>