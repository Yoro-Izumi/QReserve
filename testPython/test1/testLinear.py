#!C:\Users\Yoro PC\AppData\Local\Programs\Python\Python312\python.exe
import numpy as np
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_squared_error, mean_absolute_error, r2_score
import json
import random

print("Content-Type: text/html")
print()

def generate_random_data():
    days_since_start = np.array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])  # Independent variable: days since start
    reservations = np.array([10, 13, 15, 14, 17, 18, 20, 18, 21, 23, 24, 20, 23, 24])  # Dependent variable: number of reservations
    return days_since_start, reservations

def train_model_and_prepare_data(days_since_start, reservations):
    X = days_since_start.reshape(-1, 1)
    model = LinearRegression()
    model.fit(X, reservations)
    
    # Extend future days beyond the actual data range
    future_days = np.arange(0, 20).reshape(-1, 1)  # Predicting for 20 days
    predicted_reservations = model.predict(future_days)
    
    mse = mean_squared_error(reservations, model.predict(X))
    mae = mean_absolute_error(reservations, model.predict(X))
    r_squared = r2_score(reservations, model.predict(X))
    
    actual_data = {
        'x': days_since_start.tolist(),
        'y': reservations.tolist(),
        'type': 'scatter',
        'mode': 'markers',
        'name': 'Actual data',
        'marker': {'color': 'blue'}
    }
    regression_line = {
        'x': future_days.flatten().tolist(),
        'y': predicted_reservations.tolist(),
        'type': 'scatter',
        'mode': 'lines',
        'name': 'Linear regression line',
        'line': {'color': 'red'}
    }
    return actual_data, regression_line

days_since_start, reservations = generate_random_data()
actual_data, regression_line = train_model_and_prepare_data(days_since_start, reservations)

# Generate random shifts data for admins
number_of_admins = 5
admin_shifts_data = []
for admin in range(number_of_admins):
    num_shifts = random.randint(1, 5)  # Random number of shifts between 1 and 5
    shifts = [random.randint(1, 10) for _ in range(num_shifts)]  # Random data for each shift
    admin_shifts_data.append(shifts)

# Prepare data for the Highcharts graph
admin_series_data = []
for i, shifts in enumerate(admin_shifts_data):
    admin_series_data.append({
        'name': f'Admin {i + 1}',
        'data': shifts
    })

html_content = f"""<?php
session_start();
include 'connect_database.php';
include 'src/get_data_from_database/get_admin_accounts.php';
include 'src/get_data_from_database/get_admin_info.php';
include 'src/get_data_from_database/get_reservation_info.php';
include 'encodeDecode.php';
$key = 'TheGreatestNumberIs73';
date_default_timezone_set('Asia/Manila');

if (isset($_SESSION["userSuperAdminID"])) {{
    $adminNames = [];
    foreach ($arrayAdminAccount as $adminAccount) {{
        $adminInfoID = $adminAccount["adminInfoID"];
        $adminName = decryptData($adminAccount['adminFirstName'], $key) . " " . decryptData($adminAccount['adminMiddleName'], $key) . " " . decryptData($adminAccount['adminLastName'], $key);
        $adminNames[] = $adminName;

        $reservation = 0;
        foreach ($arrayReservationInfo as $reservationInfo) {{
            if ($reservationInfo['adminID'] == $adminAccount['adminID']) {{
                $reservation++;
            }}
        }}
    }}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Akronim&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="src/css/sidebar.css" />
    <link rel="stylesheet" href="src/css/style.css" />
    <link rel="icon" href="src/images/Bevitore-logo.png" type="image/x-icon">
    <style>
      .chartWithMarkerOverlay {{
        position: relative;
        width: 700px;
      }}
      .overlay-text, .overlay-marker {{
        position: absolute;
      }}
      .overlay-text {{
        width: 200px;
        height: 200px;
        top: 50px;
        left: 200px;
      }}
      .overlay-marker {{
        width: 50px;
        height: 50px;
        top: 53px;
        left: 528px;
      }}
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body class="body">
        <!-- Your JavaScript code -->
        <script src="jquery.js"></script> 
    <script> 
    $(function(){{
      $("#includedContent").load("superadmin_sidebar.php"); 
    }});
    </script> 
    <div id="includedContent"></div>

    <section class="home-section">
      <h4 class="qreserve">Customer Demand Forecasting</h4>
      <hr class="my-4 mb-3 mt-3">
      <div class="container-fluid dashboard-square-kebab mb-4" id="reports-first-graph">
        <figure class="highcharts-figure1">
          <div id="container1"></div>
        </figure>
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
        <div class="row justify-content-end">
          <div class="col-12 col-md-2 mb-3 mb-md-0">
            <button class="btn btn-primary w-100 create-button" name="submitReserve" type="submit">Generate Report</button>
          </div>
        </div>
      </div>

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
    </section>

    <script>
      let sidebar = document.querySelector(".sidebar");
      let closeBtn = document.querySelector("#btn");
      let searchBtn = document.querySelector(".bx-search");

      closeBtn.addEventListener("click", () => {{
        sidebar.classList.toggle("open");
        menuBtnChange();
      }});

      searchBtn.addEventListener("click", () => {{
        sidebar.classList.toggle("open");
        menuBtnChange();
      }});

      function menuBtnChange() {{
        if (sidebar.classList.contains("open")) {{
          closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        }} else {{
          closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }}
      }}
    </script>

    <script>
      document.addEventListener("DOMContentLoaded", function() {{
        console.log("Data for regression line:", {json.dumps(regression_line['y'])});
        console.log("Data for actual data:", {json.dumps(actual_data['y'])});

        Highcharts.chart('container1', {{
          title: {{
            text: '',
            align: 'left'
          }},
          yAxis: {{
            title: {{
              text: 'Number of Reservations'
            }}
          }},
          xAxis: {{
            categories: {json.dumps(regression_line['x'])}
          }},
          legend: {{
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
          }},
          plotOptions: {{
            series: {{
              label: {{
                connectorAllowed: false
              }},
              pointStart: 1
            }}
          }},
          series: [{{
            name: 'Predicted Data',
            data: {json.dumps(regression_line['y'])}
          }}, {{
            name: 'Actual Data',
            data: {json.dumps(actual_data['y'])}
          }}],
          responsive: {{
            rules: [{{
              condition: {{
                maxWidth: 500
              }},
              chartOptions: {{
                legend: {{
                  layout: 'horizontal',
                  align: 'center',
                  verticalAlign: 'bottom'
                }}
              }}
            }}]
          }}
        }});

        Highcharts.chart('container2', {{
          chart: {{
            type: 'column'
          }},
          title: {{
            text: 'Peak Hours'
          }},
          xAxis: {{
            categories: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24],
            crosshair: true
          }},
          yAxis: {{
            min: 0,
            title: {{
              text: 'Reservations'
            }}
          }},
          tooltip: {{
            headerFormat: '<span style="font-size:10px">{{point.key}}</span><table>',
            pointFormat: '<tr><td style="color:{{series.color}};padding:0">{{series.name}}: </td>' +
              '<td style="padding:0"><b>{{point.y:.1f}}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
          }},
          plotOptions: {{
            column: {{
              pointPadding: 0.2,
              borderWidth: 0
            }}
          }},
          series: [{{
            name: 'Hours',
            data: [1,2,3,4,5,6,7]
          }}]
        }});

        Highcharts.chart('container3', {{
          chart: {{
            type: 'line'
          }},
          title: {{
            text: 'Admin Shift Report'
          }},
          xAxis: {{
            categories: ['Shift 1', 'Shift 2', 'Shift 3', 'Shift 4', 'Shift 5']
          }},
          yAxis: {{
            title: {{
              text: 'Number of Admins'
            }}
          }},
          plotOptions: {{
            line: {{
              dataLabels: {{
                enabled: true
              }},
              enableMouseTracking: false
            }}
          }},
          series: {json.dumps(admin_series_data)}
        }});
      }});
    </script>
</body>
</html>

<?php
}}
?>
"""

print(html_content)
