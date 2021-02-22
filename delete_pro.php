<?php  
ob_start();
session_start();

$title = " | Delete Products";

require_once 'inc/autoload.php';
require_once 'inc/header.php';

$productObj = new Product();

$pid = $_GET['pid'];
$url = $_SERVER['REQUEST_URI'];

if(isset($_POST['delete'])) {
	$productObj->delProduct($_POST['id']);
}
?>
<body>
<?php  
if ($_SESSION['signed_in'] == true && parse_url($url, PHP_URL_QUERY) == null) {
	header("Location: products.php");
} elseif($_SESSION['signed_in'] == true && parse_url($url, PHP_URL_QUERY) == "pid=".$pid) {
?>
	<center>
		<div style="background-color: lightgrey;">
			<strong>Confirm!</strong> Do you want to delete this item?<br><br>
	        <a style="border: 1px solid black; padding: 6px; border-radius: 5px;" href="products.php">No, Thanks</a><br>
	        <form method="post" action="delete_pro.php">
	            <input type="hidden" value="<?php echo $pid; ?>" name="id" /><br>
	            <input style="float: none; margin-left: 17px; background-color: red" type="submit" name="delete" value="Yes, Delete" />
	        </form>
	    </div>
	</center>
<?php 
} else {
	header("Location: index.php");
}

unset($db);
?>
</body>
</html>
