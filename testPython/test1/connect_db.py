#!C:\Users\Yoro PC\AppData\Local\Programs\Python\Python312\python.exe
print("Content-Type: text/html\n")
import mysql.connector

# Establishing a connection to the MySQL database
connection = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="test"
)

# Creating a cursor object to interact with the database
cursor = connection.cursor()

try:
    # Execute a SQL query
    cursor.execute("SELECT * FROM pol_table_history")

    # Fetch all rows from the result set
    rows = cursor.fetchall()

    # Print the rows in HTML format
    print("<html><body><table border='1'>")
    print("<tr><th>Date</th><th>Number</th></tr>")
    for row in rows:
        print(f"<tr><td>{row[0]}</td><td>{row[1]}</td></tr>")
    print("</table></body></html>")

except mysql.connector.Error as error:
    print("<html><body><h1>Error fetching data from MySQL table:</h1>")
    print(f"<p>{error}</p></body></html>")

finally:
    # Closing the cursor and the database connection
    if cursor:
        cursor.close()
    if connection:
        connection.close()
