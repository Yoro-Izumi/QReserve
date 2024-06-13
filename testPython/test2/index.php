          <?php
            // Run the Python script
              //$output = shell_exec('python3 linear_regression.py');
              // Include the generated PHP data file
              //include 'data.php';

        /*  session_start();
          include "connect_database.php";
          include "src/get_data_from_database/get_admin_accounts.php";
          include "src/get_data_from_database/get_admin_info.php";
          include "src/get_data_from_database/get_reservation_info.php";
          include "src/get_data_from_database/get_walk_in.php";
          include "encodeDecode.php";
          $key = "TheGreatestNumberIs73";
          date_default_timezone_set('Asia/Manila');
          if (isset($_SESSION["userSuperAdminID"])) {
              

              $adminNames = []; // Initialize an empty array to store customer names
              foreach ($arrayAdminAccount as $adminAccount) {
                  $adminInfoID = $adminAccount["adminInfoID"];
                  $adminName = decryptData($adminAccount['adminFirstName'], $key) . " " . decryptData($adminAccount['adminMiddleName'], $key) . " " . decryptData($adminAccount['adminLastName'], $key);    
                  $adminNames[] = $adminName; // Add customer name to the array

                  $reservation = 0;
                  foreach ($arrayReservationInfo as $reservationInfo) {
                      if ($reservationInfo['superAdminID'] == $adminAccount['superAdminID']) {
                          $reservation = $reservation + 1;
                      }
                  }
              }*/
          ?>


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
      categories: [1, 2, 3, 4, 5]  
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
