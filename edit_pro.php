<?php 
ob_start();
session_start();

$title = " | Edit product";

require_once 'inc/autoload.php';
require_once 'inc/header.php';
require_once 'inc/bodyleft.php';
require_once 'inc/bodyright_pro.php';

$producObj = new Product();

$pid = $_GET["pid"];
$url = $_SERVER['REQUEST_URI'];

$results = $producObj->getProduct($pid);

if (isset($_POST['proUpdate'])) {
	$producObj->updtProduct($pid, $_FILES['proImg']['name'], $_POST['proTitle'], $_POST['proPrice'], $_POST['proStock']);
} 
?>
<body>
<?php
if ($_SESSION['signed_in'] == true && parse_url($url, PHP_URL_QUERY) == null) {
	header("Location: products.php");
} elseif ($_SESSION['signed_in'] == true && parse_url($url, PHP_URL_QUERY) == "pid=".$pid) { 
	if($results) {
		foreach($results as $result) { 
?>
			<tr>
				<td><img src="img/products/<?php echo $result['pro_img']; ?>"><br><input type="file" name="proImg"></td>
				<td><input style="width: 150px; border: none; border-radius: 3px;" type="text" name="proTitle" value="<?php echo $result['pro_title']; ?>"></td>
				<td><input class="price" type="text" name="proPrice" value="<?php echo $result['pro_price']; ?>"></td>
				<td><input class="price" type="text" name="proStock" value="<?php echo $result['pro_stock']; ?>"></td>
			</tr>
<?php 
		} 
	} 
?>
		</table>
		<input type="submit" name="proUpdate" value="Update">
		</form>
	</div>
<?php 
} else {
	header("Location: index.php");
}

unset($db);
?>
</body>
</html>