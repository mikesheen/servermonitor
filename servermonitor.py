#!/usr/bin/python

from __future__ import with_statement
from tornado.web import asynchronous

import tornado.httpserver
import tornado.websocket
import tornado.ioloop
import tornado.web
import sys
import os
import re
import cgi
import subprocess
import csv
import StringIO
import socket
import struct
import thread
import threading
import datetime
import time
import psutil

class Operation(threading._Timer):
    def __init__(self, *args, **kwargs):
        threading._Timer.__init__(self, *args, **kwargs)
        self.setDaemon(True)

    def run(self):
        while True:
            self.finished.clear()
            self.finished.wait(self.interval)
            if not self.finished.isSet():
                self.function(*self.args, **self.kwargs)
            else:
                return
            self.finished.set()

class Manager(object):
    ops = []
    def add_operation(self, operation, interval, args=[], kwargs={}):
        op = Operation(interval, operation, args, kwargs)
        self.ops.append(op)
        thread.start_new_thread(op.run, ())

    def stop(self):
        for op in self.ops:
            op.cancel()
        self._event.set()

PORT = int(sys.argv[1])
_cpu_stats = {'cpu00': 0, 'cpu01': 0, 'cpu02': 0, 'cpu03': 0, 'cpu04': 0, 'cpu05': 0, 'cpu06': 0, 'cpu07': 0, 'tx': 0, 'rx': 0}
_previousNet = None

def monitor_system():
    global _cpu_stats
    global _previousNet
    # Read CPU
    CPUpercs = psutil.cpu_percent(interval=0, percpu=True)
    # Read network    
    currentNet = psutil.net_io_counters(pernic=False)
    if _previousNet is None:
      _previousNet = currentNet
    
    tx = ((float(currentNet.bytes_sent - _previousNet.bytes_sent) * 8) / 1024) / 1024
    rx = ((float(currentNet.bytes_recv - _previousNet.bytes_recv) * 8) / 1024) / 1024
    _cpu_stats = {'cpu00': CPUpercs[0], 'cpu01': CPUpercs[1], 'cpu02': CPUpercs[2], 'cpu03': CPUpercs[3], 'cpu04': CPUpercs[4], 'cpu05': CPUpercs[5], 'cpu06': CPUpercs[6], 'cpu07': CPUpercs[7], 'tx': tx, 'rx': rx}
    _previousNet = currentNet;
	                   
class MonitorStatusHandler(tornado.web.RequestHandler):
    def set_default_headers(self):
        self.set_header("Access-Control-Allow-Origin", "http://sheen.id.au")
            
    def get(self):
        global _cpu_stats
        _json = tornado.escape.json_encode(_cpu_stats)
        if not self.get_argument("callback", None) is None:
            returnvalue = self.get_argument("callback") + "(" + _json + ")"
        else:
            returnvalue = _json
            
        self.write(returnvalue)
        self.set_header('Content-Type', 'application/json') 

application = tornado.web.Application([(r'/monitor', MonitorStatusHandler)])

if __name__ == '__main__':    
    http_server = tornado.httpserver.HTTPServer(application, ssl_options={"certfile": "/etc/apache2/certs/sheen.id.au.crt", "keyfile": "/etc/apache2/certs/sheen.key"})
    http_server.listen(PORT)

    monitorsystem_callback = tornado.ioloop.PeriodicCallback(monitor_system, 1000)
    monitorsystem_callback.start()
    
    io_loop = tornado.ioloop.IOLoop.instance()
    
    try:
        io_loop.start()
    except SystemExit, KeyboardInterrupt:
        io_loop.stop()