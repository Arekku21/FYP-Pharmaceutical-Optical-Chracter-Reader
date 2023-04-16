# import requests

# import base64

# # import cv2, numpy as np, pytesseract
# # from  pytesseract import Output

# with open("api_test.png", "rb") as f:
#     im_b64 = base64.b64encode(f.read())

# # print(im_b64)

# # if im_b64 == php:
# #     print(1)

# url = 'http://127.0.0.1:5000//api/pytesseract/output/best_confidence'
# #url = 'http://127.0.0.1:5000/api/pytesseract/output/dictionary'


# # #demonstrate how to use the 'params' parameter:
# # x = requests.get(url, params = {"image": im_b64})

# #demonstrate how to use the 'params' parameter:
# x = requests.get(url, params = {"image": im_b64})

# print(x.url)

# #print the response (the content of the requested file):

# result = x.text
# print(result)

# print(type(result))



############################################################################

#! request post json

import requests

import base64

# import cv2, numpy as np, pytesseract
# from  pytesseract import Output

with open("api_test5.png", "rb") as f:
    im_b64 = base64.b64encode(f.read())

sent_image = im_b64.decode('utf-8')  

#url = 'http://127.0.0.1:5000/api/pytesseract/output/dictionary'
url = 'http://127.0.0.1:5000//api/easyocr/output/best_confidence'
myobj = {"image": sent_image}

x = requests.post(url, json = myobj)

#print the response text (the content of the requested file):

print(x.text)
print(type(x.text))

############################################################################

# # # ! Testing for Returning base64 image with bounding boxes and text

# import easyocr
# from PIL import Image
# import cv2 as cv, matplotlib as plt, numpy as np

# im_file = "api_test6.png"

# import base64

# from io import BytesIO

# with open(im_file, "rb") as f:
#     sent_image = base64.b64encode(f.read())

# sent_image = sent_image.decode('utf-8')  

# str_decoded_bytes = bytes(sent_image, 'utf-8')

# im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
# im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
# img = cv.imdecode(im_arr, flags=cv.IMREAD_COLOR)


# #img = cv.imread(img) 

# reader = easyocr.Reader(['en'], gpu=True)
# result = reader.readtext(im_bytes,detail=1)

# print(result)

# image2 = img.copy()

# number_test = 0

# for bounding_boxes in result:

#     print("\n",bounding_boxes)

#     points = bounding_boxes[0]

#     print(points)
#     print(type(points[0][0]))

#     numpy_array_points = np.array(points)

#     rect = cv.boundingRect(numpy_array_points.astype(np.float32))
#     x, y, w, h = rect

#     cv.rectangle(image2, (x, y), (x + w, y + h), (0, 0, 255), 1)
#     cv.putText(image2, bounding_boxes[1], (x, y-5), cv.FONT_HERSHEY_SIMPLEX, 0.5, (0,0,255), 1)

#     number_test+=1

    
# retval, buffer = cv.imencode('.jpg', image2)
# jpg_as_text = base64.b64encode(buffer)
# print(jpg_as_text)

# # send_back_image = base64.b64encode(image2)

# sent_image = jpg_as_text.decode('utf-8')  

# str_decoded_bytes = bytes(sent_image, 'utf-8')

# im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
# im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
# img = cv.imdecode(im_arr, flags=cv.IMREAD_COLOR)

# cv.imshow('Cropped_image',img)
# cv.waitKey(0)
# cv.destroyAllWindows()

# cv.imshow('Cropped_image',image2)
# cv.waitKey(0)
# cv.destroyAllWindows()

###################################################################################

# import easyocr
# from PIL import Image

# import base64

# from io import BytesIO

# with open("test_image.png", "rb") as f:
#     sent_image = base64.b64encode(f.read())

# sent_image = sent_image.decode('utf-8')  

# str_decoded_bytes = bytes(sent_image, 'utf-8')

# im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
# im_file = BytesIO(im_bytes)  # convert image to file-like object
# img = Image.open(im_file)   # img is now PIL Image object

# reader = easyocr.Reader(['en'], gpu=True)
# result = reader.readtext(im_bytes)

# print(result)

###################################################################################

# import string, re

# def dosagepreprocessing(textprocess):
#     """
#     Function to clean words to get the dosage
#     :param list of numbers:
#     :return: dosage or empty string
#     """
#     #uppercase all the letters
#     text_to_process = textprocess.upper()

#     #remove the punctuations
#     text_to_process = "".join([char for char in text_to_process if char not in string.punctuation])

#     #use try or it will error
#     try:
#         #use regex
#         text_to_process = re.search("(\d+)(MG)", text_to_process).group()

#         text_to_process = re.search("(\d+)", text_to_process).group()
#     except:
#         text_to_process = ""
            
#     return text_to_process
# a = dosagepreprocessing("Medicine 2 44mg Medicinere 54 mg")

# print(a)
# print(type(a))

###################################################################################

# #! request post json test database api

# import requests

# import base64

# # import cv2, numpy as np, pytesseract
# # from  pytesseract import Output
 

# #url = 'http://127.0.0.1:5000/api/pytesseract/output/dictionary'
# url = 'http://127.0.0.1:5000//api/medicinerecords/read'


# x = requests.post(url)

# #print the response text (the content of the requested file):

# print(x.text)
# print(type(x.text))

########################################################################################

# import easyocr
# from PIL import Image
# import cv2 as cv, matplotlib as plt, numpy as np

# im_file = "api_test.png"

# import base64

# from io import BytesIO

# with open(im_file, "rb") as f:
#     sent_image = base64.b64encode(f.read())

# sent_image = sent_image.decode('utf-8')  

# str_decoded_bytes = bytes(sent_image, 'utf-8')

# im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image

# reader = easyocr.Reader(['en'], gpu=True)
# result = reader.readtext(im_bytes,detail=1)

# print(result)

# import numpy as np, textdistance as td

# medicine = [['LORATADINE','10'],['LEVOCETIRIZINE','5'],['PANADOL','650']]

# medicine_list = np.array(medicine)

# ocr_results_actual = ["DEOJAJAS","AMPICILLIN","KODONAL","PADOL", "LORADOL", "BINEDOL"]

# for item in ocr_results_actual:
#     a = item.upper()

#     item = a


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

# fuzzy_search_results = {}

# number = 0

# for word in ocr_results_actual:
#     print(number)
#     number+=1

#     #scores assignment
#     jw_best_score = 0.0
#     ld_best_score = 0.0

#     #best input for each algorithm
#     jw_best_input = ""
#     ld_best_input = ""

#     for record in medicine_list:

#         jw_score = td.jaro_winkler(word,record[0])
#         ld_score = td.levenshtein.normalized_similarity(word, record[0])

#         print(word,record[0], jw_score, ld_score)

#         if jw_score > jw_best_score:

#             jw_best_score = jw_score
#             jw_best_input = word

#             #output
#             fuzzy_search_results["jw_best_match"] = record[0]

#         if ld_score > ld_best_score:

#             ld_best_score = ld_score
#             ld_best_input = word

#             #output
#             fuzzy_search_results["ld_best_match"] = record[0]
            
# print(fuzzy_search_results)

# print("\n",jw_best_score,fuzzy_search_results["jw_best_match"], jw_best_input)

# print("\n",ld_best_score,fuzzy_search_results["ld_best_match"], ld_best_input)


######################################################################

# #list of symbols for preprocessing
# list_of_symbols = ["™","®","©","&trade;","&reg;","&copy;","&#8482;","&#174;","&#169;","\n"]

# import re, string

# def textpreprocessing(textprocess):
#     """
#     Function to clean and preprocess list of text
#     :param list of words:
#     :return: List of cleaned words
#     """
#     #uppercase all the letters
#     text_to_process = textprocess.upper()

#     #remove the punctuations
#     text_to_process = "".join([char for char in text_to_process if char not in string.punctuation])

#     #remove other symbols
#     for symbol in list_of_symbols:
#         text_to_process = text_to_process.replace(symbol," ")

#     #remove unicode
#     text_to_process = text_to_process.encode("ascii", "ignore")
#     text_to_process = text_to_process.decode()

#     #regex remove not needed words
#     list_of_matches = re.search("(\d+)(MG)|(\d+) (MG)|TABLET",text_to_process)

#     while list_of_matches:
#         text_to_process = text_to_process.replace(list_of_matches.group(),"")
#         list_of_matches = re.search("(\d+)(MG)|(\d+) (MG)|TABLET",text_to_process)

#     return text_to_process

# list_of_words = list(textpreprocessing(" aksdfasdjhakjdhas ajsdajdhasjdas , sdhjashdsja ").split())

# print(list_of_words)


#################################################################################################

# import textdistance as td

# drug_records = [['LORATADINE','10'],['LEVOCETIRIZINE','5'],['PANADOL','650']]


# def fuzzy_search(list_of_words, drug_records):
#     """ 
#     Function to fuzzy search algorithm of jaro winkler and levenshtein distance
#     :param list of words list of records:
#     :return: list of best score text for each algorithm
#     """
#     number = 0

#     jw_best_match = ""
#     ld_best_match = ""

#     for word in list_of_words:
#         print(number)
#         number+=1

#         #scores assignment
#         jw_best_score = 0.0
#         ld_best_score = 0.0

#         #best input for each algorithm
#         jw_best_input = ""
#         ld_best_input = ""

#         for record in drug_records:

#             jw_score = td.jaro_winkler(word,record[0])
#             ld_score = td.levenshtein.normalized_similarity(word, record[0])

#             print(word,record[0], jw_score, ld_score)

#             if jw_score > jw_best_score:

#                 jw_best_score = jw_score
#                 jw_best_input = word

#                 #output
#                 jw_best_match = record[0]

#             if ld_score > ld_best_score:

#                 ld_best_score = ld_score
#                 ld_best_input = word

#                 #output
#                 ld_best_match = record[0]

#         print("\n",jw_best_score,jw_best_match, jw_best_input)

#         print("\n",ld_best_score,ld_best_match, ld_best_input)

#         list_to_return = [jw_best_match,ld_best_match]

#         return list_to_return
    
# print(fuzzy_search(['', 'PANADOL', '', 'MEDICINE', '2', '', 'MEDICINERE', ''],drug_records))


#######################################################################################################
# ! testing dosage processing
# import re, string

# def dosagepreprocessing(textprocess):
#     """
#     Function to clean words to get the dosage
#     :param list of numbers:
#     :return: dosage string or empty string
#     """
#     #uppercase all the letters
#     text_to_process = textprocess.upper()

#     #remove the punctuations
#     text_to_process = "".join([char for char in text_to_process if char not in string.punctuation])

#     #use try or it will error
#     try:
#         #use regex
#         text_to_process = re.findall("(\d+)(MG)", text_to_process)

#         text_to_return = ""

#         for word in text_to_process:
#             text_to_return+= " " + word[0]
   
#     except:
#         text_to_process = ""
            
#     return text_to_return

# print(dosagepreprocessing("33mg 650mg 6 6 0 mg"))


###########################################################################################################

# import textdistance as td

# def fuzzy_search(list_of_words,drug_records):
#     """ 
#     Function to fuzzy search algorithm of jaro winkler and levenshtein distance
#     :param list of words, list of records:
#     :return: list of best score text for each algorithm
#     """

#     jw_best_match = ""
#     ld_best_match = ""

#     #scores assignment
#     jw_best_score = 0.0
#     ld_best_score = 0.0

#     for word in list_of_words:

        

#         for record in drug_records:

#             jw_score = td.jaro_winkler(word,record[0])
#             ld_score = td.levenshtein.normalized_similarity(word, record[0])

#             # print(word,record[0],jw_score,ld_score,"\n")

#             if jw_score > jw_best_score:

#                 jw_best_score = jw_score
#                 #output
#                 jw_best_match = record[0]
                
#                 print(word,record[0],jw_best_score,"\n")

#             if ld_score > ld_best_score:

#                 ld_best_score = ld_score
#                 #output
#                 ld_best_match = record[0]

#                 # print(word,record[0],ld_best_score,"\n")

#         list_to_return = [jw_best_match,ld_best_match]

#     return list_to_return
    
# print(fuzzy_search(['PANADO\L','MEDICINE','MEDICINERE'],(('LORATADINE', 10), ('LEVOCETIRIZINE', 5), ('PANADOL ACTIFAST', 500))))
    
# # # print(td.jaro_winkler("500","500"))