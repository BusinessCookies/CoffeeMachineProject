# CoffeeMachineProject
<h3>
	Jura coffee machine upgraded with a raspberry pi, running a Kivy app for customers management.
</h3>

<p>
In order to interface the raspberry with the coffee machine, we replaced button to order coffee by optocouplers, linked with the GPIO of the raspberry pi.
</p>

<p>
	<li>As it is a Kivy application, the visual of any screen is descripted in the file named coffeemachine.kv.</li>

	<li>Our databases are stored in .CSV files, so CSV.py contains functions that read those files and change them locally.</li>

	<li>As we had duplicates when writing in databases with python on the raspberry, we had to rewrite CSV parser</li>
</p>
You will find below every link we used in order to configurate raspbian and Kivy and the list of electronical part that we used for this project.

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
<p>
	List of electronical parts:
	<li>Touchscreen : https://www.element14.com/community/docs/DOC-78156/l/raspberry-pi-7-touchscreen-display</li>
	<li>Power supply: 5V/4A </li>
	<li>WLAN : http://www.edimax.com/edimax/merchandise/merchandise_detail/data/edimax/global/wireless_adapters_n150/ew-7811un</li>
	<li>Adafruit Prototyping Pi Plate Kit: https://www.adafruit.com/products/801</li>

</p>
