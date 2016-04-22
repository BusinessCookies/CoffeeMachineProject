#!/usr/bin/env python

import os
import requests
from bs4 import BeautifulSoup
# sudo apt-get install python-bs4 && sudo apt-get install python-lxml
import sys
#import eventlet
# sudo apt-get install python-eventlet

#eventlet.monkey_patch()


f = open("/home/pi/Desktop/network.log", "a")
f.write("Entering update.py script... ")
f.close()
    
def updateData(csv_date, csv_grade, csv_grade2):
    try:
        #with eventlet.Timeout(40):
        csv_date = csv_date.strip()
        # Create a session
        s = requests.Session()

        # LOGIN
        url = 'http://www.yoururl.com'
        r = s.get(url+'/login')
        html = BeautifulSoup(r.text,"lxml")
        csrf = html.find('input', {'name': '_csrf_token'}).get('value')
        payload = {
            '_csrf_token': csrf,
            '_password': 'password',
            '_submit': 'Anmelden',
            '_username': 'username'
        }
        r = s.post(url+'/login_check', data=payload)
        # UPDATE
        date = {'date': csv_date}
        Admin = s.post(url+'/raspi/update', data=date)
        Admin.raise_for_status()
        AdminResp = Admin.text.strip()
        
        grade = {'grade': csv_grade}
        Admin2 = s.post(url+'/raspi/grade', data=grade)
        Admin2.raise_for_status()
        AdminResp2 = Admin2.text.strip()

        grade2 = {'grade2': csv_grade2}
        Admin3 = s.post(url+'/raspi/grade2', data=grade2)
        Admin3.raise_for_status()
        AdminResp3 = Admin3.text.strip()

        ExpPrice = s.get(url+'/raspi/getExpPrice')
        ExpPrice.raise_for_status()
        ExpPriceResp = ExpPrice.text.strip()
        
        NormPrice = s.get(url+'/raspi/getNormPrice')
        NormPrice.raise_for_status()
        NormPriceResp = NormPrice.text.strip()
        
        UpdatedLabel = s.get(url+'/raspi/getUpdatedLabel')
        UpdatedLabel.raise_for_status()
        UpdatedLabelResp = UpdatedLabel.text.strip()
        
        MinMonney = s.get(url+'/raspi/getMinMonney')
        MinMonney.raise_for_status()
        MinMonneyResp = MinMonney.text.strip()
        
        if(AdminResp.count(';') == 0 or AdminResp.count(';')%3 != 0):
          return (False,"Error", "", "", "")
        return (True,AdminResp,AdminResp2,AdminResp3, ExpPriceResp, NormPriceResp, UpdatedLabelResp, MinMonneyResp)
    except:
        print sys.exc_info()[0]
        return (False,"Error", "", "", "")




path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/"
path = path + "dateTemp.csv"
date = ""

try:
    f = open(path)
    date=f.read()
    f.close()
except Exception, e:
    print e
    pass


path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/"
path = path + "grade.csv"
grade = ""
try:
    f = open(path)
    grade=f.read()
    f.close()
except Exception, e:
    print e
    pass

path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/"
path = path + "grade2.csv"
grade2 = ""
try:
    f = open(path)
    grade2=f.read()
    f.close()
except Exception, e:
    print e
    pass

UpdateOK = False
UpdateOk, adminString,gradeString, grade2String, ExpCoffeeResp, NormCoffeeResp, UpdatedLabelResp, MinMonneyResp = updateData(date, grade, grade2)

print "\n database asked \n"

if UpdateOk==True:
    os.remove(path)
    f = open(path, "wb")
    f.write('')
    f.close()
    
    path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/dateTemp.csv"
    os.remove(path)
    f = open(path, "wb")
    f.write('')
    f.close()
    
    path="/kivy/CoffeeMProject/PinLoginVersion/Data/DB/grade.csv"
    os.remove(path)
    f = open(path, "wb")
    f.write('')
    f.close()
    
    path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/admin.csv"
    
    os.remove(path)
    f = open(path, "w")
    f.write(adminString.strip())
    f.close()
    f = open("/home/pi/Desktop/network.log", "a")
    f.write("OK !\r\n")
    f.close()

    path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/ExpCoffee.txt"
    os.remove(path)
    f = open(path, "wb")
    f.write(ExpCoffeeResp.strip())
    f.close()
    
    path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/NormCoffee.txt"
    os.remove(path)
    f = open(path, "wb")
    f.write(NormCoffeeResp.strip())
    f.close()
    
    path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/updated_label.txt"
    os.remove(path)
    f = open(path, "wb")
    f.write(UpdatedLabelResp.strip())
    f.close()
    
    path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/MinMonney.txt"
    os.remove(path)
    f = open(path, "wb")
    f.write(NormCoffeeResp.strip())
    f.close()
    
else:
    f = open("/home/pi/Desktop/network.log", "a")
    f.write("NOT OK !\r\n")
    f.close()
