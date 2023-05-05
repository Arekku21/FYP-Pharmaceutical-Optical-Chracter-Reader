
medicine_list = ['Panadol','Crocin','Ibuprofen','Aspirin','Brufen','Combiflam','Gasex','Eno','Speman','Bresol']

# high_similarity = ['Banadyl','Crocip','Ibuprufen','Asprint','Bruvex','Combiflame','Gazex','Eon','Semen','Brisol']

# medium_similarity = ['Kodonal', 'Corcin', 'Ibuporfen', 'Spirin', 'Brefun', 'Combifla','Gesax', 'Etno', 'Sapman', 'Bresols']

# low_similarity = ['Panaflam', 'Crinco', 'Ibuprofaen', 'Asperin', 'Bufren', 'Combiflum','Gaxse', 'Ino', 'Spmen', 'Brezol']

# one_letter_only_common = ['Pandalot', 'Crociq', 'Ibuprofeq', 'Asplrin', 'Brufoz', 'Combinil','Gasec', 'Easec', 'Spmnn', 'Breoil']

# same_length_one_transposition = ['Pandynol', 'Corcni', 'Iburpofen', 'Apirsin', 'Bunfer', 'Combiflem','Sagex', 'Onen', 'Sapmen', 'Bresyl']

# same_length_no_transposition = ['Painadol', 'Cronci', 'Ibuprofenp', 'Aspirun', 'Bufren', 'Combiglam','Gasxe', 'Eo', 'Spermen', 'Brisor']

import random

one_letter_change = ['Qanadol','Erocin','Gbuprofen','Bspirin','Orufen','Fombiflam','Tasex','Mno','Gpeman','Yresol']

two_letter_change = ['Qenadol','Esocin','Ghuprofen','Bbpirin','Oyufen','Fqmbiflam','Thsex','Mro','Gjeman','Yhesol']

three_letter_change = ['Qeradol','Esfcin','Ghqprofen','Bbfirin','Oyhfen','Fqnbiflam','Thbex','Mrb','Gjfan','Yhbsol']

four_letter_change = ['Qertdol','Esfhin','Ghqnrofen','Bbfmrin','Oyhlen','Fqnjiflam','Thbkx','Mrb','Gjfvn','Yhbjol']

five_letter_change = ['Qertgol','Esfhtn','Ghqnjofen','Bbfmnin','Oyhlqn','Fqnjkflam','Thbkh','Mrb','Gjfvk','Yhbjgl']

six_letter_change = ['Qertgql','Esfhtq','Ghqnjpfen','Bbfmnqn','Oyhlqp','Fqnjkplam','Thbkh','Mrb','Gjfvk','Yhbjgq']

seven_letter_change = ['Qertgqh','Esfhtq','Ghqnjphen','Bbfmnqq','Oyhlqp','Fqnjkpqam','Thbkh','Mrb','Gjfvk','Yhbjgq']

eight_letter_change = ['Qertgqh','Esfhtq','Ghqnjphgn','Bbfmfqq','Oyhlqp','Fqnjkpqbm','Thbkh','Mrb','Gjfvk','Yhbjgq']

nine_letter_change = ['Qertgqh','Esfhtq','Ghqqjqhgh','Bbfmfqq','Oyhlqp','Fqnjkpqbq','Thbkh','Mrb','Gjfvk','Yhbjgq']


# longest_lenght = []
# longest_lenght.append("")
# longest_lenght.append(0)

# for medicine in medicine_list:
#     print(len(medicine),medicine,longest_lenght[1])
#     if len(medicine) > longest_lenght[1]:
        
#         longest_lenght[1] = len(medicine)
#         longest_lenght[0] = medicine

# print(longest_lenght)



import matplotlib.pyplot as plt
import textdistance

jaro_scores = []
jaro_winkler_scores = []
levenshtein_scores = []

for index in range(len(medicine_list)):
    # Compute the similarity scores using various algorithm

    a = textdistance.jaro(medicine_list[index], nine_letter_change[index])
    jaro_scores.append(a) 

    # print(a,medicine_list[index],high_similarity[index])

    b = textdistance.jaro_winkler(medicine_list[index], nine_letter_change[index])
    jaro_winkler_scores.append(b) 

    c = textdistance.levenshtein.normalized_similarity(medicine_list[index], nine_letter_change[index])
    levenshtein_scores.append(c)

# Create a bar chart to compare the similarity scores
fig, ax = plt.subplots()
x = range(len(nine_letter_change))
width = 0.25

ax.bar(x, jaro_scores, width, label='Jaro')
ax.bar([i + width for i in x], jaro_winkler_scores, width, label='Jaro-Winkler')
ax.bar([i + width*2 for i in x], levenshtein_scores, width, label='Levenshtein')

# Set the chart title and axis labels
ax.set_title('Similarity of Test Strings to Reference String when only 8 letter is changed')
ax.set_xlabel('Test Strings')
ax.set_ylabel('Similarity Scores')

# !labels custom
labels_list = []
for index in range(len(medicine_list)):
    label = medicine_list[index] + "|" + nine_letter_change[index] 
    labels_list.append(label)

# Set the x-axis tick labels
ax.set_xticks([i + width for i in x])
ax.set_xticklabels(labels_list)

# Add a legend and show the chart
plt.legend()
plt.show()


from statistics import mean

while 0.0 in jaro_scores:
    jaro_scores.remove(0.0)

while 0.0 in jaro_winkler_scores:
    jaro_winkler_scores.remove(0.0)

while 0.0 in levenshtein_scores:
    levenshtein_scores.remove(0.0)

print(mean(jaro_scores))
print(mean(jaro_winkler_scores))
print(mean(levenshtein_scores))

