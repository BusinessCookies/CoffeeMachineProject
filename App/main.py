#!/usr/bin/env python
import thread
import kivy
import time
import os
from kivy.app import App
from kivy.uix.gridlayout import GridLayout
from kivy.uix.label import Label
from kivy.uix.button import Button
from kivy.uix.slider import Slider
from kivy.graphics import Color
from kivy.uix.image import Image
from kivy.uix.screenmanager import ScreenManager, Screen, WipeTransition
from random import randint
from kivy.properties import StringProperty
from kivy.clock import Clock
from kivy.uix.behaviors import ButtonBehavior

import CSV
import subprocess
import OtherClasses
import FoncGPIO as gpio
import usefull_methods
import Read as RFID
######################## Global Variables #########################

PinEnterred = OtherClasses.Pin()
currentuser = OtherClasses.CurrentUser()
quitApp = OtherClasses.QuitApp()
UD = OtherClasses.QuitApp()

Users = CSV.Users()
mycoffeelist = CSV.MycoffeeList()

Normalcoffee=OtherClasses.CoffeePriceClass("Normal")
ExpCoffee = OtherClasses.CoffeePriceClass("Expensive")
MinMonney = OtherClasses.CoffeePriceClass("MinMonney")
NumberOfDigitEntered=0
path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/"
NumberOfDigitEntered=0

WelcomeQuestionnaireIsEmpty=True
DankeQuestionnaireIsEmpty=True


#################################################################

########## Classes that overwrite Kivy native widgets ##########



######## Used for choose coffee screen ##########################
        
class Monney(Label): 
    def __init__(self, **kwargs):
        Label.__init__(self, **kwargs)
        Clock.schedule_interval(self.callback,0.1)       
    def callback(self,dt):
        global ExpCoffee
        global Normalcoffee
        if float(currentuser.monney) <0 :
            self.text = str(currentuser.monney) +" euros\n Cost of your coffee:\n" + str(ExpCoffee.val) + " euros"   
        else:
            self.text = str(currentuser.monney) +" euros\n Cost of your coffee:\n" + str(Normalcoffee.val) + " euros"   

            
class Beans_slider(Slider):
    def __init__(self, **kwargs):
        Slider.__init__(self, **kwargs)
        Clock.schedule_interval(self.callback,0.2)
    def callback(self,dt):
        global currentuser
        self.value = float(currentuser.beans)   
        #print "\n beans: ", currentuser.beans, "valueslider: ", self.value,"\n"
class Water_slider(Slider):
    def __init__(self, **kwargs):
        Slider.__init__(self, **kwargs)
        Clock.schedule_interval(self.callback,0.2)
    def callback(self,dt):
        #print "\n water: ",currentuser.water, "\n"
        self.value = float(currentuser.water)


##################### Used for welcome screen ##########################
class PinLabel(Label):
    def __init__(self, **kwargs):
        Label.__init__(self, **kwargs)
        self.text='_ _ _ _ _'
        Clock.schedule_interval(self.callback,0.1)
    def callback(self, dt):
        global PinEnterred
        if len(PinEnterred.val)== 0:
            self.text='_ _ _ _ _'
        if len(PinEnterred.val)== 1:
            self.text='* _ _ _ _'
        if len(PinEnterred.val)== 2:
            self.text='* * _ _ _'
        if len(PinEnterred.val)== 3:
            self.text='* * * _ _'
        if len(PinEnterred.val)== 4:
            self.text='* * * * _'
        if len(PinEnterred.val)== 5:
            self.text='* * * * *'

class UpdatedLabel (Label):
    def __init__(self, **kwargs):
        Label.__init__(self, **kwargs)
        global path
        self.pathToFile = path + "updated_label.txt" 
        try:
            f=open(self.pathToFile, 'r')
            self.text=f.read()
            f.close()
        except:
            print 'Cannot open this file'
        Clock.schedule_interval(self.callback,60)
    def callback(self, dt):
        try:
            f=open(self.pathToFile, 'r')
            self.text=f.read()
            f.close()

        except:
            print 'Cannot open this file'

class UpdatedLabelQuestionnaireDanke (Label):
    def __init__(self, **kwargs):
        Label.__init__(self, **kwargs)
        global path
        global DankeQuestionnaireIsEmpty
        self.pathToFile = path + "updated_label_Questionnaire_danke.txt" 
        try:
            f=open(self.pathToFile, 'r')
            self.text=f.read()
            f.close()
            if self.text != '':
                DankeQuestionnaireIsEmpty = False
            else:
                DankeQuestionnaireIsEmpty = True
        except:
            print 'Cannot open this file'
        Clock.schedule_interval(self.callback,60)
    def callback(self, dt):
        global DankeQuestionnaireIsEmpty
        try:
            f=open(self.pathToFile, 'r')
            self.text=f.read()
            f.close()
            if self.text != '':
                DankeQuestionnaireIsEmpty = False
            else:
                DankeQuestionnaireIsEmpty = True
        except:
            print 'Cannot open this file'

class UpdatedLabelQuestionnaireWelcome (Label):
    def __init__(self, **kwargs):
        Label.__init__(self, **kwargs)
        global path
        global WelcomeQuestionnaireIsEmpty
        self.pathToFile = path + "updated_label_Questionnaire_welcome.txt" 
        try:
            f=open(self.pathToFile, 'r')
            self.text=f.read()
            f.close()
        except:
            print 'Cannot open this file'
        Clock.schedule_interval(self.callback,60)
    def callback(self, dt):
        global WelcomeQuestionnaireIsEmpty
        try:
            f=open(self.pathToFile, 'r')
            self.text=f.read()
            f.close()
            if text != '':
                WelcomeQuestionnaireIsEmpty = False
            else:
                WelcomeQuestionnaireIsEmpty = True
        except:
            print 'Cannot open this file'


################# Used ForbiddenScreense coffee and wlcome screen ##########################            
class Easyclock(Label): 
    def __init__(self, **kwargs):
        Label.__init__(self, **kwargs)
        Clock.schedule_interval(self.callback,1)
    def callback(self,dt):
        self.text = time.strftime('%H: %M: %S')
########################################################################################

class ImageButton(ButtonBehavior, Image):
    pass


############################### Screens ###############################################
class WelcomeScreen(Screen):
    def __init__(self, **kwargs):
        Screen.__init__(self, **kwargs)
    def on_enter(self):
        #print quit_app
        Clock.schedule_once(self.callbackPinLogin, 1)
        Clock.schedule_once(self.callbackRFIDLogin, 1)
    def callbackRFIDLogin(self,dt):
        UID=RFID.read()
        if UID!='0':
            global currentuser
            #print '\n' + UID +'\n'
            global Users
            global mycoffeelist
            Users.DelUserList()
            Users.importFromCsvFile()
            mycoffeelist.DelMycoffeeList()
            mycoffeelist.importFromCsvFile()
            #print Users.users
            for row in Users.users:
                #print '\n', row,'    ', UID, '\n' 
                if UID == row[0].lower():
                    currentuser.UID=UID
                    if  row[1]=='ja':
                        currentuser.admin=True
                    else:
                        currentuser.admin=False
                    currentuser.monney=row[2]

                    for row1 in mycoffeelist.Mycoffee:
                        #print '\n', row1,'    ', UID, '\n' 
                        if UID == row1[0]:
                            currentuser.beans=row1[1]
                            currentuser.water=row1[2]
                            #print currentuser.UID, "  ",currentuser.admin,"  ",currentuser.beans, "  ",currentuser.water, "  ", currentuser.monney
                            self.manager.current='second'
                            return
                    mycoffeelist.setDefaultuser(currentuser)
                    currentuser.beans='3'
                    currentuser.water=180
                    #print "\n\n", currentuser.beans, "    ",currentuser.water, "\n\n"
                    return
            #if user is not in DB
            self.manager.current='unregistered'
        else:
            Clock.schedule_once(self.callback, 1)
            return


    def callbackPinLogin(self,dt):
        global currentuser
        global PinEnterred
        global quitApp
        global UD
        global Users
        global mycoffeelist
        global WelcomeQuestionnaireIsEmpty
        if len(PinEnterred.val)==5:
            if(PinEnterred.val == '13579' and quitApp.bool == True):
                App.get_running_app().stop()
                self.exit()
            if(PinEnterred.val == '00000'):
                quitApp.bool = True
                self.manager.current = "US"
                #print "\n\n1nd \n\n"#, quit_app
            else:
                quitApp.bool = False
            if(PinEnterred.val == '02468' and UD.bool == True):
                thread.start_new_thread(subprocess.call, (["sudo","sh", "/kivy/CoffeeMProject/PinLoginVersion/update_network.sh"],))
            if(PinEnterred.val == '55555'):
                UD.bool = True
                self.manager.current = "US"
            else:
                UD.bool = False
            Users.DelUserList()
            Users.importFromCsvFile()
            mycoffeelist.DelMycoffeeList()
            mycoffeelist.importFromCsvFile()
            for row in Users.users:
                if str(PinEnterred.val) == row[3].strip():
                    currentuser.UID=row[0]
                    currentuser.pin=PinEnterred.val
                    if  row[1]=='ja':
                        currentuser.admin=True
                    else:
                        currentuser.admin=False
                    currentuser.monney=row[2]
                    print currentuser.monney
                    if float(currentuser.monney) < MinMonney.val:
                        if currentuser.admin == False:
                            self.manager.current='FS'
                            return
                    for row1 in mycoffeelist.Mycoffee:
                        if currentuser.UID == row1[0]:
                            currentuser.beans=row1[1]
                            currentuser.water=row1[2]
                            if WelcomeQuestionnaireIsEmpty == True:
                                self.manager.current='CCS'
                                return
                            else:
                                self.manager.current='WQS'
                                return
                            return
                    mycoffeelist.setDefaultuser(currentuser)
                    currentuser.beans='3'
                    currentuser.water='180'
                    if WelcomeQuestionnaireIsEmpty == True:
                        self.manager.current='CCS'
                        return
                    else:
                        self.manager.current='WQS'
                        return
                    return
            self.manager.current='US'
        else:
            Clock.schedule_once(self.callback, 0.1)
            return
    def do_action(self,digit):
        global PinEnterred
        if digit == "update":
	    self.manager.current='UpS'
	    return
        elif len(PinEnterred.val)<5:
            if len(PinEnterred.val)<5:
                if digit=='del':
                    if len(PinEnterred.val)>0:
                        PinEnterred.RemoveDigit()
                else:
                    PinEnterred.AddDigit(str(digit))
            
class WelcomeQuestionnaireScreen(Screen):
    def __init__(self, **kwargs):
        Screen.__init__(self, **kwargs)
    def on_enter(self):
        Clock.schedule_once(self.callback, 5)
    def callback(self,dt):
        if self.manager.current == 'WQS':
            self.manager.current='CCS'
        else:
            pass
    def do_action(self, answer_questionnaire):
        global currentuser
        if answer_questionnaire=="Bad":
            grade=0
        elif answer_questionnaire=="Medium":
            grade=1
        else:
            grade=2
        PreviousCoffeeDate = usefull_methods.FindLastDate(currentuser.UID)    
        usergrade = CSV.Grade2([PreviousCoffeeDate, currentuser.UID,str(grade)])
        usergrade.WriteInCSV()
        self.manager.current='CCS'   
    
class UnregisteredScreen(Screen):
    def __init__(self, **kwargs):
        Screen.__init__(self, **kwargs)
    def on_enter(self):
        global PinEnterred
        PinEnterred.DelPin()
        Clock.schedule_once(self.callback, 5)
    def callback(self,dt):
        self.manager.current='WS'

class ForbiddenScreen(Screen):
    def __init__(self, **kwargs):
        Screen.__init__(self, **kwargs)
    def on_enter(self):
        global PinEnterred
        PinEnterred.DelPin()
        Clock.schedule_once(self.callback, 5)        
    def callback(self,dt):
        self.manager.current='WS'

class DankeScreen(Screen):
    def __init__(self, **kwargs):
        Screen.__init__(self, **kwargs)        
    def on_enter(self):
        Clock.schedule_once(self.callback, 5)
    def callback(self,dt):
        if self.manager.current == 'DS':
            self.manager.current='DS2'
        else:
            pass
    def do_action(self, answer_questionnaire):
        global currentuser
        if answer_questionnaire=="Bad":
            grade=0
        elif answer_questionnaire=="Medium":
            grade=1
        else:
            grade=2
        usergrade = CSV.Grade([time.strftime('%Y%m%d%H%M%S'), currentuser.UID,str(grade)])
        usergrade.WriteInCSV()
        self.manager.current='DS2'            

class DankeScreen2(Screen):
    def __init__(self, **kwargs):
        Screen.__init__(self, **kwargs)
    def on_enter(self):
        Clock.schedule_once(self.callback, 10)        
    def callback(self,dt):
        global currentuser
        currentuser.DelCurrentUser()
        self.manager.current='WS'


class UpdateScreen(Screen):
    def __init__(self, **kwargs):
        Screen.__init__(self, **kwargs)
    def on_enter(self):
        Clock.schedule_once(self.callback, 15)
    def callback(self, dt):
        if self.manager.current=='UpS':
            self.manager.current='WS'

class WaitUpdateScreen(Screen):
    def __init(self, **kwargs):
        Screen.__init__(self, **kwargs)
    def on_enter(self):
        thread.start_new_thread(subprocess.call, (["sudo","sh", "/kivy/CoffeeMProject/PinLoginVersion/update_network.sh"],))
        Clock.schedule_once(self.callback, 10)
    def callback(self, dt):
        self.manager.current='WS'



class ChooseCoffeeScreen(Screen):
    def __init__(self, **kwargs):
        Screen.__init__(self, **kwargs)
    def on_enter(self):
        global PinEnterred
        PinEnterred.DelPin()
        Clock.schedule_once(self.callback, 20)        
    def callback(self,dt):
        if self.manager.current=='CCS':
            self.manager.current='WS'
    def update_beans(self, beans):
        global currentuser
        currentuser.beans=beans
        return
    def  update_water(self,water):
        global currentuser
        currentuser.water=water
        return

    def do_action(self, ButtonPressed, beans, water):
        global Users
        global Expcoffee
        global Normalcoffee
        global currentuser
        global DankeQuestionnaireIsEmpty
        if str(ButtonPressed)=="setupB":
            #print '\n\n',currentuser.admin, '\n\n' 
            if currentuser.admin==True:
                self.manager.current="CCAS"
        if str(ButtonPressed)=="Expresso":
            gpio.DoExpresso()
            coffee= CSV.Coffee([time.strftime('%Y%m%d%H%M%S'),currentuser.UID,"1"])
            coffee.WriteInCSV()
            coffee.DelLastCoffee()
            if currentuser.admin == True:
                ad='ja'
            else:
                ad="nein"
            if currentuser.monney<0:
                price=Expcoffee.val
            else:
                price=Normalcoffee.val
            Users.SetUser([currentuser.UID,ad, str(float(currentuser.monney)-price), currentuser.pin])
        if str(ButtonPressed)=="Double Expresso":
            gpio.DoDoubleExpresso()
            coffee= CSV.Coffee([time.strftime('%Y%m%d%H%M%S'),currentuser.UID,"2"])
            coffee.WriteInCSV()
            coffee.DelLastCoffee()
            if currentuser.admin == True:
                ad='ja'
            else:
                ad="nein"
            if currentuser.monney<0:
                price=Expcoffee.val
            else:
                price=Normalcoffee.val
            Users.SetUser([currentuser.UID,ad, str(float(currentuser.monney)-price), currentuser.pin])
        if str(ButtonPressed)=="Coffee":
            gpio.DoCoffee()
            coffee= CSV.Coffee([time.strftime('%Y%m%d%H%M%S'),currentuser.UID,"3"])
            coffee.WriteInCSV()
            coffee.DelLastCoffee()
            if currentuser.admin == True:
                ad='ja'
            else:
                ad="nein"
            if currentuser.monney<0:
                price=Expcoffee.val
            else:
                price=Normalcoffee.val
            Users.SetUser([currentuser.UID,ad, str(float(currentuser.monney)-price), currentuser.pin])
        if str(ButtonPressed)=="Double Coffee":
            gpio.DoDoubleCoffee()
            coffee= CSV.Coffee([time.strftime('%Y%m%d%H%M%S'),currentuser.UID,"4"])
            coffee.WriteInCSV()
            coffee.DelLastCoffee()
            if currentuser.admin == True:
                ad='ja'
            else:
                ad="nein"
            if currentuser.monney<0:
                price=Expcoffee.val
            else:
                price=Normalcoffee.val
            Users.SetUser([currentuser.UID,ad, str(float(currentuser.monney)-price), currentuser.pin])
        if str(ButtonPressed)=="My Coffee":
            currentuser.beans=beans
            currentuser.water=water
            gpio.DoMyCoffee(beans, water)
            coffee= CSV.Coffee([time.strftime('%Y%m%d%H%M%S'),currentuser.UID,"5"])
            coffee.WriteInCSV()
            coffee.DelLastCoffee()
            mycoffeelist.SetMyCoffee([currentuser.UID,str(currentuser.beans),str(currentuser.water), currentuser.pin])
            if currentuser.admin == True:
                ad='ja'
            else:
                ad="nein"
            if currentuser.monney<0:
                price=Expcoffee.val
            else:
                price=Normalcoffee.val
            Users.SetUser([currentuser.UID,ad, str(float(currentuser.monney)-price), currentuser.pin])
        if DankeQuestionnaireIsEmpty == True:
            self.manager.current = 'DS2'
        else:
            self.manager.current = 'DS'

class ChooseCoffeeAdminScreen(Screen):
    def exit(self):
        GPIO.cleanup()
        self.manager.stop()
    def do_action(self, ButtonPressed):
        if str(ButtonPressed)=="Expresso":
            gpio.DoExpresso()
        if str(ButtonPressed)=="Double Expresso":
            gpio.DoDoubleExpresso()          
        if str(ButtonPressed)=="Coffee":
            gpio.DoCoffee()
        if str(ButtonPressed)=="Double Coffee":
            gpio.DoDoubleCoffee()
        if str(ButtonPressed)=="Filter":
            gpio.DoFilter()
        if str(ButtonPressed)=="MenuLong":
            gpio.DoMenuLong()
        if str(ButtonPressed)=="MenuShort":
            gpio.DoMenu()
        if str(ButtonPressed)=="Left":
            gpio.DoRotaLeft()
        if str(ButtonPressed)=="Right":
            gpio.DoRotaRight()
        if str(ButtonPressed)=="Exit":
            self.exit()

############################################################




########################## App #############################



class CoffeeMachineApp(App):
    def build(self):
        sm=ScreenManager(transition=WipeTransition())
        sm.add_widget(WelcomeScreen(name='WS'))
        sm.add_widget(WelcomeQuestionnaireScreen(name="WQS"))
        sm.add_widget(UnregisteredScreen(name='US'))
        sm.add_widget(ChooseCoffeeScreen(name='CCS'))
        sm.add_widget(ChooseCoffeeAdminScreen(name='CCAS'))
        sm.add_widget(DankeScreen(name='DS'))
        sm.add_widget(DankeScreen2(name='DS2'))
        sm.add_widget(ForbiddenScreen(name='FS'))
        sm.add_widget(UpdateScreen(name='UpS'))
        sm.add_widget(WaitUpdateScreen(name='WUpS'))
        #Launch the app
        return sm
        
if __name__ == '__main__':
    #signal.signal(signal.SIGINT,sys.exit(0))
    ud=OtherClasses.UpdateDB()
    CoffeeMachineApp().run()



#########################################*****END*****###################################
