<?php
include_once 'hidden/hostipinfo.php';
require_once 'Services/GeoNames.php';

function getTimeForZenith($zenith) {
	$returnValue = "";
	$ipinfo = hostip_get_info($_SERVER['REMOTE_ADDR']);
	if($ipinfo) {
		$lat = $ipinfo['latitude'];
		$lng = $ipinfo['longitude'];

		$geo = new Services_GeoNames();
		$tzinfo = $geo->timezone(array('username' => 'alnorth29', 'lat' => $lat, 'lng' => $lng));

		if(property_exists($tzinfo, "timezoneId")) {
			$now = new DateTime();
			$tz = timezone_open($tzinfo->timezoneId);
			$offsetInSeconds = $tz->getOffset($now);
			$offsetInHours = $offsetInSeconds / 3600;
			
			$timeAtZenith = "";
			if($zenith < 0) {
				$timeAtZenith = date_sunrise($now->getTimestamp(), SUNFUNCS_RET_STRING, $lat, $lng, $zenith, $offsetInHours);
			} else {
				$timeAtZenith = date_sunset($now->getTimestamp(), SUNFUNCS_RET_STRING, $lat, $lng, $zenith, $offsetInHours);
			}
			
			if($timeAtZenith != "") {
				$returnValue = formatTime($timeAtZenith, getTimezoneAbbr($tzinfo->timezoneId));
			}
		}
	}
	if($returnValue != "") {
		return $returnValue;
	} else {
		return 'I don\'t know :(';
	}
}

function getTimezoneAbbr($timezoneId) {
	// From http://www.ilovebonnie.net/2008/08/06/time-zone-abbreviation-difficulties-with-php/
	$dateTime = new DateTime('now');
	$dateTime->setTimeZone(new DateTimeZone($timezoneId));
	return $dateTime->format('T');
}

function formatTime($time, $tzAbbr) {
	return '<span class="time">'. $time .'</span><span class="timezone">'. $tzAbbr .'</span>';
}

function getCivilDawnTime() {
	return getTimeForZenith(-96);
}

function getCivilDuskTime() {
	return getTimeForZenith(96);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>When is Dawn?</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<?php include('hidden/ga.php'); ?>
	</head>
	<body>
		<div class="wrapper">
			<div id="dawn">
				<div><?php echo getCivilDawnTime(); ?></div>
			</div>
			<div class="push"></div>
		</div>
		<div id="footer">
			by <a href="http://www.twitter.com/alasdairnorth">@alasdairnorth</a> | <a href="about.php">about</a> | <a href="http://software.alnorth.com/">other projects</a>
		</div>
	</body>
</html>