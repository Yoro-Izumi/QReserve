<?php
session_start();
if (isset($_SESSION["userSuperAdminID"])) {
  include "connect_database.php";
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
    <?php
    if (isset($_SESSION['userSuperAdminID'])) {
      include "superadmin_sidebar.php";
    } else {
      include "admin_sidebar.php";
    }
    ?>
    <section class="home-section">
      <div class="container-fluid dashboard-square-kebab" id="full-screen">
      <i id="toggleFullScreen" class="bi bi-fullscreen"></i>


        <img src="src/images/Bevitore-logo.png" class="img-fluid icon" id="full-screen-logo" />
        <h1 class="qreserve bevitore">BILLIARDS TABLE</h1>
        <div class="row col-md-12 full-screen-tables mb-2">
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
                1
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
               5
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
                9
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
               13
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row col-md-12 full-screen-tables mb-2">
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
                2
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
               6
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
               10
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
               14
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row col-md-12 full-screen-tables mb-2">
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
                3
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
               7
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
                11
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
              15
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row col-md-12 full-screen-tables mb-2">
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
                4
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
               8
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
                12
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="table-box">
              <div class="table-number">
               16
              </div>
              <div class="table-time">
                <p>Available</p>
              </div>
            </div>
          </div>
        </div>
      </div>

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

      <h4 class="qreserve mt-5">Active Playing</h4>
      <hr class="my-4 mb-3 mt-3">

      <div class="container-fluid dashboard-square-kebab" id="home-active-playing">
        <table id="example" class="table table-striped" style="width: 100%">
        </table>
      </div>

      <div class="container-fluid mt-4">
        <div class="row justify-content-center text-center">
          <div class="col-md-4 mb-3">
            <div class="dashboard-square-kebab pota">
              <h1 class="number-of-visitors"><?php echo $visitors; ?></h1>
              <h6 class="Visitors-today">Visitors today</h6>
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
    </section>



    <script src="src/js/sidebar.js"></script>
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