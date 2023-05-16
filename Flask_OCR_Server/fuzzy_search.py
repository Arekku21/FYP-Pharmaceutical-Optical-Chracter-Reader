# import pymysql

# # Open database connection
# db = pymysql.connect(host="localhost", user="username", password="password", database="dbpharmacy")

# # prepare a cursor object using cursor() method
# cursor = db.cursor()

# # execute SQL query using execute() method.
# cursor.execute("SELECT drugName,drugDosage FROM tblmedicine")

# # Fetch all rows using fetchall() method.
# data = cursor.fetchall()
# print(data)
# print(type(data))

# # print rows of data
# for row in data:
#     print(row)

# # disconnect from server
# db.close()

# import textdistance


# drugs_records = (('LORATADINE', 10), ('LEVOCETIRIZINE', 5), ('PANADOL', 650))

# def fuzzy_search(list_of_words, confidence_no=0.6):

    

#     list_of_confidence_words = []

#     return list_of_confidence_words


import pymysql
import numpy as np

# Connect to MySQL database
connection = pymysql.connect(host='localhost',
                             user='username',
                             password='password',
                             db='dbpharmacy')

# Define SQL query
query = "SELECT drugName,drugDosage FROM tblmedicine"

# Execute query
cursor = connection.cursor()
cursor.execute(query)

# Fetch all the rows and store in a list
rows = cursor.fetchall()

# Convert list of tuples to a numpy array
arr = np.array(rows)

# Close the cursor and database connection
cursor.close()
connection.close()

# Print the numpy array
print(arr)
