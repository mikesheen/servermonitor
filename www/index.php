<?php
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Server Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mike Sheen">

	<script src="js/jquery.js"></script>
	<script type="text/javascript" src="js/smoothie.js"></script>
  </head>
  
  <body>  	
	<h1>CPU</h1>
	<p>By core</p>
    <canvas id="scpu0canvas" width="100" height="100"></canvas>
    <canvas id="scpu1canvas" width="100" height="100"></canvas>
    <canvas id="scpu2canvas" width="100" height="100"></canvas>
    <canvas id="scpu3canvas" width="100" height="100"></canvas>
    <canvas id="scpu4canvas" width="100" height="100"></canvas>
    <canvas id="scpu5canvas" width="100" height="100"></canvas>
    <canvas id="scpu6canvas" width="100" height="100"></canvas>
    <canvas id="scpu7canvas" width="100" height="100"></canvas>
	
    <h1>Bandwidth</h1>
	<p>In megabits per second; Red=transmit Green=receive</p>
    <canvas id="sbandwidthcanvas" width="800" height="100"></canvas>
	
<script type="text/javascript" charset="utf-8">

	

var scpulinec0 = new TimeSeries();
var scpulinec1 = new TimeSeries();
var scpulinec2 = new TimeSeries();
var scpulinec3 = new TimeSeries();
var scpulinec4 = new TimeSeries();
var scpulinec5 = new TimeSeries();
var scpulinec6 = new TimeSeries();
var scpulinec7 = new TimeSeries();
		
var sbandwidthline1 = new TimeSeries();
var sbandwidthline2 = new TimeSeries();

var scpu0smoothie = new SmoothieChart({minValue: 0, maxValue: 100, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
scpu0smoothie.addTimeSeries(scpulinec0, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
scpu0smoothie.streamTo(document.getElementById("scpu0canvas"), 1000);

var scpu1smoothie = new SmoothieChart({minValue: 0, maxValue: 100, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
scpu1smoothie.addTimeSeries(scpulinec1, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
scpu1smoothie.streamTo(document.getElementById("scpu1canvas"), 1000);

var scpu2smoothie = new SmoothieChart({minValue: 0, maxValue: 100, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
scpu2smoothie.addTimeSeries(scpulinec2, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
scpu2smoothie.streamTo(document.getElementById("scpu2canvas"), 1000);

var scpu3smoothie = new SmoothieChart({minValue: 0, maxValue: 100, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
scpu3smoothie.addTimeSeries(scpulinec3, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
scpu3smoothie.streamTo(document.getElementById("scpu3canvas"), 1000);

var scpu4smoothie = new SmoothieChart({minValue: 0, maxValue: 100, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
scpu4smoothie.addTimeSeries(scpulinec4, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
scpu4smoothie.streamTo(document.getElementById("scpu4canvas"), 1000);

var scpu5smoothie = new SmoothieChart({minValue: 0, maxValue: 100, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
scpu5smoothie.addTimeSeries(scpulinec5, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
scpu5smoothie.streamTo(document.getElementById("scpu5canvas"), 1000);

var scpu6smoothie = new SmoothieChart({minValue: 0, maxValue: 100, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
scpu6smoothie.addTimeSeries(scpulinec6, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
scpu6smoothie.streamTo(document.getElementById("scpu6canvas"), 1000);

var scpu7smoothie = new SmoothieChart({minValue: 0, maxValue: 100, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
scpu7smoothie.addTimeSeries(scpulinec7, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
scpu7smoothie.streamTo(document.getElementById("scpu7canvas"), 1000);

var sbandwidthsmoothie = new SmoothieChart({minValue: 0, grid: { strokeStyle: 'rgb(125, 0, 0)', fillStyle: 'rgb(60, 0, 0)', lineWidth: 1, millisPerLine: 250, verticalSections: 6 } });
sbandwidthsmoothie.addTimeSeries(sbandwidthline1, { strokeStyle: 'rgb(0, 255, 0)', fillStyle: 'rgba(0, 255, 0, 0.4)', lineWidth: 3 });
sbandwidthsmoothie.addTimeSeries(sbandwidthline2, { strokeStyle: 'rgb(255, 0, 0)', fillStyle: 'rgba(255, 0, 0, 0.4)', lineWidth: 3 });
sbandwidthsmoothie.streamTo(document.getElementById("sbandwidthcanvas"), 1000);

setInterval(function() {				
	$.ajax({
	  url: "https://www.sheen.id.au:83/monitor",
	  dataType: 'jsonp',
	  async: true,
	  cache: false,
	  error: function(xhr, textStatus, errorThrown){					
			},
	  success: function(result){															
			scpulinec0.append(new Date().getTime(), result.cpu00);
			scpulinec1.append(new Date().getTime(), result.cpu01);
			scpulinec2.append(new Date().getTime(), result.cpu02);
			scpulinec3.append(new Date().getTime(), result.cpu03);
			scpulinec4.append(new Date().getTime(), result.cpu04);
			scpulinec5.append(new Date().getTime(), result.cpu05);
			scpulinec6.append(new Date().getTime(), result.cpu06);
			scpulinec7.append(new Date().getTime(), result.cpu07);
													
			sbandwidthline1.append(new Date().getTime(), result.rx);
			sbandwidthline2.append(new Date().getTime(), result.tx);
		}
	});
}, 1000);
 
</script>
	
  </body>
</html>
