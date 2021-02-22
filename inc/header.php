<?php
	$uri = $_SERVER['REQUEST_URI'];
	$url =explode("/", $uri);

	if (in_array("inc", $url)) {
	    header("Location: ../products.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard <?php echo $title; ?></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/9222cf74af.js" crossorigin="anonymous"></script>
	<!-- Custom css -->
	<link rel="stylesheet" href="css/style.css">	
</head>
