#!/bin/bash
#PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/local/games:/usr/games
export DISPLAY=:0.0

sudo ping -q -c5 8.8.8.8 #> /dev/null
if [ $? -eq 0 ];then
    echo "Update with internet $(date)" >> /home/pi/Desktop/network.log
    env DISPLAY=:0.0 sudo /usr/bin/python2.7 /kivy/CoffeeMProject/PinLoginVersion/updateDB.py
else
    sudo ifdown -a
    wait 10
    sudo ifup -a
    sudo echo "Update without internet $(date)" >> /home/pi/Desktop/network.log
fi
