<?php  
ob_start();
session_start();

$title = " | Delete Admin";

require_once 'inc/autoload.php';
require_once 'inc/header.php';

$adminObj = new Admin();

$aid = $_GET['aid'];
$url = $_SERVER['REQUEST_URI'];

if(isset($_POST['delete'])) {
	$adminObj->delAdmin($_POST['id']);
	$adminObj->ifAdminExists($_SESSION['a_user']);
}
?>
<body>
<?php  
if ($_SESSION['signed_in'] == true && parse_url($url, PHP_URL_QUERY) == null) {
	header("Location: adm_management.php");
} elseif($_SESSION['signed_in'] == true && parse_url($url, PHP_URL_QUERY) == "aid=".$aid) {
?>
	<center>
		<div style="background-color: lightgrey;">
			<strong>Confirm!</strong> Do you want to delete this account?<br><br>
	        <a style="border: 1px solid black; padding: 6px; border-radius: 5px;" href="adm_management.php">No, Thanks</a><br>
	        <form method="post" action="adm_delete.php">
	            <input type="hidden" value="<?php echo $aid; ?>" name="id" /><br>
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