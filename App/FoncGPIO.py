import RPi.GPIO as GPIO
import time
import CSV
from kivy.clock import Clock

GPIO.setwarnings(False)
#Logic variable
state_rota=False

# Set up GPIO:
ExpressoPin = 16
DoubleExpressoPin = 18
CoffeePin = 13
DoubleCoffeePin = 15
FilterPin = 12
PIN_BUTTON_RA = 8
PIN_BUTTON_RB = 10
MenuPin = 11

globalbeans = 2
globalwater = 180

GPIO.setmode(GPIO.BOARD)
GPIO.setup(ExpressoPin, GPIO.OUT)
GPIO.output(ExpressoPin, GPIO.LOW)

GPIO.setup(DoubleExpressoPin, GPIO.OUT)
GPIO.output(DoubleExpressoPin, GPIO.LOW)

GPIO.setup(CoffeePin, GPIO.OUT)
GPIO.output(CoffeePin, GPIO.LOW)

GPIO.setup(DoubleCoffeePin, GPIO.OUT)
GPIO.output(DoubleCoffeePin, GPIO.LOW)

GPIO.setup(MenuPin, GPIO.OUT)
GPIO.output(MenuPin, GPIO.LOW)

GPIO.setup(FilterPin, GPIO.OUT)
GPIO.output(FilterPin, GPIO.LOW)

GPIO.setup(PIN_BUTTON_RA, GPIO.OUT)
GPIO.output(PIN_BUTTON_RA, GPIO.LOW)

GPIO.setup(PIN_BUTTON_RB, GPIO.OUT)
GPIO.output(PIN_BUTTON_RB, GPIO.LOW)


#Global time variables 
TIME_PRESS_BUTTON = 0.5 #(ms in s)
TIME_LONG_PRESS_BUTTON = 3 #(ms in s)
TIME_ROTA_DELAY = 0.050 #(ms in s)



def pressSimul(pinButton):
    GPIO.output(pinButton, GPIO.HIGH)
    time.sleep(TIME_PRESS_BUTTON)              
    GPIO.output(pinButton, GPIO.LOW)    

def DoMenuLong():
    GPIO.output(MenuPin, GPIO.HIGH)   
    time.sleep(TIME_LONG_PRESS_BUTTON)              
    GPIO.output(MenuPin, GPIO.LOW)

def DoRotaRight():
    global state_rota
    state_rota = not state_rota
#    state_rota=True
    print '\n\n',state_rota, '\n\n'
    if state_rota:
        GPIO.output(PIN_BUTTON_RB, GPIO.HIGH)   
        time.sleep(TIME_ROTA_DELAY)              
        GPIO.output(PIN_BUTTON_RA, GPIO.HIGH)
        time.sleep(TIME_ROTA_DELAY)
        DoRotaRight()
    else:
        GPIO.output(PIN_BUTTON_RB, GPIO.LOW)   
        time.sleep(TIME_ROTA_DELAY)              
        GPIO.output(PIN_BUTTON_RA, GPIO.LOW)
        time.sleep(TIME_ROTA_DELAY) 

def DoRotaLeft():
    global state_rota
    print '\n\n',state_rota, '\n\n'
    state_rota = not state_rota
    if state_rota:
        GPIO.output(PIN_BUTTON_RA, GPIO.HIGH)   
        time.sleep(TIME_ROTA_DELAY)              
        GPIO.output(PIN_BUTTON_RB, GPIO.HIGH)
        time.sleep(TIME_ROTA_DELAY)
        DoRotaLeft()
    else:
        GPIO.output(PIN_BUTTON_RA, GPIO.LOW)   
        time.sleep(TIME_ROTA_DELAY)              
        GPIO.output(PIN_BUTTON_RB, GPIO.LOW)
        time.sleep(TIME_ROTA_DELAY) 
def DoMenu():
    pressSimul(MenuPin)
def DoFilter():
    pressSimul(FilterPin)
def DoExpresso():
    pressSimul(ExpressoPin)
def DoDoubleExpresso():
    pressSimul(DoubleExpressoPin)
def DoCoffee():
    pressSimul(CoffeePin)
def DoDoubleCoffee():
    pressSimul(DoubleCoffeePin)
def DoMyCoffee(beans, water):
    global globalwater
    globalwater = water
    global globalbeans
    globalbeans = beans
    Clock.schedule_once(callbackWater, 10)
    Clock.schedule_once(callbackCoffee, 1)
    pressSimul(CoffeePin)
    
def callbackCoffee(dt):
    global globalbeans
    nb = int(2 - globalbeans) 
    if(nb > 0): # left
        for i in range(nb):
            DoRotaLeft()
            time.sleep(TIME_ROTA_DELAY)
    else: # right
        for i in range(-nb):
            DoRotaRight()
            time.sleep(TIME_ROTA_DELAY)
            
def callbackWater(dt):
    global globalwater
    nb = int( float(180 - globalwater)/5.0 )
    if(nb > 0): # left
        for i in range(nb):
            DoRotaLeft()
    else: # right
         for i in range(-nb):
            DoRotaRight()
