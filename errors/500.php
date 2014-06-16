<?php header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>500 Error: SocialCite</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="head">
				<div id="head-tint" class="tint-darker">
						<h1>SocialCite</h1>
					<a href="http://www.lawtonsoft.com/"><p>Open Source Solutions</p></a>
				</div>
			</div>
			<div id="body">
				<h2>Indy 500</h2>
				<p>Car crash on the track. Please excuse the mess!...</p>
				<p>
			</div>
			<div id="foot">
				<p>SocialCite &copy; <?php date_default_timezone_set('UTC'); echo date("Y"); ?>, All Right Reserved</p>
			</div>
		</div>
	</body>
</html>
