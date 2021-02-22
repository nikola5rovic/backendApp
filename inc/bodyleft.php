<?php
	$uri = $_SERVER['REQUEST_URI'];
	$url =explode("/", $uri);

	if (in_array("inc", $url)) {
	    header("Location: ../products.php");
	}
?>
<div style="position: absolute; background-color: lightgrey; width: 19%; text-align: center; border-radius: 5px;">
	<h1>Admin</h1>
	<strong><?php echo $_SESSION['a_user']; ?></strong><br>
	<hr>
	<br>
	<a href="products.php"><div class="background"><strong>Product management</strong></div></a><br>
	<a href="adm_management.php"><div class="background"><strong>Admin management</strong></div></a><br>
	<a href="logout.php"><div class="background"><strong>Logout</strong></div></a>
</div>