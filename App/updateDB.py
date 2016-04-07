#!/usr/bin/env python

import os
import threading
import requests
from bs4 import BeautifulSoup
import sys



f = open("/home/pi/Desktop/network.log", "a")
f.write("Entering update.py script... ")
f.close()
    
def updateData(csv_date):
    try:
        #with eventlet.Timeout(40):
        csv_date = csv_date.strip()
        # Create a session
        s = requests.Session()

        # LOGIN
        
        r = s.get('http://your-website.com')#, timeout=5)
        html = BeautifulSoup(r.text,"lxml")
        csrf = html.find('input', {'name': '_csrf_token'}).get('value')
        payload = {
            '_csrf_token': csrf,
            '_password': 'pwd',
            '_submit': 'Anmelden',
            '_username': 'usrname'
        }
        r = s.post('http://your-website.com/login_check', data=payload)#, timeout=5)
        # UPDATE
        date = {'date': csv_date}
        r = s.post('hhttp://your-website.com/raspi/update', data=date)#, timeout=5)
        r = s.post('', data=payload)#, timeout=5)
        # UPDATE
        date = {'date': csv_date}
        r = s.post('', data=date)#, timeout=5)
        r.raise_for_status()
        if(r.text.strip().count(';') == 0 or r.text.strip().count(';')%3 != 0):
          return (False,"Error")
        return (True,r.text.strip())
    except:
        print sys.exc_info()[0]
        return (False,"Error")




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

UpdateOK = False
UpdateOk, adminString = updateData(date)

print "\n database asked \n"

if UpdateOk==True:
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
else:
    f = open("/home/pi/Desktop/network.log", "a")
    f.write("NOT OK !\r\n")
    f.close()
