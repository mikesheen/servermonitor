# servermonitor
servermonitor is a small project to provide a few simple web graphs showing server CPU and bandwidth usage

## About ##
servermonitor is a small project utilising Python, PHP and javascript to provide a few simple graphs on CPU and bandwidth usage.  It works by using Python as a webserver to serve json encoded information, and then the javascript to product animated graphs based on that data.


For my original purposes, I had the webserver serving the HTTP and the server serving the json on separate machines, so that is why I chose to separate the two.  This project was made to monitor the CPU and bandwidth usage of a game server in real time, and I didn't want the game server running a web server, so the lightweight Tornado Python module was chosen.

Live example: https://www.sheen.id.au/monitor/


Example image: ![alt tag](https://raw.github.com/mikesheen/servermonitor/master/sampleimage.png)

## Prerequisites ##
It depends on following:
* The Python module Tornado (http://www.tornadoweb.org/en/stable/)
* The Python module psutil (https://github.com/giampaolo/psutil)
* The javascript library smoothie charts (http://smoothiecharts.org/)

We also assume you have a web server, such as Apache which can server up HTML and PHP.

## Installation ##
Copy the www folder contents to your webserver folder.

Run the Python script servermonitor.py using the following:
```
/usr/bin/python servermonitor.py 82
```
Note the port number to listen to is passed as a parameter - in this example I'm using port 82.  This is the port the Python webserver will server the json up on.

You can check the json being served using a browser and visiting the :PORT/monitor addess - eg:
```
https://sheen.id.au:83/monitor
```

Now you'll need to edit the index.php to make it look at your Python service for the json - in the code look for the following line and replace it with your own.
```
url: "https://www.sheen.id.au:83/monitor"
```

With that done, you can now visit your front-end web server to view the graphs.
