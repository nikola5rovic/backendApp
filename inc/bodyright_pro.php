<?php
	$uri = $_SERVER['REQUEST_URI'];
	$url =explode("/", $uri);

	if (in_array("inc", $url)) {
	    header("Location: ../products.php");
	}
?>
<div style="float: right; background-color: grey; width: 80%; text-align: center; color: white; border-radius: 5px;">
	<h2>Products</h2>
	<hr>
	<br>
	<form method="post" enctype="multipart/form-data">
	<table>
		<tr>
		    <th>Image</th>
		    <th>Title</th>
		    <th>Price</th>
		    <th>Stock</th>
	    </tr>