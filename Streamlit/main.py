import streamlit as st
import zipfile
import shutil
import os
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Conv2D, MaxPooling2D, Flatten, Dense
from sklearn.model_selection import train_test_split
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.callbacks import ModelCheckpoint
from difPy import dif

def duplicate_detection(data_dir):
    ls = []
    for i in os.listdir(data_dir):
        ls.append("images/" + i)
    search = dif(ls, fast_search=True, logs=True)
    # print(search.stats)
    locations = set()
    for k, v in search.result.items():
        for _, match in v['matches'].items():
            if match['mse'] == 0.0:
                locations.add(v['location'])
                locations.add(match['location'])
    #remove the duplicate file
    for i in locations:
        os.remove(i)
    invalid_files = search.stats['invalid_files']['logs']
    invalid_file_names = list(invalid_files.keys())
    #remove invalid image files
    for i in invalid_file_names:
        os.remove(i)

def split_dataset(data_path):
    # Get a list of all the image files in your data folders
    file_names = []
    for folder_name in os.listdir(data_path):
        folder_path = os.path.join(data_path, folder_name)
        if os.path.isdir(folder_path):
            for file_name in os.listdir(folder_path):
                if file_name.endswith('.jpg'):
                    file_path = os.path.join(folder_path, file_name)
                    file_names.append((file_path, folder_name))

    # Split the file names into training and testing sets
    train_file_names, test_file_names = train_test_split(file_names, test_size=0.2, random_state=42)

    # Move the training and testing files to separate folders
    train_path = "train"
    test_path = "test"
    for file_path, folder_name in train_file_names:
        destination_path = os.path.join(train_path, folder_name)
        os.makedirs(destination_path, exist_ok=True)
        os.rename(file_path, os.path.join(destination_path, os.path.basename(file_path)))
    for file_path, folder_name in test_file_names:
        destination_path = os.path.join(test_path, folder_name)
        os.makedirs(destination_path, exist_ok=True)
        os.rename(file_path, os.path.join(destination_path, os.path.basename(file_path)))
    shutil.rmtree("images")


def Model(classes):
    train_dir = 'train'
    test_dir = 'test'
    batch_size = 32
    epochs = 10
    train_datagen = ImageDataGenerator(rescale=1./255,
                                   shear_range=0.2,
                                   zoom_range=0.2,
                                   horizontal_flip=True,
                                   validation_split=0.2) # 20% of the data will be used for validation

    train_generator = train_datagen.flow_from_directory(train_dir,
                                                        target_size=(224, 224),
                                                        batch_size=batch_size,
                                                        class_mode='categorical',
                                                        subset='training')

    # Data generator for validation set
    validation_generator = train_datagen.flow_from_directory(train_dir,
                                                            target_size=(224, 224),
                                                            batch_size=batch_size,
                                                            class_mode='categorical',
                                                            subset='validation')

    # Data generator for test set
    test_datagen = ImageDataGenerator(rescale=1./255)

    test_generator = test_datagen.flow_from_directory(test_dir,
                                                    target_size=(224, 224),
                                                    batch_size=batch_size,
                                                    class_mode='categorical')
    model = Sequential([
        Conv2D(32, (3, 3), activation='relu', input_shape=(224, 224, 3)),
        MaxPooling2D((2, 2)),
        Conv2D(64, (3, 3), activation='relu'),
        MaxPooling2D((2, 2)),
        Conv2D(64, (3, 3), activation='relu'),
        Flatten(),
        Dense(64, activation='relu'),
        Dense(classes, activation='softmax')
    ])

    model.compile(optimizer='adam', loss='categorical_crossentropy', metrics=['accuracy'])

    checkpoint = ModelCheckpoint("modal.h5", monitor='val_loss', save_best_only=True, save_freq='epoch', verbose=1)

    model.fit(train_generator, epochs=epochs, validation_data= validation_generator, callbacks=[checkpoint])

    scores = model.evaluate_generator(test_generator, steps=len(test_generator))
    # Print the accuracy and loss
    print('Test accuracy:', scores[1])
    print('Test loss:', scores[0])

    model.save



st.title("Retraining Pipeline")

uploaded_file = st.file_uploader("Choose a file", type="zip")

if uploaded_file:

    # Extract the contents of the zip file
    with zipfile.ZipFile(uploaded_file, 'r') as zip_ref:
        zip_ref.extractall('./images')

    
    duplicate_detection("images")

    split_dataset("images")

    #count the total number of folder
    total_folder = len(os.listdir("train"))

    Model(total_folder)

    
    # Access the necessary files for model training
    # train_data = pd.read_csv('./data/train.csv')
    # rest of the code for model training...


