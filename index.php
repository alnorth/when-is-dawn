
<!DOCTYPE html>
<html>
	<head>
		<title>When is Dawn?</title>
		<meta name="description" content="whenisdawn.com tells you when dawn is wherever you are." />
		<meta name="viewport" content="width=device-width">
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
					$(window).resize();
				});
			}
			
			$(document).ready(function() {
				$(window).resize(function(){
					$("div#dawn div").css({
						position:"absolute",
						left: ($(window).width() - $("div#dawn div").outerWidth())/2,
						top: ($(window).height() - $("div#dawn div").outerHeight())/2
					});
				});

				// To initially run the function:
				$(window).resize();

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
			&copy; 2011-2012 <a href="http://www.twitter.com/alasdairnorth">@alasdairnorth</a> | <a href="about.php">about</a> | <a href="http://software.alnorth.com/">other projects</a>
		</div>
	</body>
</html>