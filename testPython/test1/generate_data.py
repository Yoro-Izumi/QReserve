#!C:\Users\Yoro PC\AppData\Local\Programs\Python\Python312\python.exe

import json
from sklearn.linear_model import LinearRegression

# Sample data: number of reservations per day
days_since_start = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
reservations = [10, 13, 15, 14, 17, 18, 20, 18, 21, 23, 24, 20, 23, 24]

# Reshape the data for sklearn (2D list required)
X = [[day] for day in days_since_start]

# Train the linear regression model
model = LinearRegression()
model.fit(X, reservations)

# Forecasting: predict reservations for future days
future_days = [[15], [16], [17], [18], [19], [20]]  # Example: predict for the next 6 days
predicted_reservations = model.predict(future_days)

# Prepare data for JSON output
data = {
    "days_since_start": days_since_start,
    "reservations": reservations,
    "future_days": [day[0] for day in future_days],
    "predicted_reservations": predicted_reservations.tolist()
}

# Save data to a JSON file
with open('data.json', 'w') as json_file:
    json.dump(data, json_file)

print("Content-Type: text/html\n")
print("<html><body><h1>Data generated and saved to data.json</h1></body></html>")
