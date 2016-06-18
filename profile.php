<?php
	session_start();
	$user = $_SESSION['user'];
	if (!isset($user)) {
		die("You didn't log in!");
	}
?>
