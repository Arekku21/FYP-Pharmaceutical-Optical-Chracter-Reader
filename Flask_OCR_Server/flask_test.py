#fix file configuration issue
import os
os.environ["KMP_DUPLICATE_LIB_OK"]="TRUE"

#import webserver libraries
from flask import Flask, render_template, request, jsonify, Response

# ! Kyron's mac specific item
#from flask_cors import CORS

# ! paddle OCR
#from PaddleOCR import PaddleOCR, draw_ocr 
import numpy as np

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

        text_to_process = re.search("(\d+)", text_to_process).group()
    except:
        text_to_process = ""
            
    return text_to_process

app = Flask(__name__)

# ! Kyron specific mac problem
#CORS(app)

# @app.route('/')
@app.route('/index')
def home():
    return render_template('index.html')

#send whole dictionary pytesseract
@app.route('/api/pytesseract/output/dictionary', methods=['GET', 'POST'])
def api_pytesseract_dict():

    if request.method == "POST":
        try:

            #process status messages
            print("\nStatus Message: POST Method API request for /api/pytesseract/output/dictionary")

            request_data = request.get_json()

            sent_image = request_data['image']

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
@app.route('/api/pytesseract/output/best_confidence', methods=['POST'])
def api_pytesseract_best_confidence():

    if request.method == "POST":
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

            dict_to_return = {}

            #return index 0 to be brand
            dict_to_return["brand"] = output_to_show

            #return index 1 to be doasage
            dict_to_return["dosage"] = dosagepreprocessing(output_to_show)

            # return jsonify(test_json)
            return dict_to_return
        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"       

#send whole dictionary easrocr 
#TO DO: Fix the numpy int32 issue cannot return
@app.route('/api/easyocr/output/dictionary', methods=['GET','POST'])
def api_easyocr_list():

    if request.method == "POST":
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
    if request.method == "POST":
        try:
            #process status messages
            print("\nStatus Message: POST Method API request for /api/easyocr/output/best_confidence")

            # print(request.cclearontent_type)
            # request_data = request.get_data()

            # print(request.get_json())

            # sent_image = request_data['image']
            #sent_image = request.form['image_data']

            #!alec specific requests
            request_data = request.get_json()
            sent_image = request_data['image']

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
            im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
            img = cv2.imdecode(im_arr, flags=cv2.IMREAD_COLOR)

            reader = easyocr.Reader(['en'], gpu=True)
            result = reader.readtext(im_bytes,detail=1)

            print("Results Message: OCR raw reading result\n",result)

            #calculate average confidence
            total_confidence = 0.0
            number_of_lines = len(result)

            for confidence in result:
                total_confidence += confidence[2]

            total_confidence = total_confidence/number_of_lines

            output_to_show = ""

            #compare word confidence to average
            for word_confidence in result:
                #if total_confidence <= word_confidence[2]:
                output_to_show += " " + word_confidence[1]

            print("Results Message: OCR reading result after pre-processing\n",output_to_show)

            image2 = img.copy()

            for bounding_boxes in result:
                points = bounding_boxes[0]
                rect = cv2.boundingRect(np.array(points))
                x, y, w, h = rect
                cv2.rectangle(image2, (x, y), (x + w, y + h), (0, 0, 255), 1)
                cv2.putText(image2, bounding_boxes[1], (x, y-5), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0,0,255), 1)

            retval, buffer = cv2.imencode('.jpg', image2)
            jpg_as_text = base64.b64encode(buffer)

            print("Results Message: OCR  result after bounding box processing\n",jpg_as_text)

            dict_to_return = {}

            #return index 0 to be brand
            dict_to_return["brand"] = textpreprocessing(output_to_show)

            #return index 1 to be doasage
            dict_to_return["dosage"] = dosagepreprocessing(output_to_show)

            #return index 1 to be doasage
            dict_to_return["base64"] = jpg_as_text.decode('utf-8')

            print("Results Message: API request final dictionary result:\n",dict_to_return)

            return jsonify(dict_to_return)

        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"

#send best confidence easy ocr custom model
@app.route('/api/easyocr_custom/output/best_confidence', methods=['GET','POST'])
def api_easyocr_custom_best_confidence():
    if request.method == "POST":
        try:
            #process status messages
            print("\nStatus Message: POST Method API request for /api/easyocr/output/best_confidence")
            
            # Get the data sent by the AJAX request
            sent_image = request.form['image_data']
            
            # !alec specific
            # request_data = request.get_json()
            # sent_image = request_data['image']

            str_decoded_bytes = bytes(sent_image, 'utf-8')

            im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
            im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
            img = cv2.imdecode(im_arr, flags=cv2.IMREAD_COLOR)

            reader = easyocr.Reader(['en'], gpu=True)
            result = reader.readtext(im_bytes,detail=1)

            print("Results Message: OCR raw reading result\n",result)

            #calculate average confidence
            total_confidence = 0.0
            number_of_lines = len(result)

            for confidence in result:
                total_confidence += confidence[2]

            total_confidence = total_confidence/number_of_lines

            output_to_show = ""

            #compare word confidence to average
            for word_confidence in result:
                #if total_confidence <= word_confidence[2]:
                output_to_show += " " + word_confidence[1]

            print("Results Message: OCR reading result after pre-processing\n",output_to_show)

            image2 = img.copy()

            for bounding_boxes in result:
                points = bounding_boxes[0]
                rect = cv2.boundingRect(np.array(points))
                x, y, w, h = rect
                cv2.rectangle(image2, (x, y), (x + w, y + h), (0, 0, 255), 1)
                cv2.putText(image2, bounding_boxes[1], (x, y-5), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0,0,255), 1)

            retval, buffer = cv2.imencode('.jpg', image2)
            jpg_as_text = base64.b64encode(buffer)

            print("Results Message: OCR  result after bounding box processing\n",jpg_as_text)

            dict_to_return = {}

            #return index 0 to be brand
            dict_to_return["brand"] = textpreprocessing(output_to_show)

            #return index 1 to be doasage
            dict_to_return["dosage"] = dosagepreprocessing(output_to_show)

            #return index 1 to be doasage
            dict_to_return["base64"] = jpg_as_text.decode('utf-8')

            print("Results Message: API request final dictionary result:\n",dict_to_return)

            return jsonify(dict_to_return)

        except:
            return "API parameter is incorrect. Check Base 64 encoding or parameter missing"
        
# ! Kyron specific paddle ocr
        
# #send best confidence easy
# @app.route('/api/paddleocr/output/best_confidence', methods=['GET','POST'])
# def api_paddleocr():
#     if request.method == "POST":
#         try:
#             #process status messages
#             print("\nStatus Message: POST Method API request for /api/paddleocr/output/best_confidence")
            
#             # Get the data sent by the AJAX request
#             sent_image = request.form['image_data']
            

#             str_decoded_bytes = bytes(sent_image, 'utf-8')

#             im_bytes = base64.b64decode(str_decoded_bytes)   # im_bytes is a binary image
#             im_file = BytesIO(im_bytes)  # convert image to file-like object
#             img = Image.open(im_file)   # img is now PIL Image object

#             #paddleocr need the input as file_path, numpy array
#             arr = np.array(img) # Convert the image to a NumPy array

#             reader = PaddleOCR(lang="en")
#             result = reader.ocr(arr)


#             #Extracting prescription medication labels using PaddleOCR
#             boxes = [res[0] for res in result] 
#             texts = [res[1][0] for res in result]
#             scores = [res[1][1] for res in result]
            
            
#             font_path = os.path.join('PaddleOCR', 'doc', 'fonts', 'latin.ttf')

#             img = cv2.cvtColor(arr, cv2.COLOR_BGR2RGB)
#             np.set_printoptions(threshold=np.inf)
#             annotated = draw_ocr(img, boxes, texts, scores, font_path=font_path)
#             retval, buffer = cv2.imencode('.jpg', annotated)
#             jpg_as_text = base64.b64encode(buffer)
#             base64_str = jpg_as_text.decode('utf-8')



#             total_confidence = 0.0
#             number_of_lines = len(result)


#             for confidence in result:
#                 total_confidence += confidence[1][1]
            
#             if total_confidence != 0.0 or number_of_lines != 0:
#                 total_confidence = total_confidence/number_of_lines

#                 output_to_show = ""

#                 #compare word confidence to average
#                 for word_confidence in result:
#                     print(word_confidence)
#                     # if total_confidence <= word_confidence[1]:
#                     output_to_show += " " + word_confidence[1][0]

#                 dict_to_return = {}

#                 # #return index 0 to be brand
#                 dict_to_return["brand"] = textpreprocessing(output_to_show)

#                 # #return index 1 to be doasage
#                 dict_to_return["dosage"] = dosagepreprocessing(output_to_show)

#                 dict_to_return["base64"] = base64_str


#                 # return jsonify(test_json)
#                 # print(dict_to_return)
#                 return dict_to_return
#             else:
#                 return "No text detected"
#         except:
#             return "API parameter is incorrect. Check Base 64 encoding or parameter missing"

if __name__ == '__main__':
    app.run(debug=True)

