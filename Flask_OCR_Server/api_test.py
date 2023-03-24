# import requests

# import base64

# # import cv2, numpy as np, pytesseract
# # from  pytesseract import Output

# with open("test_image.png", "rb") as f:
#     im_b64 = base64.b64encode(f.read())

# # print(im_b64)

# # if im_b64 == php:
# #     print(1)

# #url = 'http://127.0.0.1:5000//api/pytesseract/output/best_confidence'
# url = 'http://127.0.0.1:5000/api/pytesseract/output/dictionary'


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

import requests

import base64

# import cv2, numpy as np, pytesseract
# from  pytesseract import Output

with open("test_image.png", "rb") as f:
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

#test 

# import easyocr
# from PIL import Image

# im_file = "test_image.png"

# img = Image.open(im_file)   # img is now PIL Image object

# reader = easyocr.Reader(['en'], gpu=True)
# result = reader.readtext(im_file,detail=1)

# print(result)

# import json

# easy_ocr_my_list = list(result)

# for item in easy_ocr_my_list:
#     for in_item in item[0]:
                       
#             a = int(in_item[0])
#             b = int(in_item[1])

#             in_item[0] = a
#             in_item[1] = b

# jsonStr = json.dumps(easy_ocr_my_list)

# print(len(jsonStr))
# print(jsonStr)
# print(jsonStr[0])


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





