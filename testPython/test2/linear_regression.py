import numpy as np
import pandas as pd
from sklearn.linear_model import LinearRegression
import mysql.connector
import datetime

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
data['date_ordinal'] = data['reservationDate'].map(datetime.datetime.toordinal)

# Prepare the data for linear regression
X = data['date_ordinal'].values.reshape(-1, 1)
y = data['reservation_count'].values

# Create and train the model
model = LinearRegression()
model.fit(X, y)

# Generate future dates for prediction
last_date = data['reservationDate'].max()
future_dates = [last_date + datetime.timedelta(days=i) for i in range(1, 11)]
future_dates_ordinal = [date.toordinal() for date in future_dates]
X_future = np.array(future_dates_ordinal).reshape(-1, 1)

# Predict using the model
predictions = model.predict(X_future)

# Format the data for Highcharts
actual_data = [(int(date.timestamp() * 1000), count) for date, count in zip(data['reservationDate'], y)]
predicted_data = [(int(date.timestamp() * 1000), count) for date, count in zip(future_dates, predictions)]

# Generate PHP code with actual and predicted data in PHP lists
php_code = "<?php\n"
php_code += "$actual_data = [\n" + ",\n".join([f"[{x[0]}, {x[1]}]" for x in actual_data]) + "\n];\n"
php_code += "$predicted_data = [\n" + ",\n".join([f"[{x[0]}, {x[1]}]" for x in predicted_data]) + "\n];\n"
php_code += "?>"

# Write the generated PHP code to a file
with open('data.php', 'w') as file:
    file.write(php_code)

print("PHP code generated and saved to data.php")
