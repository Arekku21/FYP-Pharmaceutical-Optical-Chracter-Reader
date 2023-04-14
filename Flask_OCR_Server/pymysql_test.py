import pymysql

# Open database connection
db = pymysql.connect(host="localhost", user="username", password="password", database="dbpharmacy")

# prepare a cursor object using cursor() method
cursor = db.cursor()

# execute SQL query using execute() method.
cursor.execute("SELECT drugName,drugDosage FROM tblmedicine")

# Fetch all rows using fetchall() method.
data = cursor.fetchall()
print(data)
print(type(data))

# print rows of data
for row in data:
    print(row)
    print(type(row[1]))

# disconnect from server
db.close()

####################################################################

# import textdistance
# import matplotlib.pyplot as plt

# test_strings = [
#     'Panadol',         # exact match
#     'Banadyl',         # high similarity
#     'Pandalol',        # high similarity
#     'Kodonal',         # medium similarity
#     'Panaflam',        # low similarity
#     'Ibuprofen',       # very low similarity
#     'Pandalot',        # worst case scenario - only one letter in common
#     'Ampicillin',      # worst case scenario - no letters in common
#     'Pandynol',        # best case scenario - same length and only one transposition
#     'Painadol'         # best case scenario - same length and no transpositions
# ]

# panadol = 'Panadol'

# # Compute the Jaro-Winkler distance between each test string and "Panadol"
# distances = []
# for test_string in test_strings:
#     jaro_winkler = textdistance.jaro_winkler(panadol, test_string)
#     distances.append(jaro_winkler)

# # Plot the distances as a bar graph
# plt.bar(test_strings, distances)
# plt.title('Similarity of test strings to "Panadol"')
# plt.xlabel('Test strings')
# plt.ylabel('Jaro-Winkler distance')
# plt.xticks(rotation=90)
# plt.show()


#####################################################################

# import matplotlib.pyplot as plt
# import textdistance

# # # Define the test strings
# # test_strings = [
# #     "panadol",
# #     "panadole",
# #     "penodol",
# #     "adol",
# #     "paracetamol",
# #     "aspirin",
# #     "ibuprofen",
# #     "tylenol",
# #     "acetaminophen",
# #     "calpol"
# # ]

# # Define the reference string
# reference_string = "650"

# test_strings = [
#     "650",                   # Exact match
#     "650x",                  # Minor variation
#     "560",                   # Transposition
#     "Six fifty",             # Textual representation
#     "550",                   # Substitution
#     "650.00",                # Minor formatting difference
#     "6-5-0",                 # Non-digit characters
#     "6fifty",                # Non-standard spacing
#     "650,000",               # Numeric separator
#     "six hundred fifty"      # Textual representation
# ]

# position_changes = [
#     "650", "506", "065", "056", "605", "560"
# ]


# # Compute the similarity scores using various algorithms
# jaro_scores = [textdistance.jaro(reference_string, s) for s in position_changes]
# jaro_winkler_scores = [textdistance.jaro_winkler(reference_string, s) for s in position_changes]
# levenshtein_scores = [textdistance.levenshtein.normalized_similarity(reference_string, s) for s in position_changes]

# # Create a bar chart to compare the similarity scores
# fig, ax = plt.subplots()
# x = range(len(position_changes))
# width = 0.25

# ax.bar(x, jaro_scores, width, label='Jaro')
# ax.bar([i + width for i in x], jaro_winkler_scores, width, label='Jaro-Winkler')
# ax.bar([i + width*2 for i in x], levenshtein_scores, width, label='Levenshtein')

# # Set the chart title and axis labels
# ax.set_title('Similarity of Test Strings to Reference String')
# ax.set_xlabel('Test Strings')
# ax.set_ylabel('Similarity Scores')

# # Set the x-axis tick labels
# ax.set_xticks([i + width for i in x])
# ax.set_xticklabels(position_changes)

# # Add a legend and show the chart
# plt.legend()
# plt.show()




