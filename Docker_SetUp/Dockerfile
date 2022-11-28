#base image
FROM ubuntu:latest

# #required installations

#install and update apt-get and python3
RUN apt-get update && apt-get install -y \
    python3-pip

#install python
RUN apt-get install -y python3
#CMD pip3 -v
#CMD python3 -V

#######################
# Packages:            #
# tensorflow 2.7.0    #
# tensorboard 2.10.1  #
# keras 2.7.0         #
# pytesseract 0.3.10  #
# tesseract 0.1.3     #
# numpy 1.23.4        #
# matplotlib 3.6.2    #
# OpenCV 4.5.5        #
#######################

#install tensorflow and tensor board
RUN pip3 install tensorflow

#install tensorboard (optional)
#pip install tensorboard==2.10.1

#install keras
RUN pip3 install Keras==2.7.0

#install pytesseract 
RUN apt install tesseract-ocr -y

#install numpy
RUN pip3 install numpy==1.23.4

#install matplkotlib
# RUN python -m pip install -U matplotlib==3.6.2
RUN pip3 install -U matplotlib==3.6.2

ENV DEBIAN_FRONTEND=noninteractive

#OpenCV 
RUN apt-get install python3-opencv -y

#Flask
RUN pip3 install Flask

#copy source file
COPY testing/test1.py .
COPY testing/img.jpeg .

#CMD pip3 freeze; apt list --installed
CMD python3 test1.py


# #EXPOSE (port number)

# #CMD [,,,] add variables

# CMD tesseract -v


