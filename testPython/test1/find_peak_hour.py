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
''' for replit testing
host="sql12.freesqldatabase.com",
user="sql12713153",
password="LcbCQaWeEn",
database="sql12713153"
'''
# SQL query to retrieve data
query = """
    SELECT reservationDate, HOUR(reservationTimeStart) as hour, COUNT(*) as reservation_count
    FROM pool_table_reservation
    GROUP BY reservationDate, hour
"""
data = pd.read_sql(query, db_connection)

# Close the database connection
db_connection.close()

# Preprocess the data
data['reservationDate'] = pd.to_datetime(data['reservationDate'])
data = data.sort_values(['reservationDate', 'hour'])

# Group by hour to find the peak hour
hourly_data = data.groupby('hour')['reservation_count'].sum().reset_index()

# Find the peak hour
peak_hour = hourly_data.loc[hourly_data['reservation_count'].idxmax()]

# Prepare data for plotting in Highcharts
hourly_data['timestamp'] = hourly_data['hour'].apply(lambda x: datetime.datetime.combine(datetime.date.today(), datetime.time(x)).timestamp() * 1000)
actual_data = [(int(row['timestamp']), row['reservation_count']) for index, row in hourly_data.iterrows()]

# Generate PHP code with actual data in PHP list
php_code = "<?php\n"
php_code += "$actual_data = [\n" + ",\n".join([f"[{x[0]}, {x[1]}]" for x in actual_data]) + "\n];\n"
php_code += f"$peak_hour = {peak_hour['hour']};\n"
php_code += "?>"

# Write the generated PHP code to a file
with open('data.php', 'w') as file:
    file.write(php_code)

print("PHP code generated and saved to data.php")
