<?php
session_start();
include "../../connect_database.php";
include "get_reservation_hour.php";

date_default_timezone_set('Asia/Manila');

// Fetch reservation data
$reservations = getReservations();

if (empty($reservations)) {
    echo "No reservations found.";
    exit();
}

// Pass data to Python script
$reservation_times_json = json_encode($reservations);
$command = 'echo ' . escapeshellarg($reservation_times_json) . ' | python3.10 find_peak_hour.py';
$output = shell_exec($command);

// Log the output for debugging
file_put_contents('python_output.log', $output);

$peak_times_data = json_decode($output, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Error decoding JSON: " . json_last_error_msg();
    echo "Python output: " . htmlspecialchars($output);
    exit();
}

// Prepare data for Highcharts
$formatted_data = [];
for ($i = 10; $i <= 27; $i++) {
    $hour = $i % 24; // Wrap around after 23 to represent next day's hours
    $found = false;
    foreach ($peak_times_data as $item) {
        if ($item['hour'] == $hour) {
            $formatted_data[] = $item['count'];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $formatted_data[] = 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your HTML Head Content -->
</head>
<body class="body">

    <section class="home-section">
        <h4 class="qreserve">Peak Hours</h4>
        <hr class="my-4 mb-3 mt-3">
        <div class="container-fluid dashboard-square-kebab mb-4" id="reports-second-graph">
            <figure class="highcharts-figure1">
                <div id="container2"></div>
            </figure>
        </div>
    </section>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('container2', {
          chart: {
            type: 'area'
          },
          accessibility: {
            description: 'Image description: An area chart compares the number of reservations in Bevitore between 10:00 AM today and 3:00 AM the following day Philippine time. The number of reservations is plotted on the Y-axis and the time on the X-axis. The chart is interactive, and the reservation levels can be traced for each pool table.'
          },
          title: {
            text: ''
          },
          subtitle: {
            text: ''
          },
          xAxis: {
            allowDecimals: false,
            type: 'datetime',
            accessibility: {
              rangeDescription: 'Range: 10:00 AM today to 3:00 AM the following day Philippine time.'
            },
            min: Date.UTC(new Date().getFullYear(), new Date().getMonth(), new Date().getDate(), 10), // Start at 10:00 AM Philippine time today (GMT+8)
            max: Date.UTC(new Date().getFullYear(), new Date().getMonth(), new Date().getDate() + 1, 3), // End at 3:00 AM Philippine time the following day (GMT+8)
            labels: {
              format: '{value:%I:%M %p}', // Format for displaying labels
            }
          },
          yAxis: {
            title: {
              text: 'Reservations'
            }
          },
          tooltip: {
            pointFormat: '{series.name} had reserved <b>{point.y:,.0f}</b><br/>pool table at {point.x:%I:%M %p} Philippine time'
          },
          plotOptions: {
            area: {
              pointStart: Date.UTC(new Date().getFullYear(), new Date().getMonth(), new Date().getDate(), 10), // Start at 10:00 AM Philippine time today (GMT+8)
              pointInterval: 3600 * 1000, // One hour intervals
              marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                  hover: {
                    enabled: true
                  }
                }
              }
            }
          },
          series: [{
            name: 'Operational Hours',
            data: <?php echo json_encode($formatted_data); ?>
          }]
        });
      });
    </script>

</body>
</html>
