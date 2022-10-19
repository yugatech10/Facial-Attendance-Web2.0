import cv2
import numpy as np
import os 
import pymysql
import lcddriver
from datetime import datetime

display = lcddriver.Lcd()
timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

db = pymysql.connect("localhost","root","sudo","attendance" )
display.lcd_display_string("Face Recognition Started ", 1)
recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read('trainer/trainer.yml')
cascadePath = "haarcascade_frontalface_default.xml"
faceCascade = cv2.CascadeClassifier(cascadePath);

font = cv2.FONT_HERSHEY_SIMPLEX

#iniciate id counter
id = 0 

# Initialize and start realtime video capture
cam = cv2.VideoCapture(0)
cam.set(3, 640) # set video widht
cam.set(4, 480) # set video height

# Define min window size to be recognized as a face
minW = 0.1*cam.get(3)
minH = 0.1*cam.get(4)
cursor = db.cursor()
try:
   # Execute the SQL command
   cursor.execute("UPDATE student SET Attn =0")
   print(cursor.rowcount, "Default record(s) updated")
   # Commit your changes in the database
   print("Sucess")
   db.commit()
except:
   # Rollback in case there is any error
   print("error")
   db.rollback()

while True:
    ret, img =cam.read()
    #img = cv2.flip(img, -1)  Flip vertically

    gray = cv2.cvtColor(img,cv2.COLOR_BGR2GRAY)

    faces = faceCascade.detectMultiScale( 
        gray,
        scaleFactor = 1.2,
        minNeighbors = 5,
        minSize = (int(minW), int(minH)),
       )

    for(x,y,w,h) in faces:

        cv2.rectangle(img, (x,y), (x+w,y+h), (0,255,0), 2)

        id, confidence = recognizer.predict(gray[y:y+h,x:x+w])
        # Check if confidence is less them 100 ==> "0" is perfect match 
        if (confidence < 100):
            cursor = db.cursor()
            sql = "UPDATE student SET Attn = 1,datetime = '%s' WHERE usrID ='%d'" % (timestamp,id)
            try:
               # Execute the SQL command
               cursor.execute(sql)
               print(cursor.rowcount, "record(s) affected")
               # Commit your changes in the database
               db.commit()
            except:
               # Rollback in case there is any error
               db.rollback()
            #id = names[id]
            confidence = "  {0}%".format(round(100 - confidence))
        
        else:
            id = "unknown"
            confidence = "  {0}%".format(round(100 - confidence))
        cv2.putText(img, str(id), (x+5,y-5), font, 1, (255,255,255), 2)
        cv2.putText(img, str(confidence), (x+5,y+h-5), font, 1, (255,255,0), 1)  
    
    cv2.imshow('camera',img) 
    cursor = db.cursor()
    try:
       # Execute the SQL command
       cursor.execute("Select * FROM student WHERE Attn =1")
       print(cursor.rowcount, "Default record(s) updated")
       # Commit your changes in the database
       display.lcd_display_string(str(cursor.rowcount)+" Attended ", 2)
       print("Count Sucess")
       db.commit()
    except:
       # Rollback in case there is any error
       print("Counterror")
       db.rollback()
    k = cv2.waitKey(10) & 0xff # Press 'ESC' for exiting video
    if k == 27:
        break

# Do a bit of cleanup
print("\n [INFO] Exiting Program and cleanup stuff")
cam.release()
db.close()
cv2.destroyAllWindows()
