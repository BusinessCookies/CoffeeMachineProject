from kivy.clock import Clock
import thread
import subprocess

path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/"



class QuitApp:
    def __init__(self, **kwargs):
      self.bool = False
    
class CurrentUser:
    def __init__(self, **kwargs):
        self.admin = False
        self.UID=''
        self.beans=0
        self.water=0
        self.monney=0
        self.pin=''
    def SetCurrentUser(self, admin, UID, beans, water, monney, pin):
        self.admin = False
        self.UID=UID
        self.beans=beans
        self.water=water
        self.monney=monney
        self.pin=pin
    def DelCurrentUser(self):
        self.admin = False
        self.UID=''
        self.beans=0
        self.water=0
        self.monney=0
        self.pin=''

class Pin:
    def __init__(self, **kwargs):
        self.val=''
    def AddDigit(self, digit):
        self.val +=digit
    def RemoveDigit(self):
        self.val=self.val[0:-1]
    def DelPin(self):
        self.val=''
        

            
class UpdateDB():
    def __init__(self, **kwargs):
        Clock.schedule_interval(self.callback,1200)
    def callback(self,dt):
        thread.start_new_thread(subprocess.call, (["sudo","/bin/bash", "/kivy/CoffeeMProject/PinLoginVersion/update_network.sh"],))
   
class CoffeePriceClass():
    def __init__(self, pricetype):
        global path
        self.pricetype = pricetype
        if pricetype == "Normal":
            f = open(path+"NormCoffee.txt", 'rb')
        elif pricetype == "Expensive":
            f = open(path+"ExpCoffee.txt", 'rb')
        else:
            print "error"
            pass
        self.val=float(f.read().strip())
        f.close()
        Clock.schedule_interval(self.callback,600)
    def callback(self,dt):
        global path
        if self.pricetype == "Normal":
            f = open(path+"NormCoffee.txt", 'rb')
        elif self.pricetype == "Expensive":
            f = open(path+"ExpCoffee.txt", 'rb')
        self.val=float(f.read().strip())
        f.close()
        return
