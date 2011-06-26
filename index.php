
<!DOCTYPE html>
<html>
	<head>
		<title>When is Dawn?</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<?php include('hidden/ga.php'); ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript">
			function getDawnTime(position) {
				var posData = {};
				if(position) {
					posData.lat = position.coords.latitude,
					posData.lng = position.coords.longitude
				}
				$.get("dawn.php", posData, function(data) {
					$("div#dawn div").html(data);
				});
			}
			
			$(document).ready(function() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(getDawnTime, function(error){getDawnTime();});
				} else {
					getDawnTime();
				}
			});
		</script>
	</head>
	<body>
		<div class="wrapper">
			<div id="dawn">
				<div><img src="ajax-loader.gif" /></div>
			</div>
			<div class="push"></div>
		</div>
		<div id="footer">
			by <a href="http://www.twitter.com/alasdairnorth">@alasdairnorth</a> | <a href="about.php">about</a> | <a href="http://software.alnorth.com/">other projects</a>
		</div>
	</body>
</html>