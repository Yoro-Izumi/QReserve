<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <!-- Boxicons CDN Link -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reports</title>

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
  <link rel="stylesheet" href="src/css/sidebar.css" />
  <link rel="stylesheet" href="src/css/style.css" />


  <!-- Try ko lang to -->
  <style>
   .chartWithMarkerOverlay {
       position: relative;
       width: 700px;
   }
   .overlay-text {
       width: 200px;
       height: 200px;
       position: absolute;
       top: 50px;   /* chartArea top */
       left: 200px; /* chartArea left */
   }
   .overlay-marker {
       width: 50px;
       height: 50px;
       position: absolute;
       top: 53px;   /* chartArea top */
       left: 528px; /* chartArea left */
   }
  </style>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = new google.visualization.arrayToDataTable([
        ['Threat', 'Attacks'],
        ['Chandrian', 38],
        ['Ghosts', 12],
        ['Ghouls', 6],
        ['UFOs', 44],
        ['Vampires', 28],
        ['Zombies', 88]
      ]);

      var options = {
        legend: 'none',
        colors: ['#760946'],
        lineWidth: 4,
        vAxis: { gridlines: { count: 4 } }
      };

      function placeMarker(dataTable) {
        var cli = this.getChartLayoutInterface();
        var chartArea = cli.getChartAreaBoundingBox();
        // "Zombies" is element #5.
        document.querySelector('.overlay-marker').style.top = Math.floor(cli.getYLocation(dataTable.getValue(5, 1))) - 50 + "px";
        document.querySelector('.overlay-marker').style.left = Math.floor(cli.getXLocation(5)) - 10 + "px";
      };

      var chart = new google.visualization.LineChart(document.getElementById('line-chart-marker'));
      google.visualization.events.addListener(chart, 'ready',
        placeMarker.bind(chart, data));
      chart.draw(data, options);
    }
  </script>
</head>

<body class="body">
<?php include "superadmin_sidebar.php"; ?>

  <section class="home-section">
    <h4 class="krona-one-regular">Reports</h4>
    <hr class="my-4 mb-3 mt-3">
    <div class="container-fluid dashboard-square-kebab mb-4" id="reports-first-graph">
    <div class="chartWithMarkerOverlay">

<div id="line-chart-marker" style="width: 700px; height: 500px;"></div>

<div class="overlay-text">
 <div style="font-family:'Arial Black'; font-size: 128px;">88</div>
 <div style="color: #b44; font-family:'Arial Black'; font-size: 32px; letter-spacing: .21em; margin-top:50px; margin-left:5px;">zombie</div>
 <div style="color: #444; font-family:'Arial Black'; font-size: 32px; letter-spacing: .15em; margin-top:15px; margin-left:5px;">attacks</div>
</div>

<div class="overlay-marker">
 <img src="https://developers.google.com/chart/interactive/images/zombie_150.png" height="50">
</div>

</div>

      <!-- Buttons section -->
      <div class="row justify-content-end">
        <div class="col-12 col-md-2 mb-3 mb-md-0">
          <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">Generate Report</button>
        </div>
      </div>
    </div>
    <div class="container-fluid dashboard-square-kebab mb-4" id="reports-second-graph">
      <h1>2nd Graph</h1>

      <!-- Buttons section -->
      <div class="row justify-content-end">
        <div class="col-12 col-md-2 mb-3 mb-md-0">
          <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">Generate Report</button>
        </div>
      </div>
    </div>

    <div class="container-fluid dashboard-square-kebab mb-4" id="reports-third-graph">
      <h1>3rd Graph</h1>

      <!-- Buttons section -->
      <div class="row justify-content-end">
        <div class="col-12 col-md-2 mb-3 mb-md-0">
          <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">Generate Report</button>
        </div>
      </div>
    </div>
  </section>

  <script>//For sidebar
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