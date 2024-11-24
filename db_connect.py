import mysql.connector

try:
    print("Connecting to MySQL...")
    connection = mysql.connector.connect(
        host="mysql",  # This is the Docker service name
        port=3307,     # Port 3307 as per your Docker settings
        user="root",   # Your MySQL user
        password="your_password",  # Your MySQL password
        database="rcmwa_db"  # Database name
    )
    
    if connection.is_connected():
        print("Successfully connected to MySQL")
    
except mysql.connector.Error as err:
    print(f"Error: {err}")
    
finally:
    if 'connection' in locals() and connection.is_connected():
        connection.close()
        print("Connection closed.")
