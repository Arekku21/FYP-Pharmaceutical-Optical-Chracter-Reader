
medicine_list = ['Panadol','Crocin','Ibuprofen','Aspirin','Brufen','Combiflam','Gasex','Eno','Speman','Bresol']

high_similarity = ['Banadyl','Crocip','Ibuprufen','Asprint','Bruvex','Combiflame','Gazex','Eon','Semen','Brisol']

medium_similarity = ['Kodonal', 'Corcin', 'Ibuporfen', 'Spirin', 'Brefun', 'Combifla','Gesax', 'Etno', 'Sapman', 'Bresols']

low_similarity = ['Panaflam', 'Crinco', 'Ibuprofaen', 'Asperin', 'Bufren', 'Combiflum','Gaxse', 'Ino', 'Spmen', 'Brezol']

one_letter_only_common = ['Pandalot', 'Crociq', 'Ibuprofeq', 'Asplrin', 'Brufoz', 'Combinil','Gasec', 'Easec', 'Spmnn', 'Breoil']

same_length_one_transposition = ['Pandynol', 'Corcni', 'Iburpofen', 'Apirsin', 'Bunfer', 'Combiflem','Sagex', 'Onen', 'Sapmen', 'Bresyl']

same_length_no_transposition = ['Painadol', 'Cronci', 'Ibuprofenp', 'Aspirun', 'Bufren', 'Combiglam','Gasxe', 'Eo', 'Spermen', 'Brisor']



import matplotlib.pyplot as plt
import textdistance


jaro_scores = []
jaro_winkler_scores = []
levenshtein_scores = []

for index in range(len(medicine_list)):
    # Compute the similarity scores using various algorithm

    a = textdistance.jaro(medicine_list[index], same_length_no_transposition[index])
    jaro_scores.append(a) 

    # print(a,medicine_list[index],high_similarity[index])

    b = textdistance.jaro_winkler(medicine_list[index], same_length_no_transposition[index])
    jaro_winkler_scores.append(b) 

    c = textdistance.levenshtein.normalized_similarity(medicine_list[index], same_length_no_transposition[index])
    levenshtein_scores.append(c)


# Create a bar chart to compare the similarity scores
fig, ax = plt.subplots()
x = range(len(same_length_no_transposition))
width = 0.25

ax.bar(x, jaro_scores, width, label='Jaro')
ax.bar([i + width for i in x], jaro_winkler_scores, width, label='Jaro-Winkler')
ax.bar([i + width*2 for i in x], levenshtein_scores, width, label='Levenshtein')

# Set the chart title and axis labels
ax.set_title('Similarity of Test Strings to Reference String')
ax.set_xlabel('Test Strings')
ax.set_ylabel('Similarity Scores')

# !labels custom
labels_list = []
for index in range(len(medicine_list)):
    label = medicine_list[index] + "|" + same_length_no_transposition[index] 
    labels_list.append(label)

# Set the x-axis tick labels
ax.set_xticks([i + width for i in x])
ax.set_xticklabels(labels_list)

# Add a legend and show the chart
plt.legend()
plt.show()
