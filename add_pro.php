<?php  
ob_start();
session_start();

$title = " | Add Products";

require_once 'inc/autoload.php';
require_once 'inc/header.php';
require_once 'inc/bodyleft.php';
require_once 'inc/bodyright_pro.php';

$productObj = new Product();	

if(isset($_POST['proAdd'])) {
	$productObj->addProduct($_FILES['addImg']['name'], $_POST['addTitle'], $_POST['addPrice'], $_POST['addStock']);
}
?>
<body>
<?php
if ($_SESSION['signed_in'] == true) {
?>
			<tr>
				<td><input style="width: 200px;" type="file" name="addImg"></td>
				<td><input style="width: 150px; border: none; border-radius: 3px;" type="text" name="addTitle"></td>
				<td><input class="price" type="text" name="addPrice"></td>
				<td><input class="price" type="text" name="addStock"></td>
			</tr>
		</table>
		<input type="submit" name="proAdd" value="Publish">
		</form>
	</div>
<?php 
} else {
	header("Location: index.php");
}

unset($productObj);
?>
</body>
</html>