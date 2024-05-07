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
      top: 50px;
      /* chartArea top */
      left: 200px;
      /* chartArea left */
    }

    .overlay-marker {
      width: 50px;
      height: 50px;
      position: absolute;
      top: 53px;
      /* chartArea top */
      left: 528px;
      /* chartArea left */
    }
  </style>

<!-- 1st Graph -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<!-- 2nd Graph -->

</head>

<body class="body">
  <?php include "superadmin_sidebar.php"; ?>

  <section class="home-section">
    <h4 class="qreserve">Reports</h4>
    <hr class="my-4 mb-3 mt-3">
    <div class="container-fluid dashboard-square-kebab mb-4" id="reports-first-graph">
    <figure class="highcharts-figure1">
    <div id="container"></div>
    <p class="highcharts-description">
        Basic line chart showing trends in a dataset. This chart includes the
        <code>series-label</code> module, which adds a label to each line for
        enhanced readability.
    </p>
</figure>

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

  <script>
    //For sidebar
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



<!-- 1st Graph JS -->
<script>
  Highcharts.chart('container', {

title: {
    text: 'U.S Solar Employment Growth',
    align: 'left'
},

subtitle: {
    text: 'By Job Category. Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>.',
    align: 'left'
},

yAxis: {
    title: {
        text: 'Number of Employees'
    }
},

xAxis: {
    accessibility: {
        rangeDescription: 'Range: 2010 to 2020'
    }
},

legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
},

plotOptions: {
    series: {
        label: {
            connectorAllowed: false
        },
        pointStart: 2010
    }
},

series: [{
    name: 'Installation & Developers',
    data: [43934, 48656, 65165, 81827, 112143, 142383,
        171533, 165174, 155157, 161454, 154610]
}, {
    name: 'Manufacturing',
    data: [24916, 37941, 29742, 29851, 32490, 30282,
        38121, 36885, 33726, 34243, 31050]
}, {
    name: 'Sales & Distribution',
    data: [11744, 30000, 16005, 19771, 20185, 24377,
        32147, 30912, 29243, 29213, 25663]
}, {
    name: 'Operations & Maintenance',
    data: [null, null, null, null, null, null, null,
        null, 11164, 11218, 10077]
}, {
    name: 'Other',
    data: [21908, 5548, 8105, 11248, 8989, 11816, 18274,
        17300, 13053, 11906, 10073]
}],

responsive: {
    rules: [{
        condition: {
            maxWidth: 500
        },
        chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
        }
    }]
}

});

</script>
</body>

</html>