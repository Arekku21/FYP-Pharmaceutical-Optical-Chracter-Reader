#fix file configuration issue
import os
os.environ["KMP_DUPLICATE_LIB_OK"]="TRUE"

#import webserver libraries
from flask import Flask, render_template, request, jsonify

#import OCR model pytesseract and functions
import pytesseract
from  pytesseract import Output

#import easyocr pillow and bytes
import easyocr
from io import BytesIO
from PIL import Image

import cv2, base64, numpy as np 

import json

#import regular expressions
import re, string

#list of symbols for preprocessing
list_of_symbols = ["™","®","©","&trade;","&reg;","&copy;","&#8482;","&#174;","&#169;","\n"]

def remove_duplicates(list_of_numbers):
    """
    Function to remove duplicate block numbers for bounding box
    :param list of numbers:
    :return: List without duplicates
    """
    return list(dict.fromkeys(list_of_numbers))

def textpreprocessing(textprocess):
    """
    Function to clean and preprocess list of text
    :param list of words:
    :return: List of cleaned words
    """
    #uppercase all the letters
    text_to_process = textprocess.upper()

    #remove the punctuations
    text_to_process = "".join([char for char in text_to_process if char not in string.punctuation])

    #remove other symbols
    for symbol in list_of_symbols:
        text_to_process = text_to_process.replace(symbol," ")

    #remove unicode
    text_to_process = text_to_process.encode("ascii", "ignore")
    text_to_process = text_to_process.decode()

    #regex remove not needed words
    list_of_matches = re.search("(\d+)(MG)|(\d+) (MG)|TABLET",text_to_process)

    while list_of_matches:
        text_to_process = text_to_process.replace(list_of_matches.group(),"")
        list_of_matches = re.search("(\d+)(MG)|(\d+) (MG)|TABLET",text_to_process)

    return text_to_process

def dosagepreprocessing(textprocess):
    """
    Function to clean words to get the dosage
    :param list of numbers:
    :return: dosage or empty string
    """
    #uppercase all the letters
    text_to_process = textprocess.upper()

    #remove the punctuations
    text_to_process = "".join([char for char in text_to_process if char not in string.punctuation])

    #use try or it will error
    try:
        #use regex
        text_to_process = re.search("(\d+)(MG)", text_to_process).group()
    except:
        text_to_process = ""
            
    return text_to_process

app = Flask(__name__)

# @app.route('/')
@app.route('/index')
def home():
    return render_template('index.html')

#send whole dictionary pytesseract
@app.route('/api/pytesseract/output/dictionary', methods=['GET', 'POST'])
def api_pytesseract_dict():

    if request.method == "GET":
        try:

            #process status messages
            print("\nStatus Message: GET Method API request for /api/pytesseract/output/dictionary")

            sent_image = request.args.get('image')

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)

            im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
            img = cv2.imdecode(im_arr, flags=cv2.IMREAD_COLOR)

            #using pytesseract to get prediction for each frame
            ocr_output = pytesseract.image_to_data(img, output_type=Output.DICT)

            # return jsonify(test_json)
            return ocr_output
        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"
    elif request.method == "POST":
        try:

            #process status messages
            print("\nStatus Message: POST Method API request for /api/pytesseract/output/dictionary")

            request_data = request.get_json()

            sent_image = request_data['image']
            
            print(type(sent_image))

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)

            im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
            img = cv2.imdecode(im_arr, flags=cv2.IMREAD_COLOR)

            #using pytesseract to get prediction for each frame
            ocr_output = pytesseract.image_to_data(img, output_type=Output.DICT)

            # return jsonify(test_json)
            return ocr_output
        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"


#send best confidence pytesseract
@app.route('/api/pytesseract/output/best_confidence', methods=['GET','POST'])
def api_pytesseract_best_confidence():

    if request.method == "GET":
        try:

            #process status messages
            print("\nStatus Message: GET Method API request for /api/pytesseract/output/best_confidence")

            sent_image = request.args.get('image')

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)

            im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
            img = cv2.imdecode(im_arr, flags=cv2.IMREAD_COLOR)

            #using pytesseract to get prediction for each frame
            ocr_output = pytesseract.image_to_data(img, output_type=Output.DICT)

            #process the block number for bounding box
            word_list_range = ocr_output["block_num"]
            word_list_range = remove_duplicates(word_list_range)
            word_list_range = len(word_list_range)

            #list to store words
            word_list = []

            #populate list
            for length in range(0,word_list_range):
                word_list.append([])
                for x in range(0,2):
                    word_list[length].append("")
                word_list[length].append(0.0)
            
            #use the block number as index to connect the block number to the word belonging to it 
            for length in range(0,len(ocr_output["text"])):
                if ocr_output["text"][length] != "":
                    word_list[ocr_output["block_num"][length]][0] += " " + ocr_output["text"][length]
                    word_list[ocr_output["block_num"][length]][1] += " " + ocr_output["conf"][length]

            #calculate confidence average
            for x  in range(0,len(word_list)):
                average = 0.0
                if word_list[x][1] != "":
                    confidence = word_list[x][1]
                    confidence_list = confidence.split(" ")
                    confidence_list.pop(0)

                    for y in confidence_list:
                        average+=float(y)
                    average = average/len(confidence_list)
                    word_list[x][2] =  average  

            #get the best confidence words
            output_to_show = ""
            best_confidence = 0.0
            for num in  range(0,word_list_range):
                if best_confidence < word_list[num][2]:
                    best_confidence = word_list[num][2]
                    output_to_show = word_list[num][0]

            # return jsonify(test_json)
            return output_to_show
        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"
    
    elif request.method == "POST":
        try:
            
            #process status messages
            print("\nStatus Message: POST Method API request for /api/pytesseract/output/best_confidence")

            request_data = request.get_json()

            sent_image = request_data['image']

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)

            im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
            img = cv2.imdecode(im_arr, flags=cv2.IMREAD_COLOR)

            #using pytesseract to get prediction for each frame
            ocr_output = pytesseract.image_to_data(img, output_type=Output.DICT)

            #process the block number for bounding box
            word_list_range = ocr_output["block_num"]
            word_list_range = remove_duplicates(word_list_range)
            word_list_range = len(word_list_range)

            #list to store words
            word_list = []

            #populate list
            for length in range(0,word_list_range):
                word_list.append([])
                for x in range(0,2):
                    word_list[length].append("")
                word_list[length].append(0.0)
            
            #use the block number as index to connect the block number to the word belonging to it 
            for length in range(0,len(ocr_output["text"])):
                if ocr_output["text"][length] != "":
                    word_list[ocr_output["block_num"][length]][0] += " " + ocr_output["text"][length]
                    word_list[ocr_output["block_num"][length]][1] += " " + ocr_output["conf"][length]

            #calculate confidence average
            for x  in range(0,len(word_list)):
                average = 0.0
                if word_list[x][1] != "":
                    confidence = word_list[x][1]
                    confidence_list = confidence.split(" ")
                    confidence_list.pop(0)

                    for y in confidence_list:
                        average+=float(y)
                    average = average/len(confidence_list)
                    word_list[x][2] =  average  

            #get the best confidence words
            output_to_show = ""
            best_confidence = 0.0
            for num in  range(0,word_list_range):
                if best_confidence < word_list[num][2]:
                    best_confidence = word_list[num][2]
                    output_to_show = word_list[num][0]

            # return jsonify(test_json)
            return output_to_show
        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"       

#send whole dictionary easrocr 
#TO DO: Fix the numpy int32 issue cannot return
@app.route('/api/easyocr/output/dictionary', methods=['GET','POST'])
def api_easyocr_list():

    if request.method == "GET":
        try:
            sent_image = request.args.get('image')

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
            # im_file = BytesIO(im_bytes)  # convert image to file-like object
            # img = Image.open(im_file)   # img is now PIL Image object

            reader = easyocr.Reader(['en'], gpu=True)
            result = reader.readtext(im_bytes)  #!!!for some weird reason the Easy OCR now is only taking bytes as 
                                                #input as to PIL object - (replace im_bytes to img if needed and uncomment)

            easy_ocr_my_list = list(result)
           
            result_dict = {}

            for item in easy_ocr_my_list:
                for in_item in item[0]:
                                
                        a = int(in_item[0])
                        b = int(in_item[1])

                        in_item[0] = a
                        in_item[1] = b

            for dict_key in range(len(easy_ocr_my_list)):
                for item in easy_ocr_my_list:
                    result_dict.update({dict_key:item})
            
            return result_dict
            
        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"
    elif request.method == "POST":
        try:
            request_data = request.get_json()

            sent_image = request_data['image']

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
            #im_file = BytesIO(im_bytes)  # convert image to file-like object
            #img = Image.open(im_file)   # img is now PIL Image object

            reader = easyocr.Reader(['en'], gpu=True)
            result = reader.readtext(im_bytes)

            easy_ocr_my_list = list(result)
           
            result_dict = {}

            for item in easy_ocr_my_list:
                for in_item in item[0]:
                                
                        a = int(in_item[0])
                        b = int(in_item[1])

                        in_item[0] = a
                        in_item[1] = b

            for dict_key in range(len(easy_ocr_my_list)):
                for item in easy_ocr_my_list:
                    result_dict.update({dict_key:item})
            
            return result_dict

        except:
             return "API parameter is incorrect. Check Base 64 encoding or parameter missing"


#send best confidence easy
@app.route('/api/easyocr/output/best_confidence', methods=['GET','POST'])
def api_easyocr_best_confidence():

    if request.method == "GET":
        try:
            
            #process status messages
            print("\nStatus Message: GET Method API request for /api/easyocr/output/best_confidence")

            sent_image = request.args.get('image')

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
            #im_file = BytesIO(im_bytes)  # convert image to file-like object
            #img = Image.open(im_file)   # img is now PIL Image object

            reader = easyocr.Reader(['en'], gpu=True)
            result = reader.readtext(im_bytes, detail=0)

            return jsonify(result)
            #return result
        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"
    elif request.method == "POST":
        try:
            #process status messages
            print("\nStatus Message: POST Method API request for /api/easyocr/output/best_confidence")

            request_data = request.get_json()

            sent_image = request_data['image']

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
            #im_file = BytesIO(im_bytes)  # convert image to file-like object
            #img = Image.open(im_file)   # img is now PIL Image object

            reader = easyocr.Reader(['en'], gpu=True)
            result = reader.readtext(im_bytes,detail=0)

            print(result)

            return jsonify(result)

        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"


#send best confidence easy ocr custom model
@app.route('/api/easyocr_custom/output/best_confidence', methods=['GET','POST'])
def api_easyocr_custom_best_confidence():

    if request.method == "GET":
        try:
            
            #process status messages
            print("\nStatus Message: GET Method API request for /api/easyocr_custom/output/best_confidence")

            sent_image = request.args.get('image')

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
            im_file = BytesIO(im_bytes)  # convert image to file-like object
            img = Image.open(im_file)   # img is now PIL Image object

            reader = easyocr.Reader(['en'], gpu=True)
            result = reader.readtext(img, detail=0)

            return jsonify(result)
            #return result
        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"
    elif request.method == "POST":
        try:
            
            #process status messages
            print("\nStatus Message: POST Method API request for /api/easyocr_custom/output/best_confidence")

            request_data = request.get_json()

            sent_image = request_data['image']

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
            im_file = BytesIO(im_bytes)  # convert image to file-like object
            img = Image.open(im_file)   # img is now PIL Image object

            reader = easyocr.Reader(['en'],recog_network="custom_model_fyp_1", gpu=True)
            result = reader.readtext(img,detail=0)

            print(result)

            return jsonify(result)

        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"

if __name__ == '__main__':
    app.run(debug=True)

