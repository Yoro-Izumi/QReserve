#!C:\Users\Yoro PC\AppData\Local\Programs\Python\Python312\python.exe
import os
import cgi
import cgitb
import pymysql
import pandas as pd
from sklearn.linear_model import LinearRegression
import matplotlib
matplotlib.use('Agg')  # Use the non-interactive Agg backend
import matplotlib.pyplot as plt

# Enable CGI traceback for debugging
cgitb.enable(display=0, logdir="C:/xampp/htdocs/logs")

# Set Matplotlib configuration directory explicitly
os.environ['MPLCONFIGDIR'] = 'C:/xampp/htdocs/tmp'

# Set content type for HTTP response
print("Content-Type: text/html\n")

try:
    # Connect to MySQL database
    connection = pymysql.connect(
        host='localhost',
        user='root',
        password='',
        database='test',
        charset='latin1_swedish_ci',
        cursorclass=pymysql.cursors.DictCursor
    )

    try:
        # Query data from the database
        with connection.cursor() as cursor:
            sql = "SELECT date, number FROM test_table"
            cursor.execute(sql)
            result = cursor.fetchall()

        # Convert result to DataFrame
        df = pd.DataFrame(result)
    
    finally:
        connection.close()

    # Convert date column to datetime type
    df['date'] = pd.to_datetime(df['date'])

    # Extract independent and dependent variables
    X = df['date'].view(int) / 10**9  # Convert dates to Unix timestamps (seconds since epoch)
    y = df['number']

    # Reshape X to be a 2D array
    X = X.values.reshape(-1, 1)

    # Create and fit the linear regression model
    model = LinearRegression()
    model.fit(X, y)

    # Predict y values using the model
    y_pred = model.predict(X)

    # Visualize the results
    plt.scatter(df['date'], df['number'], color='blue', label='Data')
    plt.plot(df['date'], y_pred, color='red', linewidth=2, label='Linear Regression')
    plt.xlabel('Date')
    plt.ylabel('Number')
    plt.title('Linear Regression')
    plt.legend()
    
    # Save plot as a file in the document root directory
    plot_path = 'C:/xampp/htdocs/linear_regression_plot.png'
    plt.savefig(plot_path)
    plt.close()  # Close the plot to prevent display

    # Output the HTML to display the image
    print(f"""
    <html>
    <head><title>Linear Regression Plot</title></head>
    <body>
    <h1>Linear Regression Plot</h1>
    <img src="/linear_regression_plot.png" alt="Linear Regression Plot">
    </body>
    </html>
    """)

except Exception as e:
    # Output the error message for debugging purposes
    print(f"<h1>Error</h1><p>{str(e)}</p>")

