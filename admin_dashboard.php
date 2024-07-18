<?php
session_start();
if (isset($_SESSION["userSuperAdminID"]) || isset($_SESSION["userAdminID"])) {
  // Check for admin session too
  include "connect_database.php";
  include "src/get_data_from_database/get_services.php";
  include "src/get_data_from_database/get_visitor_num.php";

  $visitors = $totalVisitor;

?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="UTF-8" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

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

    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">

    <!-- External CSS -->
    <link rel="stylesheet" href="src/css/sidebar.css" />
    <link rel="stylesheet" href="src/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>

  <body class="body">
    <?php include "admin_sidebar.php"; ?>
    <section class="home-section">

      <div class="container-fluid dashboard-square-kebab" id="full-screen">
        <i id="toggleFullScreen" class="bi bi-fullscreen"></i>
        <img src="src/images/Bevitore-logo.png" class="img-fluid icon" id="full-screen-logo" />
        <h1 class="qreserve bevitore">BILLIARDS TABLE</h1>
        <div class="row col-md-12 full-screen-tables mb-2">
          <!-- Pool tables will be loaded here -->
        </div>
      </div>

      <h4 class="qreserve mt-5">Active Playing</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab" id="home-active-playing">
        <table id="example" class="table table-striped" style="width: 100%">
          <!--table data is dynamicaly updated and is from pool_table.php-->
        </table>
      </div>
      <div class="container-fluid mt-4">
        <div class="row justify-content-center text-center">
          <div class="col-md-4 mb-3">
            <div class="dashboard-square-kebab visitors-box">
              <h1 class="number-of-visitors"><?php echo $visitors; ?></h1>
              <h6 class="Visitors-today">Visitors today</h6>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="dashboard-square-kebab">
              <div id="service-carousel" class="carousel slide carousel-height" data-bs-ride="carousel">
              <div class="carousel-inner">
                <?php
                $first = true;
                foreach ($arrayServices as $services) :
                  $serviceImage = "src/images/Services/" . $services['serviceImage'];
                ?>
                  <div class="carousel-item <?php if ($first) {
                                              echo 'active';
                                              $first = false;
                                            } ?>">
                    <img src="<?php echo $serviceImage; ?>" class="d-block w-100" alt="..." />
                  </div>
                <?php endforeach; ?>
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
                <?php
                $first = true;
                foreach ($arrayServices as $services) :
                  $serviceImage = "src/images/Services/" . $services['serviceImage'];
                ?>
                  <div class="carousel-item <?php if ($first) {
                                              echo 'active';
                                              $first = false;
                                            } ?>">
                    <img src="<?php echo $serviceImage; ?>" class="d-block w-100" alt="..." />
                  </div>
                <?php endforeach; ?>
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
    </section>

    <script>
      document.getElementById('toggleFullScreen').addEventListener('click', function() {
        var elem = document.getElementById('full-screen');

        if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
          if (elem.requestFullscreen) {
            elem.requestFullscreen();
          } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
          } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
          } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
          }
        } else {
          if (document.exitFullscreen) {
            document.exitFullscreen();
          } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
          } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
          } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
          }
        }
      });
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

    <!--script refresh pool table full screen section-->
    <script>
      $(document).ready(function() {
        function refreshPoolTables() {
          $.ajax({
            url: 'src/get_data_from_database/get_pool_tables.php',
            method: 'GET',
            success: function(data) {
              $('.full-screen-tables').html(data);
            }
          });
        }

        // Initial load
        refreshPoolTables();

        // Refresh every 2 seconds
        setInterval(refreshPoolTables, 1000);
      });
    </script>

    <script>
      $(document).ready(function() {
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
<?php } else {
  header("location:login.php");
  die();
} ?>