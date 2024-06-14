#!C:\Users\Yoro PC\AppData\Local\Programs\Python\Python312\python.exe
import numpy as np
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_squared_error, mean_absolute_error, r2_score
import json

print("Content-Type: text/html")
print()

def generate_random_data():
    days_since_start = np.arange(1, 30)
    reservations = np.random.randint(10, 25, size=len(days_since_start))
    return days_since_start, reservations

def train_model_and_prepare_data(days_since_start, reservations):
    X = days_since_start.reshape(-1, 1)
    model = LinearRegression()
    model.fit(X, reservations)
    future_days = np.arange(3, 19, 2).reshape(-1, 1)
    predicted_reservations = model.predict(future_days)
    mse = mean_squared_error(reservations, model.predict(X))
    mae = mean_absolute_error(reservations, model.predict(X))
    r_squared = r2_score(reservations, model.predict(X))
    print("Mean Squared Error (MSE):", mse)
    print("Mean Absolute Error (MAE):", mae) 
    print("R-squared:", r_squared)
    actual_data = {
        'x': days_since_start.tolist(),
        'y': reservations.tolist(),
        'type': 'scatter',
        'mode': 'markers',
        'name': 'Actual data',
        'marker': {'color': 'blue'}
    }
    regression_line = {
        'x': days_since_start.tolist(),
        'y': model.predict(X).tolist(),
        'type': 'scatter',
        'mode': 'lines',
        'name': 'Linear regression line',
        'line': {'color': 'red'}
    }
    predicted_data = {
        'x': future_days.flatten().tolist(),
        'y': predicted_reservations.tolist(),
        'type': 'scatter',
        'mode': 'markers',
        'name': 'Predicted data',
        'marker': {'color': 'green'}
    }
    return actual_data, regression_line, predicted_data

days_since_start, reservations = generate_random_data()
actual_data, regression_line, predicted_data = train_model_and_prepare_data(days_since_start, reservations)

html_content = f"""
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Number of Reservations per Day</title>
    <script src="src/js/plotly-latest.min.js"></script>
</head>
<body>
    <div id="plot"></div>
    <script>
        var data = {json.dumps([actual_data, regression_line, predicted_data])};
        var layout = {{
            title: 'Number of Reservations per Day',
            xaxis: {{
                title: 'Days since Start'
            }},
            yaxis: {{
                title: 'Number of Reservations'
            }},
            legend: {{
                x: 1,
                xanchor: 'right',
                y: 1
            }},
            grid: {{
                rows: 1, columns: 1, pattern: 'independent'
            }}
        }};
        Plotly.newPlot('plot', data, layout);
    </script>
</body>
</html>
"""

print(html_content)
