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

# Fit the SARIMA model including historical data
order = (1, 1, 1)  # (p, d, q) parameters for the non-seasonal part of the model
seasonal_order = (1, 1, 1, 7)  # (P, D, Q, s) parameters for the seasonal part of the model
model = SARIMAX(data['reservation_count'], order=order, seasonal_order=seasonal_order)
results = model.fit()

# Generate future dates for prediction
forecast_steps = 10  # Number of days to forecast
# Extend the index to include future dates
date_range = pd.date_range(start=data.index.min(), periods=len(data) + forecast_steps, freq='D')

# Predict using the model, including historical data
forecast = results.get_forecast(steps=len(date_range) - len(data))
predictions = forecast.predicted_mean

# Combine predictions with existing data
combined_data = pd.concat([data, predictions], axis=0)

# Format the data for Highcharts
actual_data = [(int(date.timestamp() * 1000), count) for date, count in zip(data.index, data['reservation_count'])]
predicted_data = [(int(date.timestamp() * 1000), count) for date, count in zip(date_range[len(data):], predictions)]

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
