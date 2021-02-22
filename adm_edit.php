<?php
ob_start();
session_start();

$title = " | Edit Admin";

require_once 'inc/autoload.php';
require_once 'inc/header.php';
require_once 'inc/bodyleft.php'; 
require_once 'inc/bodyright_admin.php';

$adminObj = new Admin();

$aid = $_GET["aid"];
$url = $_SERVER['REQUEST_URI'];

$results = $adminObj->getAdmin($aid);

if (isset($_POST['admUpdate'])) {
	$adminObj->updtAdmin($aid, $_FILES['admImg']['name'], $_POST['admEmail'], $_POST['admPass'], $_POST['admName']);
} 
?>
<body>
<?php
//Security check for non-logged users
if ($_SESSION['signed_in'] == true && parse_url($url, PHP_URL_QUERY) == null) {
	header("Location: products.php");
} elseif ($_SESSION['signed_in'] == true && parse_url($url, PHP_URL_QUERY) == "aid=".$aid) { 
	if($results) {
		foreach($results as $result) { 
?>
			<tr>
				<td><img src="img/admins/<?php echo $result['admin_picture'] ?>"><input type="file" name="admImg"><small style="float: left;">*Change it or not</small></td>
				<td><input type="email" name="admEmail" value="<?php echo $result['admin_email']; ?>" required><small style="float: left;">*This is a required field</small></td>
				<td><input type="password" name="admPass" value="<?php echo $result['admin_password']; ?>" required><small style="float: left;">*This is a required field</small></td>
				<td><input type="text" name="admName" value="<?php echo $result['admin_name']; ?>"><small style="float: left;">*Change it or not</small></td>
			</tr>
<?php
		} 
	} 
?>
		</table>
		<input type="submit" name="admUpdate" value="Update">
		</form>
	</div>
<?php 
} else {
	header("Location: index.php");
}

unset($adminObj);
?>
</body>
</html>