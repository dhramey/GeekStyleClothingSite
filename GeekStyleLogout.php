<?php
	session_cache_limiter('none');
	session_start();

	$_SESSION['ValidUser'] === false;
	session_unset();	//remove all session variables related to current session
	session_destroy();	//remove current session

	header('Location: ./GeekStyleIndex.php');
	exit();
?>