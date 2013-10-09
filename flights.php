<?php
/**
 * Get speaker flight live status
 */

date_default_timezone_set('Europe/London');
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

$json_url = $arrivals_url;
//if(strpos($day, 's') == 0){
if('sunday' == $day || 'monday' == $day){
	$json_url = $departure_url;
}

$json = file_get_contents($json_url);
$obj = json_decode($json);
$flights = $obj->flights;


$thursday = array(
	'EZY1832' 	=> 'Sigur Ros',
	'KL1093'	=> 'New Order'
);

$friday = array(
	'SN2173' => 'Rage Against the Machine',
	'EZY1832' => 'Regurgitator',
	'KL1081' => 'Norah Jones',
	'DL064' => 'Third Eye Blind',
	'EZY1898' => 'VV Brown',
	'KL1083' => 'OK Go',
	'AF2198' => 'Jack Johnson'
);

$sunday = array(
	'KL1074' => 'Tool',
	'KL1088' => 'Hugh Laurie',
	'SN2178' => 'Michael Buble',
	'BE7217' => 'RHCP',
	'KL1094' => 'Jason Mraz',
	'EZY1835' => 'Bob Dylan',
	'AF1169' => 'Bruno Mars'
);

$monday = array(
	'SN2174' => 'Emeli Sande',
	'DL065' => 'Example'
);

$dayArray = $$day;

?>
<html>
	<head>
	</head>
	<body>
		<?php
			echo '<h1>'.ucwords($day).'</h1>';

			foreach ($flights as $flight){
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
