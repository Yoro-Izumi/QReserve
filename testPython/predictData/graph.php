<?php
session_start();
include "../connect_database.php";
include "../src/get_data_from_database/get_admin_accounts.php";
include "../src/get_data_from_database/get_admin_info.php";
include "../src/get_data_from_database/get_reservation_info.php";
include "../encodeDecode.php";
$key = "TheGreatestNumberIs73";
date_default_timezone_set('Asia/Manila');
if (isset($_SESSION["userSuperAdminID"])) {
  // Your code here
  $adminNames = []; // Initialize an empty array to store customer names
  foreach ($arrayAdminAccount as $adminAccount) {
    $adminInfoID = $adminAccount["adminInfoID"];
    $adminName = decryptData($adminAccount['adminFirstName'], $key) . " " . decryptData($adminAccount['adminMiddleName'], $key) . " " . decryptData($adminAccount['adminLastName'], $key);    
    $adminNames[] = $adminName; // Add customer name to the array

    $reservation = 0;
    foreach ($arrayReservationInfo as $reservationInfo) {
      if ($reservationInfo['adminID'] == $adminAccount['adminID']) {
        $reservation = $reservation + 1;
      }
  
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
    <?php include "../superadmin_sidebar.php"; ?>

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
      // Parse data from Python
      var X_test = JSON.parse('{{ X_test_json | safe }}');
      var y_pred = JSON.parse('{{ y_pred_json | safe }}');

      Highcharts.chart('container1', {

        title: {
          text: '',
          align: 'left'
        },

        subtitle: {
          text: '',
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
          data: X_test.map((val, index) => ({ x: val[0], y: y_pred[index] }))
        }, {
          name: 'Manufacturing',
          data: X_test.map((val, index) => ({ x: val[0], y: y_pred[index] }))
        }, {
          name: 'Sales & Distribution',
          data: [11744, 30000, 16005, 19771, 20185, 24377,
            32147, 30912, 29243, 29213, 25663
          ]
        }, {
          name: 'Operations & Maintenance',
          data: [null, null, null, null, null, null, null,
            null, 11164, 11218, 10077
          ]
        }, {
          name: 'Other',
          data: [21908, 5548, 8105, 11248, 8989, 11816, 18274,
            17300, 13053, 11906, 10073
          ]
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

    <!-- 2nd Graph -->
    <script>
      Highcharts.chart('container2', {
        chart: {
          type: 'area'
        },
        accessibility: {
          description: 'Image description: An area chart compares the nuclear stockpiles of the USA and the USSR/Russia between 10:00 AM today and 3:00 AM the following day Philippine time. The number of nuclear weapons is plotted on the Y-axis and the time on the X-axis. The chart is interactive, and the stockpile levels can be traced for each country. The US has a stockpile of 6 nuclear weapons at 10:00 AM. This number has gradually increased to 369 by 11:00 AM when the USSR enters the arms race with 6 weapons. At this point, the US starts to rapidly build its stockpile culminating in 32,040 warheads by 4:00 PM compared to the USSR’s 7,089. From this peak at 4:00 PM, the US stockpile gradually decreases as the USSR’s stockpile expands. By 7:00 PM, the USSR has closed the nuclear gap at 25,393. The USSR stockpile continues to grow until it reaches a peak of 45,000 at 12:00 AM the following day compared to the US arsenal of 24,401. From 12:00 AM the following day, the nuclear stockpiles of both countries start to fall. By 2:00 AM the following day, the numbers have fallen to 10,577 and 21,000 for the US and Russia, respectively. The decreases continue until 3:00 AM the following day at which point the US holds 4,018 weapons compared to Russia’s 4,500.'
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
            text: 'Nuclear weapon states'
          }
        },
        tooltip: {
          pointFormat: '{series.name} had stockpiled <b>{point.y:,.0f}</b><br/>warheads at {point.x:%I:%M %p} Philippine time'
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
            null, null, null, null, null, 2, 9, 13, 50, 170, 299, 438, 841,
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
    </script>


    <!-- 3rd Graph -->
     <script>
      // Create an array to hold customer names and populations
      var customerData = [
        <?php foreach ($adminNames as $name) : ?>['<?php echo $name; ?>',<?php echo $reservation; ?>],
        <?php endforeach; ?>
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
          data: customerData,
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
  </body>

  </html>
<?php } else {
  header("location:login.php");
} ?>