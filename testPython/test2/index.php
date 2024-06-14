<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
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
</head>

<body class="body">
    <?php include "superadmin_sidebar.php"; ?>

    <section class="home-section">
      <h4 class="qreserve">Customer Demand Forecasting</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab mb-4" id="reports-first-graph">
        <figure class="highcharts-figure1">
          <div id="container1"></div>
        </figure>

        <!-- Buttons section -->
        <div class="row justify-content-end">
          <div class="col-12 col-md-2 mb-3 mb-md-0">
            <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">Generate Report</button>
          </div>
        </div>
      </div>

      <h4 class="qreserve">Peak Hours</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab mb-4" id="reports-second-graph">
        <figure class="highcharts-figure1">
          <div id="container2"></div>
        </figure>

        <!-- Buttons section -->
        <div class="row justify-content-end">
          <div class="col-12 col-md-2 mb-3 mb-md-0">
            <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">Generate Report</button>
          </div>
        </div>
      </div>

      <!-- <h4 class="qreserve">Admin Shift Reports</h4> -->
      <h4 class="qreserve">Admin Shift Report</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab mb-4" id="reports-third-graph">
        <figure class="highcharts-figure1">
          <div id="container3"></div>

        </figure>
        <div class="row justify-content-end">
          <div class="col-12 col-md-2 mb-3 mb-md-0">
            <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">Generate Report</button>
          </div>
        </div>
      </div>

      <!-- <h4 class="qreserve">Number of Reservations </h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab mb-4" id="reports-third-graph">
        <figure class="highcharts-figure1">
          <div id="container4"></div>

        </figure>
        <div class="row justify-content-end">
          <div class="col-12 col-md-2 mb-3 mb-md-0">
            <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">Generate Report</button>
          </div>
        </div>
      </div> -->
    </section>
</body>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Actual data from PHP
  var actualData = <?php echo json_encode($actual_data); ?>;
  // Predicted data from PHP
  var predictedData = <?php echo json_encode($predicted_data); ?>;

  Highcharts.chart('container1', {
    title: {
      text: 'Actual vs Predicted Data'
    },
    xAxis: {
      categories: [1, 2, 3, 4, 5]  // Adjust if necessary
    },
    yAxis: {
      title: {
        text: 'Values'
      }
    },
    series: [{
      name: 'Actual Data',
      data: actualData
    }, {
      name: 'Predicted Data',
      data: predictedData
    }]
  });
});
</script>