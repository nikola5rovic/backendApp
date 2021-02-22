<?php  
ob_start();
session_start();

$title = " | Add Admin";

require_once 'inc/autoload.php';
require_once 'inc/header.php';
require_once 'inc/bodyleft.php';
require_once 'inc/bodyright_admin.php'; 

$adminObj = new Admin();	

if(isset($_POST['admAdd'])) {
	$adminObj->uniqueAdm($_POST['addEmail']);
	$adminObj->addAdmin($_FILES['addImg']['name'],  $_POST['addEmail'], md5($_POST['addPass']), $_POST['addName']);
}
?>
<body>
<?php 
if ($_SESSION['signed_in'] == true) { 
?>
			<tr>
				<td><input style="width: 200px;" type="file" name="addImg"></td>
				<td><input style="width: 130px; border: none; border-radius: 3px;" type="email" name="addEmail"></td>
				<td><input style="width: 130px; border: none; border-radius: 3px;" class="price" type="password" name="addPass"></td>
				<td><input style="width: 130px; border: none; border-radius: 3px;" class="price" type="text" name="addName"></td>
			</tr>
		</table>
		<input type="submit" name="admAdd" value="Publish">
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