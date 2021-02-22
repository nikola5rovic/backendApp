<?php
	session_start();
	unset($_SESSION['a_user']);
	unset($_SESSION['signed_in']);
	unset($_SESSION['a_img']);
	unset($_SESSION['a_id']);
	session_destroy();
	header("Location: index.php");
?>