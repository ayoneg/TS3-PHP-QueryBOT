<?php
	date_default_timezone_set('Europe/Warsaw');
	$mysqli = @new mysqli('localhost', '', '', '');
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
?>
