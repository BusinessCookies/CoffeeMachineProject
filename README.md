# CoffeeMachineProject
<h3>
	Jura coffee machine upgraded with a raspberry pi, running a Kivy app for customers management.
</h3>

<p>
	<li>As it is a Kivy application, the visual of any screen is descripted in the file named coffeemachine.kv.</li>

	<li>Our databases are stored in .CSV files, so CSV.py contains functions that read those files and change them locally.</li>

	<li>As we had duplicates when writing in databases with python on the raspberry, we had to rewrite CSV parser</li>
</p>
You will find below more information about different configurations we had to do on the raspberry and tutorials we used.

Here are a few picture of the coffee machine working :

![ScreenShot](/Data/ImgReadMe/IMG_1636.JPG?raw=true )

![ScreenShot](/Data/ImgReadMe/IMG_1637.JPG?raw=true )

![ScreenShot](/Data/ImgReadMe/IMG_1638.JPG?raw=true )

![ScreenShot](/Data/ImgReadMe/IMG_1639.JPG?raw=true )

<p>
To install Kivy on raspbian and to get started with Kivy: 
	https://github.com/mrichardson23/rpi-kivy-screen
</p>
<p>
In order to boot directly on the Kivy app, we used a Daemon, following this tutorial:
	http://www.stuffaboutcode.com/2012/06/raspberry-pi-run-program-at-start-up.html
</p>
