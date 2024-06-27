import numpy as np
import pandas as pd
import mysql.connector
import datetime
import os
from statsmodels.tsa.statespace.sarimax import SARIMAX

# Database connection
db_connection = mysql.connector.connect(
    host="sql12.freesqldatabase.com",
    user="sql12713153",
    password="LcbCQaWeEn",
    database="sql12713153"
)

# SQL query to retrieve data
query = "SELECT reservationDate, COUNT(*) as reservation_count FROM pool_table_reservation GROUP BY reservationDate"
data = pd.read_sql(query, db_connection)

# Close the database connection
db_connection.close()

# Preprocess the data
data['reservationDate'] = pd.to_datetime(data['reservationDate'])
data = data.sort_values('reservationDate')
data.set_index('reservationDate', inplace=True)

# Fit the SARIMA model
order = (1, 1, 1)  # (p, d, q) parameters for the non-seasonal part of the model
seasonal_order = (1, 1, 1, 7)  # (P, D, Q, s) parameters for the seasonal part of the model
model = SARIMAX(data['reservation_count'], order=order, seasonal_order=seasonal_order)
results = model.fit()

# Generate future dates for prediction
forecast_steps = 10  # Number of days to forecast
future_dates = [data.index.max() + datetime.timedelta(days=i) for i in range(1, forecast_steps + 1)]

# Predict using the model
forecast = results.get_forecast(steps=forecast_steps)
predictions = forecast.predicted_mean

# Combine predictions with future dates
prediction_df = pd.DataFrame({'reservation_count': predictions}, index=future_dates)

# Format the data for Highcharts
actual_data = [(int(date.timestamp() * 1000), count) for date, count in zip(data.index, data['reservation_count'])]
predicted_data = [(int(date.timestamp() * 1000), count) for date, count in zip(prediction_df.index, prediction_df['reservation_count'])]

# Generate PHP code with actual and predicted data in PHP lists
php_code = "<?php\n"
php_code += "$actual_data = [\n" + ",\n".join([f"[{x[0]}, {x[1]}]" for x in actual_data]) + "\n];\n"
php_code += "$predicted_data = [\n" + ",\n".join([f"[{x[0]}, {x[1]}]" for x in predicted_data]) + "\n];\n"
php_code += "?>"

# Define the path for the PHP file
php_file_path = os.path.join(os.path.dirname(__file__), 'data.php')

# Write the generated PHP code to a file
with open(php_file_path, 'w') as file:
    file.write(php_code)

print(f"PHP code generated and saved to {php_file_path}")
