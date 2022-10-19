import cv2
import os
import lcddriver
import time
import sys

display = lcddriver.Lcd()

cam = cv2.VideoCapture(0)
cam.set(3, 640) # set video width
cam.set(4, 480) # set video height
display.lcd_display_string("Face Detection Started", 1)
face_detector = cv2.CascadeClassifier('Face/haarcascade_frontalface_default.xml')

# For each person, enter one numeric face id
display.lcd_display_string("Enter Usr ID: ", 1)
#face_id = input('\n enter user id end press <return> ==>  ')
face_id = user
display.lcd_display_string(str(face_id), 2)
time.sleep(2) 
dirName = "Face/dataset/User" + str(face_id)
if not os.path.exists(dirName):
    os.mkdir(dirName)
    print("User ID Created")
    display.lcd_display_string("User ID Created ", 1)
else:
    print("ID already exists")
    display.lcd_display_string("User ID ", 1)
    display.lcd_display_string("Already exists. ", 2)
    sys.exit()
print("\n [INFO] Initializing face capture. Look the camera and wait ...")
display.lcd_display_string("Face Capturing ", 1)
# Initialize individual sampling face count:
count = 0

while(True):

    ret, img = cam.read()
    #img = cv2.flip(img, -1) flip video image vertically
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    faces = face_detector.detectMultiScale(gray, 1.3, 5)

    for (x,y,w,h) in faces:

        cv2.rectangle(img, (x,y), (x+w,y+h), (255,0,0), 2)
        roi_color = img[y:y+h, x:x+w]
        display.lcd_display_string("Face Detected : ", 1)
        display.lcd_display_string(str(count+1) + " out of 30", 2)
        count += 1
        
        # Save the captured image into the datasets folder
        cv2.imwrite(dirName + '/' + str(count) + ".jpg", gray[y:y+h,x:x+w])

        cv2.imshow('image', img)
    cv2.imshow('video',img)
    k = cv2.waitKey(100) & 0xff # Press 'ESC' for exiting video
    if k == 27:
        break
    elif count >= 30: # Take 30 face sample and stop video
         break

# Do a bit of cleanup
time.sleep(2)
display.lcd_clear()   
print("\n [INFO] Exiting Program and cleanup stuff")
display.lcd_display_string("Capture Success ", 1)
cam.release()
cv2.destroyAllWindows()


