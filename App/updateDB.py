#!/usr/bin/env python

import os
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
        r.raise_for_status()
        html = BeautifulSoup(r.text,"lxml")
        csrf = html.find('input', {'name': '_csrf_token'}).get('value')
        payload = {
            '_csrf_token': csrf,
            '_password': 'pwd',
            '_submit': 'Anmelden',
            '_username': 'usrname'
        }
        r = s.post('http://your-website.com/login_check', data=payload)
        # UPDATE
        date = {'date': csv_date}
        Admin = s.post('http://your-website.com/raspi/update', data=date)
        Admin.raise_for_status()
        AdminResp = Admin.text.strip()
        
        ExpPrice = s.get('http://your-website.com/raspi/getExpPrice')
        ExpPrice.raise_for_status()
        ExpPriceResp = ExpPrice.text.strip()
        
        NormPrice = s.get('http://your-website.com/raspi/getNormPrice')
        NormPrice.raise_for_status()
        NormPriceResp = NormPrice.text.strip()
        
        UpdatedLabelPrice = s.get('http://your-website.com/raspi/getUpdatedLabel')
        UpdatedLabelPrice.raise_for_status()
        UpdatedLabelPriceResp = UpdatedLabelPrice.text.strip()
        
        if(r.text.strip().count(';') == 0 or r.text.strip().count(';')%3 != 0):
          return (False,"Error")
        return (True,AdminResp, ExpCoffeeResp, NormCoffeeResp, UpdatedLabelResp)
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
UpdateOk, adminString, ExpCoffeeResp, NormCoffeeResp, UpdatedLabelResp = updateData(date)

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
else:
    f = open("/home/pi/Desktop/network.log", "a")
    f.write("NOT OK !\r\n")
    f.close()
