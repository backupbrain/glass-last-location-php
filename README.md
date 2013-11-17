Determine a User's Location
=============================
This code shows how to grab the location of an OAuth2 authenticated user's Google Glass
The location information that comes back will include a latitude, longitude, and accuracy in meters.

This data is plotted on a Google Map.

It is intended as a complement to my tutorial:
http://20missionglass.tumblr.com/post/67202280192/determine-a-users-location

Configuration
--------------
Set up an OAuth2 Client App in the Google Code Console:
https://code.google.com/apis/console/

Once you register an app, create  you will get a client id and client secret. 
You will also need to create a Browser API Key for the Google Maps API.  

Edit your settings.php to reflect your oauth2 client app's settings.

$settings['oauth2']['oauth2_client_id'] = 'YOURCLIENTID.apps.googleusercontent.com';
$settings['oauth2']['oauth2_secret'] = 'YOURCLIENTSECRET';
$settings['oauth2']['oauth2_redirect'] = 'https://example.com/oauth2callback';
$settings['oauth2']['api_key'] = 'API_KEY';



Now you should be good to go.


