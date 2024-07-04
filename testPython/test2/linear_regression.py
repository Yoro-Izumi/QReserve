import numpy as np
import pandas as pd
from sklearn.linear_model import LinearRegression
import datetime
import json

# Read the data from the JSON file
with open('data.json', 'r') as file:
    data = json.load(file)

# Convert the data to a pandas DataFrame
data = pd.DataFrame(data)
data['date'] = pd.to_datetime(data['date'])

# Aggregate the data by date
data['count'] = 1
data = data.groupby('date').count().reset_index()

# Create a complete date range
start_date = data['date'].min()
end_date = data['date'].max()
date_range = pd.date_range(start=start_date, end=end_date)

# Ensure all dates are present in the dataset
data = data.set_index('date').reindex(date_range, fill_value=0).reset_index()
data.rename(columns={'index': 'date'}, inplace=True)

# Add additional features
data['date_ordinal'] = data['date'].map(datetime.datetime.toordinal)

# Prepare the data for linear regression
X = data[['date_ordinal']]
y = data['count']

# Create and train the model
model = LinearRegression()
model.fit(X, y)

# Generate future dates for prediction
last_date = data['date'].max()
future_dates = [last_date + datetime.timedelta(days=i) for i in range(1, 11)]
future_dates_ordinal = [date.toordinal() for date in future_dates]
X_future = np.array(future_dates_ordinal).reshape(-1, 1)

# Predict using the model and convert predictions to integers
predictions = model.predict(X_future).round().astype(int)

# Format the data for Highcharts
actual_data = [(int(date.timestamp() * 1000), count) for date, count in zip(data['date'], y)]
predicted_data = [(int(date.timestamp() * 1000), count) for date, count in zip(future_dates, predictions)]

# Generate PHP code with actual and predicted data in PHP lists
php_code = "<?php\n"
php_code += "$actual_data = [\n" + ",\n".join([f"[{x[0]}, {x[1]}]" for x in actual_data]) + "\n];\n"
php_code += "$predicted_data = [\n" + ",\n".join([f"[{x[0]}, {x[1]}]" for x in predicted_data]) + "\n];\n"
php_code += "?>"

# Write the generated PHP code to a file
with open('data.php', 'w') as file:
    file.write(php_code)
