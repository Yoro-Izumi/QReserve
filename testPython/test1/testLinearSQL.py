#!C:\Users\Yoro PC\AppData\Local\Programs\Python\Python312\python.exe
import numpy as np
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_squared_error, mean_absolute_error, r2_score
import json
import random
print("Content-Type: text/html\n")
import mysql.connector


# Connect to your database
mydb = mysql.connector.connect(
    host="local",
    user="root",
    password="",
    database="qreserve_data"
)


def fetch_data_from_database():
    cursor = mydb.cursor()
    cursor.execute("SELECT * FROM pool_table_history")
    data = cursor.fetchall()
    days_since_start = []
    reservations = []
    for row in data:
        days_since_start.append(row[0])
        reservations.append(row[1])
    return np.array(days_since_start), np.array(reservations)

def train_model_and_prepare_data(days_since_start, reservations):
    X = days_since_start.reshape(-1, 1)
    model = LinearRegression()
    model.fit(X, reservations)
    
    # Extend future days beyond the actual data range
    future_days = np.arange(0, len(days_since_start) + 20).reshape(-1, 1)  # Predicting for 20 days
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

days_since_start, reservations = fetch_data_from_database()
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
    <!-- Head content goes here -->
</head>

<body class="body">
    <!-- Sidebar and other HTML content goes here -->

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
                // Second chart configuration
            }});

            Highcharts.chart('container3', {{
                // Third chart configuration
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
