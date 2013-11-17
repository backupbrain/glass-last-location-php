var map;

function centerMapOnPoint(map, latLng) {
	
	// add a marker
	var marker = new google.maps.Marker({
		position: latLng,
		map: map,
		title: 'A Google Glass'
	});
	
	contentString = '<div id="content">'+
	      '<div id="siteNotice">'+
	      '</div>'+
	      '<h1 id="firstHeading" class="firstHeading">Glass</h1>'+
	      '<div id="bodyContent">'+
	      '<p>Google Glass logged in from here</p>'+
	      '</div>'+
	      '</div>';
	
	// build the infowindow and open it
	var infowindow = new google.maps.InfoWindow({
		content: contentString,
		maxWidth: 200
	});
	
	infowindow.open(map, marker);
	
	// center the map
	map.setCenter(latLng);

}