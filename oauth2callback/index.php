<?php
// oauth2callback/index.php


require('../settings.php');

require_once('../classes/Google_OAuth2_Token.class.php');
require_once('../classes/Google_Location.class.php');

	
/**
 * the OAuth server should have brought us to this page with a $_GET['code']
 */
if(isset($_GET['code'])) {
    // try to get an access token
    $code = $_GET['code'];
 
	// authenticate the user
	$Google_OAuth2_Token = new Google_OAuth2_Token();
	$Google_OAuth2_Token->code = $code;
	$Google_OAuth2_Token->client_id = $settings['oauth2']['oauth2_client_id'];
	$Google_OAuth2_Token->client_secret = $settings['oauth2']['oauth2_secret'];
	$Google_OAuth2_Token->redirect_uri = $settings['oauth2']['oauth2_redirect'];
	$Google_OAuth2_Token->grant_type = "authorization_code";

	try {
		$Google_OAuth2_Token->authenticate();
	} catch (Exception $e) {
		// handle this exception
		print_r($e);
	}

	// A user just logged in.  Let's figure out where their Glass is
	if ($Google_OAuth2_Token->authenticated) {
		
		$Google_Location = new Google_Location($Google_OAuth2_Token);
		$Google_Location->fetch();

		try {
			$Google_Location->fetch();
		} catch (Exception $e) {
			// handle this exception
			print_r($e);
		}
		
		
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../assets/css/screen.css"></link>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $settings['oauth2']['apikey']; ?>&sensor=false"></script>
	<script src="../assets/js/mapping.js"></script>
	<script type="text/javascript">
		
		
		

		function initialize() {
		  var mapOptions = {
		    center: new google.maps.LatLng(0, 0),
		    zoom: 15,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		  };
		  map = new google.maps.Map(document.getElementById("map-canvas"),
		      mapOptions);
		
		
			console.log(map);
			centerMapOnPoint(map, 
				new google.maps.LatLng(
					<?= $Google_Location->latitude; ?>,
					<?= $Google_Location->longitude; ?>
				)
			);

		}

		google.maps.event.addDomListener(window, 'load', initialize);
   	</script>
</head>
<body>
<h1>This Glass is located at:</h1>
<dl>
	<dt>Latitude:</dt>
	<dd><?= $Google_Location->latitude; ?></dd>
	<dt>Longitude:</dt>
	<dd><?= $Google_Location->longitude; ?></dd>
	<dt>Accuracy:</dt>
	<dd><?= $Google_Location->accuracy; ?> meters</dd>
	<dt>When:</dt>
	<dd><?= $Google_Location->timestamp; ?></dd>
</dl>

<div id="map-canvas"/>
</body>
</html>