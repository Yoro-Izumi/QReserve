<?php
session_start();
include "connect_database.php";
include "src/get_data_from_database/get_admin_accounts.php";
include "src/get_data_from_database/get_admin_info.php";
include "src/get_data_from_database/get_reservation_info.php";
include "src/get_data_from_database/get_walk_in.php";
include "encodeDecode.php";
$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');

if (isset($_SESSION["userSuperAdminID"])) {
  //for linear regression
  include "testPython/test2/get_reservations.php";
  // Run the Python script
  $output = shell_exec('python3 testPython/test2/linear_regression.py');
  // Include the generated PHP data file
  include 'data.php';

  //for getting the peak hour
  include "testPython/test1/get_reservation_hour.php";
  // Fetch reservation data
  $reservations = getReservations();

  //if (empty($reservations)) {
   //   echo "No reservations found.";
   //   exit();
  //}

  // Pass data to Python script
  $reservation_times_json = json_encode($reservations);
  $command = 'echo ' . escapeshellarg($reservation_times_json) . ' | python3 testPython/test1/find_peak_hour.py';
  $outputPeak = shell_exec($command);

  // Log the output for debugging
  file_put_contents('testPython/test1/python_output.log', $output);

  $peak_times_data = json_decode($outputPeak, true);

  //change

  //if (json_last_error() !== JSON_ERROR_NONE) {
   //   echo "Error decoding JSON: " . json_last_error_msg();
   //   echo "Python output: " . htmlspecialchars($output);
   //   exit();
//  }


  

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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- 3rd Graph -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
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
      </div>

      <h4 class="qreserve">Peak Hours</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab mb-4" id="reports-second-graph">
        <figure class="highcharts-figure1">
          <div id="container2"></div>
        </figure>
      </div>

      <!-- <h4 class="qreserve">Admin Shift Reports</h4> -->
      <h4 class="qreserve">Admin Shift Report</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab mb-4" id="reports-third-graph">
        <figure class="highcharts-figure1">
          <div id="container3"></div>

        </figure>
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





    <!-- 1st Graph JS -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const actualData = <?php echo json_encode($actual_data); ?>;
        const predictedData = <?php echo json_encode($predicted_data); ?>;
        Highcharts.chart('container1', {
            title: {
                text: 'Reservations Over Time'
            },
            xAxis: {
                type: 'datetime',
                title: {
                    text: 'Date'
                }
            },
            yAxis: {
                title: {
                    text: 'Number of Reservations'
                }
            },
            series: [{
                name: 'Actual Reservations',
                data: actualData
            }, {
                name: 'Predicted Reservations',
                data: predictedData
            }]
        });
      });
    </script>

    <!-- 2nd Graph -->
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
   <!-- <script>
      Highcharts.chart('container2', {
        chart: {
          type: 'area'
        },
        accessibility: {
          description: 'Image description: An area chart compares the number of reservation in Bevitore between 10:00 AM today and 3:00 AM the following day Philippine time. The number of Reservation is plotted on the Y-axis and the time on the X-axis. The chart is interactive, and the resrvation levels can be traced for each pool table.'
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
            text: 'Reservation'
          }
        },
        tooltip: {
          pointFormat: '{series.name} had reserved <b>{point.y:,.0f}</b><br/>pool table at {point.x:%I:%M %p} Philippine time'
        },
        plotOptions: {
          area: {
            pointStart: Date.UTC(new Date().getFullYear(), new Date().getMonth(), new Date().getDate(), 10), // Start at 10:00 AM Philippine time today (GMT+8)
            pointInterval: 50 * 20000, // Represents hours, as each point is an hour increment
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
          data: [
            2,3, 5,1,7, 2, 9, 13, 50, 170, 299, 438, 841,
            1169, 1703, 2422, 3692, 5543, 7345, 12298, 18638, 22229, 25540,
            28133, 29463, 31139, 31175, 31255, 29561, 27552, 26008, 25830,
            26516, 27835, 28537, 27519, 25914, 25542, 24418, 24138, 24104,
            23208, 22886, 23305, 23459, 23368, 23317, 23575, 23205, 22217,
            21392, 19008, 13708, 11511, 10979, 10904, 11011, 10903, 10732,
            10685, 10577, 10526, 10457, 10027, 8570, 8360, 7853, 5709, 5273,
            5113, 5066, 4897, 4881, 4804, 4717, 4571, 4018, 3822, 3785
          ]
        }]
      });
    </script> -->


    <!-- 3rd Graph 
     <script>
      // Create an array to hold customer names and populations
       <?php
         /* $arrayAdmin = array();
          $arrayAdminNumber = array(); 
          $x = $y = $z = 0;
            foreach ($arrayWalkinDetails as $walkin){
              if(empty($arrayAdmin)){
                array_push($arrayAdmin,$walkin['adminID']);
                array_push($arrayAdminNumber,$y);
              }
              else{
                if($arrayAdmin[x] == $walkin['adminID']){
                  $arrayAdminNumber[$x] = $y+1;
                }
                else{
                  $y = 0;
                  array_push($arrayAdmin,$walkin['adminID']);
                  array_push($arrayAdminNumber,$y);
                }
              }
            } 
       ?>
       var adminData = [
         <?php foreach ($arrayAdmin as $name) : ?>['<?php echo $name; ?>', <?php $arrayAdminNumber[$z]; $z++?>],
         <?php endforeach; */ ?>
       ];

      Highcharts.chart('container3', {
        chart: {
          type: 'column'
        },
        title: {
          text: ''
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          type: 'category',
          labels: {
            autoRotation: [-45, -90],
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Population'
          }
        },
        legend: {
          enabled: false
        },
        tooltip: {
          pointFormat: 'Reservations in 2024: <b>{point.y:.1f}</b>'
        },
        series: [{
          name: 'Population',
          colors: [
            '#9b20d9', '#9215ac', '#861ec9', '#7a17e6', '#7010f9', '#691af3',
            '#6225ed', '#5b30e7', '#533be1', '#4c46db', '#4551d5', '#3e5ccf',
            '#3667c9', '#2f72c3', '#277dbd', '#1f88b7', '#1693b1', '#0a9eaa',
            '#03c69b', '#00f194'
          ],
          colorByPoint: true,
          groupPadding: 0,
          data: adminData,
          dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            inside: true,
            verticalAlign: 'top',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        }]
      });
    </script>-->

    <script>
    // Create an array to hold admin names and their counts
    <?php
    $arrayAdmin = array();
    $arrayAdminNumber = array();
    $arrayAdminName = array();

    foreach ($arrayWalkinDetails as $walkin) {
        $adminID = $walkin['adminID'];
        // Fetch and decrypt admin names based on adminID
        foreach ($arrayAdminAccount as $admin) {
            if ($admin['adminID'] == $adminID) {
                $adminName = decryptData($admin['adminFirstName'], $key) . " " . decryptData($admin['adminMiddleName'], $key) . " " . decryptData($admin['adminLastName'], $key);
                break;
            }
        }

        if (in_array($adminName, $arrayAdmin)) {
            $index = array_search($adminName, $arrayAdmin);
            $arrayAdminNumber[$index]++;
        } else {
            array_push($arrayAdmin, $adminName);
            array_push($arrayAdminNumber, 1); // Initial count as 1
        }
    }
    ?>
    var adminData = [
        <?php 
        foreach ($arrayAdmin as $index => $name) : 
            echo "['$name', {$arrayAdminNumber[$index]}],";
        endforeach; 
        ?>
    ];

    Highcharts.chart('container3', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category',
            labels: {
                autoRotation: [-45, -90],
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Reservations'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Reservations in 2024: <b>{point.y}</b>'
        },
        series: [{
            name: 'Population',
            colors: [
                '#9b20d9', '#9215ac', '#861ec9', '#7a17e6', '#7010f9', '#691af3',
                '#6225ed', '#5b30e7', '#533be1', '#4c46db', '#4551d5', '#3e5ccf',
                '#3667c9', '#2f72c3', '#277dbd', '#1f88b7', '#1693b1', '#0a9eaa',
                '#03c69b', '#00f194'
            ],
            colorByPoint: true,
            groupPadding: 0,
            data: adminData,
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                inside: true,
                verticalAlign: 'top',
                format: '{point.y}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
    </script>




<!-- 4th Graph -->
<script>
      // Create an array to hold customer names and populations
      var customerData = [
        <?php foreach ($adminNames as $name) : ?>['<?php echo $name; ?>', 37.33],
        <?php endforeach; ?>
      ];

      Highcharts.chart('container4', {
        chart: {
          type: 'column'
        },
        title: {
          text: ''
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          type: 'category',
          labels: {
            autoRotation: [-45, -90],
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Population (millions)'
          }
        },
        legend: {
          enabled: false
        },
        tooltip: {
          pointFormat: 'Population in 2021: <b>{point.y:.1f} millions</b>'
        },
        series: [{
          name: 'Population',
          colors: [
            '#9b20d9', '#9215ac', '#861ec9', '#7a17e6', '#7010f9', '#691af3',
            '#6225ed', '#5b30e7', '#533be1', '#4c46db', '#4551d5', '#3e5ccf',
            '#3667c9', '#2f72c3', '#277dbd', '#1f88b7', '#1693b1', '#0a9eaa',
            '#03c69b', '#00f194'
          ],
          colorByPoint: true,
        groupPadding: 0,
        data: [
            ['Monday', 37.33],
            ['Tuesday', 31.18],
            ['Wednesday', 27.79],
            ['Thursday', 22.23],
            ['Friday', 21.91],
            ['Saturday', 21.74],
            ['Sunday', 21.32],
        ],
          dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            inside: true,
            verticalAlign: 'top',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
              fontSize: '13px',
              fontFamily: 'Verdana, sans-serif'
            }
          }
        }]
      });
    </script>

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

<script src="src/js/sidebar.js"></script>

  </body>

  </html>
<?php } else {
  header("location:login.php");
} ?>