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

with open("api_test.png", "rb") as f:
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

# ! Testing for Returning base64 image with bounding boxes and text

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
# im_arr = np.frombuffer(im_bytes, dtype=np.uint8)  # im_arr is one-dim Numpy array
# img = cv.imdecode(im_arr, flags=cv.IMREAD_COLOR)


# #img = cv.imread(img) 

# reader = easyocr.Reader(['en'], gpu=True)
# result = reader.readtext(im_bytes,detail=1)

# print(result)

# image2 = img.copy()

# for bounding_boxes in result:
#     points = bounding_boxes[0]
#     rect = cv.boundingRect(np.array(points))
#     x, y, w, h = rect
#     cv.rectangle(image2, (x, y), (x + w, y + h), (0, 0, 255), 1)
#     cv.putText(image2, bounding_boxes[1], (x, y-5), cv.FONT_HERSHEY_SIMPLEX, 0.5, (0,0,255), 1)


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

