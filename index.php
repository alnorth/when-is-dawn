<?php
include_once 'hidden/hostipinfo.php';
require_once 'Services/GeoNames.php';

$ipinfo = hostip_get_info('213.81.89.155' /*$_SERVER['REMOTE_ADDR']*/);
$geo = new Services_GeoNames();
$tzinfo = $geo->timezone(array('username' => 'alnorth29', 'lat' => $ipinfo['latitude'], 'lng' => $ipinfo['longitude']));
var_dump($tzinfo);

$tz = timezone_open($tzinfo->timezoneId);
print $tz->getOffset(new DateTime());

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
				<span class="time">9:41</span>
				<span class="ampm">am</span>
				<span class="timezone">BST</span>
			</div>
			<?php  ?>
			<div class="push"></div>
		</div>
		<div id="footer">
			by <a href="http://www.twitter.com/alasdairnorth">@alasdairnorth</a> | <a href="about.php">about</a>
		</div>
	</body>
</html>