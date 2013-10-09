<?php
/**
 * Get speaker flight live status
 */

date_default_timezone_set('Europe/London'); // should be set in php.ini
$day = strtolower(date('l'));

$html = '<hr /><div> 
			<h2>%s</h2>
			<ul >
				<li>Flight Number: %s</li>
				<li>Terminal: %s</li>
				<li>Scheduled Landing: %s</li>
				<li>Status: %s</li>
			</ul>
		</div>';

$arrivals_url = 'http://www.manchesterairport.co.uk/flightinformation/arrivals.json';
$departure_url = 'http://www.manchesterairport.co.uk/flightinformation/departures.json';
$interestedFlights_url = 'interestedFlights.php';

$json_url = $arrivals_url;

if('sunday' == $day || 'monday' == $day){
	$json_url = $departure_url;
}

$json = file_get_contents($json_url);
$obj = json_decode($json);
$flights = $obj->flights;

$interestedFLights = file_get_contents($interestedFLights_url);

$dayArray = $interestedFLights[$day];

?>
<html>
	<head>
	</head>
	<body>
		<?php
			echo '<h1>'.ucwords($day).'</h1>';
			
			foreach ($flights as $flight){
				// Should htmlspecialchar escape all the flight properties. Using a templating engine ( eg twig) would auto escape this. 
				if (array_key_exists($flight->flightNumber, $dayArray) && is_int(strpos(strtolower($flight->schdDate), $day))){
					printf(
						$html,
						$dayArray[$flight->flightNumber],
						$flight->flightNumber,
						$flight->terminal,
						$flight->schdTime,
						$flight->status
					);
				}
			}
		?>
	</body>
</html>
