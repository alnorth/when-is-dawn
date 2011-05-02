<?php
include_once 'hidden/hostipinfo.php';
require_once 'Services/GeoNames.php';

function getTimeForZenith($zenith) {
	$ipinfo = hostip_get_info('213.81.89.155' /*$_SERVER['REMOTE_ADDR']*/);
	$lat = $ipinfo['latitude'];
	$lng = $ipinfo['longitude'];
	
	$geo = new Services_GeoNames();
	$tzinfo = $geo->timezone(array('username' => 'alnorth29', 'lat' => $lat, 'lng' => $lng));
	
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
		return formatTime($timeAtZenith, 'GMT');
	} else {
		return 'I don\'t know :(';
	}
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
				<?php echo getCivilDawnTime(); ?>
			</div>
			<div class="push"></div>
		</div>
		<div id="footer">
			by <a href="http://www.twitter.com/alasdairnorth">@alasdairnorth</a> | <a href="about.php">about</a>
		</div>
	</body>
</html>