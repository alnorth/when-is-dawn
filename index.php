
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
					$("div#dawnText").html(data);
					$(window).resize();
				});
			}
			
			$(document).ready(function() {
				$(window).resize(function(){
					$("div#dawn").css({
						position:"absolute",
						left: ($(window).width() - $("div#dawn").outerWidth())/2,
						top: ($(window).height() - $("div#dawn").outerHeight())/2
					});
				});

				$("#aboutLink").click(function() {
					$("#dawnText").toggle();
					$("#aboutText").toggle();
					$(window).resize();
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
				<div id="dawnText"><img src="ajax-loader.gif" /></div>
				<div id="aboutText" style="display:none;">
					<p>This website tells you when the 'crack of dawn' is wherever you are.</p>
					<p>If it's not right (and for some reason you're really concerned about that) then contact me on twitter to let me know.</p>
					<p><small><a href="http://www.flickr.com/photos/atomdocs/3275758118">Photo from Tom BKK on Flickr.</a></small></p>
				</div>
			</div>
			<div class="push"></div>
		</div>
		<div id="footer">
			&copy; 2011-2012 <a href="http://www.twitter.com/alasdairnorth">@alasdairnorth</a> | <a id="aboutLink" href="javascript:void(0);">about</a> | <a href="http://software.alnorth.com/">other projects</a>
		</div>
	</body>
</html>