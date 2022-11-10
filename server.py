from flask import Flask, render_template, request, redirect #Flask micro python server
app = Flask(__name__, template_folder='../Face_Attendance') #Server Declaration
# import lcddriver #Library LCD 

# display = lcddriver.Lcd()
# display.lcd_display_string("Welcome ", 1)
# display.lcd_display_string("Facial Attendance ", 2)

@app.route('/')
def index():
    return render_template('index.html')


@app.route('/enroll')#student face enrollment
def enroll():
    user = request.args.get('uID', default='123', type=str)#GET username from web server/from web system
    print(user)#vnc user name
    import cv2
    import os
    #import lcddriver
    import time
    import sys
    import pymysql
    db = pymysql.connect(
        host='localhost',
        user='root',
        password='sudo',
        db='attendance')

    # display = lcddriver.Lcd()

    cam = cv2.VideoCapture(0)
    cam.set(3, 640)  # set video width
    cam.set(4, 480)  # set video height
    # display.lcd_display_string("Face Detection Started", 1)
    face_detector = cv2.CascadeClassifier(
        'haarcascade_frontalface_default.xml')

    # For each person, enter one numeric face id
    # display.lcd_display_string("Your Usr ID: ", 1)
    # face_id = input('\n enter user id end press <return> ==>  ')
    face_id = user
    # display.lcd_display_string(str(face_id), 2)
    time.sleep(2)
    dirName = "dataset/" + str(face_id)
    if not os.path.exists(dirName):
        os.makedirs(dirName)
        print("User ID Created")
        # display.lcd_display_string("User ID Created ", 1)
    else:
        print("ID already exists")
        # display.lcd_display_string("User ID ", 1)
        # display.lcd_display_string("Already exists. ", 2)
        sys.exit()
    print("\n [INFO] Initializing face capture. Look the camera and wait ...")
    # display.lcd_display_string("Face Capturing ", 1)
    # Initialize individual sampling face count:
    count = 0

    while(True):

        ret, img = cam.read()
        # img = cv2.flip(img, -1) flip video image vertically
        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        faces = face_detector.detectMultiScale(gray, 1.3, 5)

        for (x, y, w, h) in faces:
            cv2.rectangle(img, (x, y), (x+w, y+h), (255, 0, 0), 2)
            roi_color = img[y:y+h, x:x+w]
            # display.lcd_display_string("Face Detected : ", 1)
            # display.lcd_display_string(str(count+1) + " out of 30", 2)
            count += 1
            # Save the captured image into the datasets folder
            fileName = dirName + "/" + face_id + str(count) + ".jpg"
            cv2.imwrite(fileName, gray[y:y+h, x:x+w])

            cv2.imshow('image', img)
        cv2.imshow('video', img)
        k = cv2.waitKey(100) & 0xff  # Press 'ESC' for exiting video
        if k == 27:
            break
        elif count >= 30:  # Take 30 face sample and stop video
            cursor = db.cursor()
            try:
                # Execute the SQL command
                cursor.execute(
                    "UPDATE users SET facial =1 WHERE username=%s", user)
                print(cursor.rowcount, "Default record(s) updated")
                # Commit your changes in the database
                print("Sucess")
                db.commit()
            except:
                # Rollback in case there is any error
                print("error")
                db.rollback()
            break

    # Do a bit of cleanup
    time.sleep(2)
    # display.lcd_clear()
    print("\n [INFO] Exiting Program and cleanup stuff")
    # display.lcd_display_string("Capture Success ", 1)
    cam.release()
    cv2.destroyAllWindows()
    trainning()
    return redirect("http://192.168.0.100/Face_Attendance/Student/Menu.php")

@app.route('/attendance')#attendance taking
def attendance():
    classID = request.args.get('cID', default=0, type=int)
    timeS = request.args.get('time', default="00:00:00", type=str)# GET link Attendance.php
    import cv2
    import numpy as np
    import os
    import pymysql
    import pickle
    # import lcddriver
    import time
    from datetime import datetime
    
    date = datetime.now().strftime('%Y-%m-%d')
    timeout = time.time() + 60*5
    # display = lcddriver.Lcd()
    # We load pickle file
    with open('labels', 'rb') as f:
        dicti = pickle.load(f)
        f.close()

    db = pymysql.connect(
        host='localhost',
        user='root',
        password='sudo',
        db='attendance')
    # display.lcd_display_string("Face Recognition Started ", 1)
    recognizer = cv2.face.LBPHFaceRecognizer_create()
    recognizer.read('trainer/trainer.yml')
    cascadePath = "haarcascade_frontalface_default.xml"
    faceCascade = cv2.CascadeClassifier(cascadePath)

    font = cv2.FONT_HERSHEY_SIMPLEX

    # iniciate id counter
    id = 0

    # Initialize and start realtime video capture
    cam = cv2.VideoCapture(0)
    cam.set(3, 640)  # set video widht
    cam.set(4, 480)  # set video height

    # Define min window size to be recognized as a face
    minW = 0.1*cam.get(3)
    minH = 0.1*cam.get(4)
    cursor = db.cursor()

    while True:
        ret, img = cam.read()
        # img = cv2.flip(img, -1)  Flip vertically

        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

        faces = faceCascade.detectMultiScale(
            gray,
            scaleFactor=1.2,
            minNeighbors=5,
            minSize=(int(minW), int(minH)),
        )

        for(x, y, w, h) in faces:
            cv2.rectangle(img, (x, y), (x+w, y+h), (0, 255, 0), 2)
            id_, confidence = recognizer.predict(gray[y:y+h, x:x+w])
            for name, value in dicti.items():
                    if(value == id_):
                        print("Person Detected : ", name)
                        if(confidence >= 70):
                            cursor = db.cursor()
                            sql2 = "SELECT * FROM attendance WHERE usrID = '%s' AND time = '%s' AND date = '%s'" % (name, timeS, date)
                            try:
                                cursor.execute(sql2)
                                if(cursor.rowcount==0):
                                    sql = "INSERT INTO attendance (attnID, time, date, usrID, cID)  values (NULL, '%s', '%s', '%s', '%d')" % (timeS, date, name, classID)
                                    print("Attended :",name)
                                    try:
                                        cursor.execute(sql)
                                        print(cursor.rowcount, "record(s) affected")
                                        db.commit()
                                    except:
                                        db.rollback()
                                    db.commit()
                            except:
                                db.rollback()
                            
                                # id = names[id]
                                # confidence = "  {0}%".format(round(100 - confidence))
                        else:
                            id = "unknown"
                            
                        cv2.putText(img, str(name), (x+5, y-5),
                                    font, 1, (255, 255, 255), 2)
                        cv2.putText(img, str(confidence), (x+5, y+h-5),
                                    font, 1, (255, 255, 0), 1)
        cv2.imshow('camera', img)
        cursor = db.cursor()
        sql3 = "Select * FROM attendance WHERE cID ='%d' AND time = '%s' AND date = '%s'" % (classID, timeS, date)
        try:
            
            cursor.execute(sql3)
            # print(cursor.rowcount, "Total updated")
            # Commit your changes in the database
            # display.lcd_display_string(str(cursor.rowcount)+" Attended ", 2)
            # print("Count Sucess")
            db.commit()
        except:
            # Rollback in case there is any error
            print("Counterror")
            db.rollback()
        k = cv2.waitKey(100) & 0xff
        if k ==27:
            break

    # Do a bit of cleanup
    print("\n [INFO] Exiting Program and cleanup stuff")
    cam.release()
    db.close()
    cv2.destroyAllWindows()
    return redirect("http://192.168.0.100/Face_Attendance/Lecturer/Menu.php")


def trainning():#training pictures to algorithm
    import os
    import numpy as np
    from PIL import Image
    import cv2
    import pickle
    # import lcddriver

    # display = lcddriver.Lcd()
    faceCascade = cv2.CascadeClassifier("haarcascade_frontalface_default.xml")

    # Recognizer for face
    recognizer = cv2.face.LBPHFaceRecognizer_create()

    # Going into images directory
    baseDir = os.path.dirname(os.path.abspath(__file__))
    imageDir = os.path.join(baseDir, "dataset")

    currentId = 1
    labelIds = {}
    yLabels = []
    xTrain = []
    print("\n [INFO] Training faces. It will take a few seconds. Wait ...")
    # display.lcd_display_string("Training Faces...", 1)
    # Looking for images in directory
    for root, dirs, files in os.walk(imageDir):
        # print(root, dirs, files)
        for file in files:
            # print(file)
            if file.endswith("png") or file.endswith("jpg"):
                path = os.path.join(root, file)
                label = os.path.basename(root)
                # print(label)

                if not label in labelIds:
                    labelIds[label] = currentId
                    print(labelIds)
                    currentId += 1

                id_ = labelIds[label]
                pilImage = Image.open(path).convert("L")
                imageArray = np.array(pilImage, "uint8")

                # Again face detection and prepare trainer
                faces = faceCascade.detectMultiScale(
                    imageArray, scaleFactor=1.1, minNeighbors=5)

                for (x, y, w, h) in faces:
                    roi = imageArray[y:y+h, x:x+w]
                    xTrain.append(roi)
                    yLabels.append(id_)

    # Store the dictionary
    with open("labels", "wb") as f:
        pickle.dump(labelIds, f)
        f.close()

    # Train the data
    recognizer.train(xTrain, np.array(yLabels))
    recognizer.save("trainer/trainer.yml")
    print("\n [INFO] {0} faces trained. Exiting Program".format(
        len(np.unique(yLabels))))
    # display.lcd_display_string(str(format(len(np.unique(yLabels)))) + " faces trained", 2)
    # print(labelIds[label])


if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0')
