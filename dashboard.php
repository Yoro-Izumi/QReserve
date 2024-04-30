<?php
session_start();
if(isset($_SESSION["userSuperAdminID"])){
$visitors = 0;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <!-- Boxicons CDN Link -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

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

<body class="body">
  <div class="sidebar">
    <div class="logo-details">
      <img src="./images/Bevitore-logo.png" class="img-fluid icon" id="sidebar-logo" />
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
        <a href="dashboard.php">
          <i class="bx bx-home"></i>
          <span class="links_name">Home</span>
        </a>
        <span class="tooltip">Home</span>
      </li>
      <li>
        <a href="reservations_viewing.php">
          <i class="bx bx-book"></i>
          <span class="links_name">Reservations Viewing</span>
        </a>
        <span class="tooltip">Reservations</span>
      </li>
      <li>
        <a href="service management.php">
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
          <li><a class="dropdown-item" href="admin-profiles.php">Admin Accounts</a></li>
          <li><a class="dropdown-item" href="member-profiles.php">Member Accounts</a></li>
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
    <h4 class="krona-one-regular">Active Playing</h4>
    <hr class="my-4 mb-3 mt-3">
    <div class="container-fluid dashboard-square-kebab" id="home-active-playing">
      <table id="example" class="table table-striped" style="width: 100%">
       <!--table data is dynamicaly updated and is from pool_table.php-->
      </table>
    </div>

    <div class="container-fluid mt-4">
      <div class="row justify-content-center text-center">
        <div class="col-md-4 mb-3">
          <div class="dashboard-square-kebab">
            Number of Visitors
            <h1><?php echo $visitors;?></h1>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="dashboard-square-kebab">
            <div id="service-carousel" class="carousel slide carousel-height" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="./images/Services/Membership.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                  <img src="./images/Services/Billiards Hall.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                  <img src="./images/Services//KTV Room 1.jpg" class="d-block w-100" alt="..." />
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#service-carousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#service-carousel"
                data-bs-slide="next">
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
                  <img src="./images/Pubmats/434190531_386131807641129_6896777236919307809_n.jpg" class="d-block w-100"
                    alt="..." />
                </div>
                <div class="carousel-item">
                  <img src="./images/Pubmats/434349874_384753677778942_8332027815166046702_n.jpg" class="d-block w-100"
                    alt="..." />
                </div>
                <div class="carousel-item">
                  <img src="./images/Pubmats/434361833_384754844445492_7151520115554376035_n.jpg" class="d-block w-100"
                    alt="..." />
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#pubmat-carousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#pubmat-carousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
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
        $(document).ready(function(){
            // Function to update table content
            function updateTable() {
                $.ajax({
                    url: 'pool_table.php',
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
<?php } else{
header("location:login.php");
die();
}?>