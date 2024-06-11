#!C:\Users\Yoro PC\AppData\Local\Programs\Python\Python312\python.exe
import numpy as np
from sklearn.linear_model import LinearRegression
#from sklearn.metrics import mean_squared_error, mean_absolute_error, r2_score
import json
# Sample data
X_train = np.array([[1], [2], [3], [4], [5]])
y_train = np.array([2, 4, 5, 4, 5])

# Create and fit the model
model = LinearRegression()
model.fit(X_train, y_train)

# Predict
X_test = np.array([[6], [7], [8]])
y_pred = model.predict(X_test)

# Convert arrays to lists for easier handling in JavaScript
X_test_list = X_test.tolist()
y_pred_list = y_pred.tolist()

# Convert to JSON format
X_test_json = json.dumps(X_test_list)
y_pred_json = json.dumps(y_pred_list)

"""
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

data = [actual_data, regression_line, predicted_data]
print(json.dumps(data))"""
