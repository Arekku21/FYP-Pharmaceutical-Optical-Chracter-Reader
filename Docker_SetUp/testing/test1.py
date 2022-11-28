# import cv2
# import pytesseract

# def ocr_core(img):
#     text = pytesseract.image_to_string(img)
#     return text

# img = cv2.imread('img.jpeg')

# def get_grayscale(image):
#     return cv2.cvtColor(image, cv2.COLOR_RGB2GRAY)

# def remove_noise(image):
#     return cv2.medianBlur(image, 5)

# def thresholding(image):
#     return cv2.threshold(image, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)[1]

# img = get_grayscale(img)
# img = thresholding(img)
# img = remove_noise(img)

# print(ocr_core(img))

# # import the cv2 library
# import cv2
 
# # The function cv2.imread() is used to read an image.
# #img_grayscale = cv2.imread('D:\\Documents\\GitHub\\FYP-Pharmaceutical-Optical-Chracter-Reader\\Docker_SetUp\\testing\\img.jpeg',0)
# img_grayscale = cv2.imread('img.jpeg', cv2.IMREAD_UNCHANGED)
 
# # get dimensions of image
# dimensions = img_grayscale.shape
 
# # height, width, number of channels in image
# height = img_grayscale.shape[0]
# width = img_grayscale.shape[1]
# channels = img_grayscale.shape[2]
 
# print('Image Dimension    : ',dimensions)
# print('Image Height       : ',height)
# print('Image Width        : ',width)
# print('Number of Channels : ',channels)

from flask import Flask
import os
app = Flask(__name__)

@app.route('/')
def hello_geek():
    return '<h1>Hello from Flask & Docker</h2>'


if __name__ == "__main__":
    port = int(os.environ.get('PORT', 5000))
    app.run(debug=True, host='0.0.0.0', port=port)
