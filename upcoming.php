<?php
session_start();

// Holds the various APIs involved as a PHP class. Download this class at the end of the tutorial
echo 'start: ';
function GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {	
		$url = 'https://www.googleapis.com/oauth2/v4/token';			
	
		$curlPost = 'client_id=' . $client_id . '&client_secret=' . $client_secret . '&refresh_token='. $code . '&grant_type=refresh_token';
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt($ch, CURLOPT_POST, 1);		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to receieve access token');
		
		return $data;
	}

function GetCalendarEvents($calendar_id, $timeMin, $timeMax, $event_timezone, $access_token) {
    
        // mandatory time zone
		$url_settings = 'https://www.googleapis.com/calendar/v3/calendars/'.$calendar_id.'/events?'.
		'timeMin='.$timeMin.'Z'.'&timeMax='.$timeMax.'Z'.'&timeZone='.$event_timezone;
	
	    echo "
	    ".$url_settings."
	    ";
	
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url_settings);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);	
		$data = json_decode(curl_exec($ch), true);
		var_dump($data);
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get timezone');

		return $data['value'];
	}
	
function GetUserCalendarTimezone($access_token) {
		$url_settings = 'https://www.googleapis.com/calendar/v3/users/me/settings/timezone';
	
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url_settings);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);	
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get timezone');

		return $data['value'];
	} 


try {

	// Get the access token 
	
	$data = GetAccessToken(APP_CLIENT_ID, "https://www.yourdomain.it/google-login.php", APP_SECRET, REFRESH_TOKEN);
	// Access Token
	$access_token = $data['access_token'];
	// The rest of the code to add event to Calendar will come here
    //var_dump($access_token);
    $user_timezone = GetUserCalendarTimezone($access_token);
    // Get user calendar timezone

    $calendar_id = 'primary';
    //$event_title = $_GET['title'];
    
    // Event starting & finishing at a specific time
    $full_day_event = 0; 
    $event_time = [ 'start_time' => '2016-12-20T15:00:00', 'end_time' => '2017-01-20T16:00:00' ];
    
    // Full day event
    //$full_day_event = 1; 
    //$event_time = [ 'event_date' => '2016-12-31' ];
    
    // Create event on primary calendar
    $data = GetCalendarEvents($calendar_id, $event_time['start_time'],$event_time['end_time'], $user_timezone, $access_token);
    var_dump($data);
}
catch(Exception $e) {
	echo $e->getMessage();
	exit();
}


?>