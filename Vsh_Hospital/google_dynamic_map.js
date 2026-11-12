// google_dynamic_map.js file

// Map Initialize function
function initialize() 
{
	
	// Set static latitude, longitude value
	var latlng = new google.maps.LatLng(13.053085074428376,80.21314787274173);
	
	var geocoder = new google.maps.Geocoder();
	
	var infowindow = new google.maps.InfoWindow();
	// Set map options
	var myOptions = {
		zoom: 14,
		center: latlng,
		panControl: true,
		zoomControl: true,
		scaleControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	// Create map object with options
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	// Create and set the marker
	marker = new google.maps.Marker({
		map: map,
		draggable:true,	
		position: latlng
	});
	
	geocoder.geocode({'latLng': latlng }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				//document.getElementById('address1').value=results[0].formatted_address;
				infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
			}
		}
	});
	
	
	// Register Custom "dragend" Event
	google.maps.event.addListener(marker, 'dragend', function() {
															  
		 geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                           document.getElementById('address').value=results[0].formatted_address;
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });													  
		
		// Get the Current position, where the pointer was dropped
		var point = marker.getPosition();
		// Center the map at given point
		map.panTo(point);
		// Update the textbox
		document.getElementById('latitude').value=point.lat();
		document.getElementById('longitude').value=point.lng();
	});
}


