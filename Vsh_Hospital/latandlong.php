<?php
$GLOBALS["ntddrinHIXpCqFRijwFv"]=base64_decode("ZGxhdA==");$GLOBALS["iIrmHNStzIJjGbRGnvBw"]=base64_decode("ZGxvbmc=");$GLOBALS["ErzUZFlfsBHFXtoArbCQ"]=base64_decode("YWxhdA==");$GLOBALS["SGZSyngRhodKlKzTsYIg"]=base64_decode("YWxvbmc=");
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>DOCTOR LOCATION - ABM APPROVED LOCATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.css" />
    <link rel="stylesheet" href="../dist/leaflet-routing-machine.css" />
    <style>
    	.map {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
		}
		
		.results {
			background-color: white;
			opacity: 0.8;
			position: absolute;
			top: 12px;
			right: 12px;
			width: 320px;
			height: 480px;
			overflow-y: scroll;
		}
		
		.leaflet-bar
		{
		display:none;
		}
    </style>
</head>
<body>
    <div id="map" class="map"></div>
    <b><span style="color:#00FF33">GREEN MARKER</span> - DOCTOR LOCATION / <span style="color:#FF0000">RED MARKER</span> - MANAGER APPROVED LOCATION</b>
    <script src="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.js"></script>
    <script src="../dist/leaflet-routing-machine.js"></script>
    <script>
    	var map = L.map('map');

		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://micandmac.net/copyright">micandmac</a> contributors'
		}).addTo(map);
		
		function button(label, container) {
                var btn = L.DomUtil.create('button', '', container);
                btn.setAttribute('type', 'button');
                btn.innerHTML = label;
                return btn;
            }
		
		
		var control = L.Routing.control(L.extend({
			waypoints: [
				
				L.latLng(<?php echo $_REQUEST[$GLOBALS["ntddrinHIXpCqFRijwFv"]];?>,<?php echo $_REQUEST[$GLOBALS["iIrmHNStzIJjGbRGnvBw"]];?>),
				L.latLng(<?php echo $_REQUEST[$GLOBALS["ErzUZFlfsBHFXtoArbCQ"]];?>,<?php echo $_REQUEST[$GLOBALS["SGZSyngRhodKlKzTsYIg"]];?>)
			],
			routeWhileDragging: false,
			reverseWaypoints: false,
			showAlternatives: false,
		})).addTo(map);
		
		map.on('click', function (e) {
                var container = L.DomUtil.create('div'),
                    startBtn = button('Start from this location', container),
                    destBtn = button('Go to this location', container);

                L.DomEvent.on(startBtn, 'click', function () {
                    control.spliceWaypoints(0, 1, e.latlng);
                    map.closePopup();
                });

                L.DomEvent.on(destBtn, 'click', function () {
                    control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng);
                    map.closePopup();
                });

                L.popup().setContent(container).setLatLng(e.latlng).openOn(map);
            });

            L.easyButton('<span class="fa fa-floppy-o"></span>', function () {
                alert('Save routing coordinates ...');
            }).addTo(map);
		
		
		L.Routing.errorControl(control).addTo(map);
    </script>
</body>
</html>