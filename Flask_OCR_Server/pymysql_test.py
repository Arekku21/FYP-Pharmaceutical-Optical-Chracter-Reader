# # import pymysql

# # # Open database connection
# # db = pymysql.connect(host="localhost", user="username", password="password", database="dbpharmacy")

# # # prepare a cursor object using cursor() method
# # cursor = db.cursor()

# # # execute SQL query using execute() method.
# # cursor.execute("SELECT drugName,drugDosage FROM tblmedicine")

# # # Fetch all rows using fetchall() method.
# # data = cursor.fetchall()
# # print(data)
# # print(type(data))

# # # print rows of data
# # for row in data:
# #     print(row)
# #     print(type(row[1]))

# # # disconnect from server
# # db.close()

# ####################################################################

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


# # exact match
# exact_match = [
#     'Panadol',         
#     'Osmoglyn',         
#     'Caphosol',        
#     'Aczone',         
#     'Zytopic',        
#     'Ibuprofen',       
#     'Trexall',        
#     'Cyclogyl',      
#     'Ridactate',        
#     'Bromelain'         
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


# ####################################################################

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

medicine_list = ['Panadol','Crocin','Ibuprofen','Aspirin','Brufen','Combiflam','Gasex','Eno','Speman','Bresol']

panadol_test_strings = [
    'Panadol',         # exact match
    'Banadyl',         # high similarity
    'Pandalol',        # high similarity
    'Kodonal',         # medium similarity
    'Panaflam',        # low similarity
    'Ibuprofen',       # very low similarity
    'Pandalot',        # worst case scenario - only one letter in common
    'Ampicillin',      # worst case scenario - no letters in common
    'Pandynol',        # best case scenario - same length and only one transposition
    'Painadol'         # best case scenario - same length and no transpositions
]

crocin_test_strings = [
    'Crocin',          # exact match
    'Crocip',          # high similarity
    'Cricin',          # high similarity
    'Corcin',          # medium similarity
    'Crinco',          # low similarity
    'Ibuprofen',       # very low similarity
    'Crociq',          # worst case scenario - only one letter in common
    'Ampicillin',      # worst case scenario - no letters in common
    'Corcni',          # best case scenario - same length and only one transposition
    'Cronci'           # best case scenario - same length and no transpositions
]

ibuprofen_test_strings = [
    'Ibuprofen',       # exact match
    'Ibuprufen',       # high similarity
    'Ibuprofn',        # high similarity
    'Ibuporfen',       # medium similarity
    'Ibuprofaen',      # low similarity
    'Crocin',          # very low similarity
    'Ibuprofeq',       # worst case scenario - only one letter in common
    'Ampicillin',      # worst case scenario - no letters in common
    'Iburpofen',       # best case scenario - same length and only one transposition
    'Ibuprofenp'       # best case scenario - same length and no transpositions
]

aspirin_test_strings = [
    'Aspirin',         # exact match
    'Asprint',         # high similarity
    'Aspiron',         # high similarity
    'Spirin',          # medium similarity
    'Asperin',         # low similarity
    'Ibuprofen',       # very low similarity
    'Asplrin',         # worst case scenario - only one letter in common
    'Penicillin',      # worst case scenario - no letters in common
    'Apirsin',         # best case scenario - same length and only one substitution
    'Aspirun'          # best case scenario - same length and no substitutions
]

brufen_test_strings = [
    'Brufen',         # exact match
    'Bruvex',         # high similarity
    'Brusen',         # high similarity
    'Brefun',         # medium similarity
    'Bufren',         # low similarity
    'Ibuprofen',      # very low similarity
    'Brufoz',         # worst case scenario - only one letter in common
    'Acetaminophen',  # worst case scenario - no letters in common
    'Bunfer',         # best case scenario - same length and only one transposition
    'Bufren'          # best case scenario - same length and no transpositions
]

combiflam_test_strings = [
    'Combiflam',            # exact match
    'Combiflame',           # high similarity
    'Comfilam',             # high similarity
    'Combifla',             # medium similarity
    'Combiflum',            # low similarity
    'Ibuprofen',            # very low similarity
    'Combinil',             # worst case scenario - only one letter in common
    'Alprazolam',           # worst case scenario - no letters in common
    'Combiflem',            # best case scenario - same length and only one substitution
    'Combiglam'             # best case scenario - same length and no substitutions
]

gasex_test_strings = [
    'Gasex',           # exact match
    'Gazex',           # high similarity
    'Gasez',           # high similarity
    'Gesax',           # medium similarity
    'Gaxse',           # low similarity
    'Antacid',         # very low similarity
    'Gasec',           # worst case scenario - only one letter in common
    'Ibuprofen',       # worst case scenario - no letters in common
    'Sagex',           # best case scenario - same length and only one transposition
    'Gasxe'            # best case scenario - same length and no transpositions
]

eno_test_strings = [
    'Eno',             # exact match
    'Eon',             # high similarity
    'Neo',             # high similarity
    'Etno',            # medium similarity
    'Ino',             # low similarity
    'Antacid',         # very low similarity
    'Easec',           # worst case scenario - only one letter in common
    'Ibuprofen',       # worst case scenario - no letters in common
    'Onen',            # best case scenario - same length and only one transposition
    'Eo'               # best case scenario - same length and no substitutions or transpositions
]

speman_test_strings = [
    'Speman',              # exact match
    'Semen',               # high similarity
    'Spean',               # high similarity
    'Sapman',              # medium similarity
    'Spmen',               # low similarity
    'Ibuprofen',           # very low similarity
    'Spmnn',               # worst case scenario - only one letter in common
    'Aspirin',             # worst case scenario - no letters in common
    'Sapmen',              # best case scenario - same length and only one substitution
    'Spermen',             # best case scenario - same length and no substitutions
]

bresol_test_strings = [
    'Bresol',              # exact match
    'Brisol',              # high similarity
    'Bresil',              # high similarity
    'Bresols',             # medium similarity
    'Brezol',              # low similarity
    'Ibuprofen',           # very low similarity
    'Breoil',              # worst case scenario - only one letter in common
    'Acetaminophen',       # worst case scenario - no letters in common
    'Bresyl',              # best case scenario - same length and only one substitution
    'Brisor',              # best case scenario - same length and no substitutions
]

medicine_dosage = [
    {'name': 'Panadol', 'dosage': '500mg', 'active_ingredient': 'Paracetamol'},
    {'name': 'Crocin', 'dosage': '500mg', 'active_ingredient': 'Paracetamol'},
    {'name': 'Ibuprofen', 'dosage': '200mg-400mg', 'active_ingredient': 'Ibuprofen'},
    {'name': 'Aspirin', 'dosage': '81mg-325mg', 'active_ingredient': 'Acetylsalicylic acid'},
    {'name': 'Brufen', 'dosage': '200mg-400mg', 'active_ingredient': 'Ibuprofen'},
    {'name': 'Combiflam', 'dosage': '400mg-600mg', 'active_ingredient': 'Ibuprofen + Paracetamol'},
    {'name': 'Gasex', 'dosage': '2 tablets', 'active_ingredient': 'Ayurvedic herbs and minerals'},
    {'name': 'Eno', 'dosage': '1-2 sachets', 'active_ingredient': 'Sodium bicarbonate'},
    {'name': 'Speman', 'dosage': '2 tablets', 'active_ingredient': 'Ayurvedic herbs and minerals'},
    {'name': 'Bresol', 'dosage': '2 tablets', 'active_ingredient': 'Ayurvedic herbs and minerals'}
]

sample_list = []

sample_list.append(panadol_test_strings[9])    #10 
sample_list.append(crocin_test_strings[9])     #10 
sample_list.append(ibuprofen_test_strings[9])  #10
sample_list.append(aspirin_test_strings[9])    #10 
sample_list.append(brufen_test_strings[9])     #10 sample_list.append(combiflam_test_strings))  #10
sample_list.append(gasex_test_strings[9])      #10
sample_list.append(eno_test_strings[9])       #11
sample_list.append(speman_test_strings[9])     #15
sample_list.append(bresol_test_strings[9])     #15

print(sample_list)



