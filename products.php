<?php
ob_start();
session_start();

$title = " | Products";

require_once 'inc/autoload.php';
require_once 'inc/header.php';

$productObj = new Product();
$results = $productObj->getAllProducts();

if ($_SESSION['signed_in'] == true) { 

?>
<body>
	<div style="position: absolute; background-color: lightgrey; width: 19%; text-align: center; border-radius: 5px;">
		<h1>Admin</h1>
		<strong><?php echo $_SESSION['a_user']; ?></strong><br>
		<hr>
		<br>
		<a href="products.php"><div class="background"><strong>Product management</strong></div></a><br>
		<a href="adm_management.php"><div class="background"><strong>Admin management</strong></div></a><br>
		<a href="logout.php"><div class="background"><strong>Logout</strong></div></a>
	</div>	
	<div style="float: right; background-color: grey; width: 80%; text-align: center; color: white; border-radius: 5px;">
		<h2>Products</h2>
		<a title="Add new" style="color: blue;" href="add_pro.php"><i style="font-size: 25px;" class="fas fa-plus"></i></a>
		<hr>
		<br>
		<form method="post">	
		<table>
			<tr>
			    <th>Image</th>
			    <th>Title</th>
			    <th>Price</th>
			    <th>Stock</th>
			    <th>Edit</th>
			    <th>Delete</th>
		    </tr>
		    <?php 
		    	if($results) {
		    		foreach($results as $result) {
		    ?>
						<tr>
							<td><img src="img/products/<?php echo $result['pro_img']; ?>"></td>
							<td><?php echo $result['pro_title']; ?></td>
							<td><?php echo $result['pro_price']; ?></td>
							<td><?php echo $result['pro_stock']; ?></td>
							<td><a href="edit_pro.php?pid=<?php echo $result['pro_id']; ?>"><i class="fas fa-pen-alt"></i></a></td>
							<td><a style="color: red;" href="delete_pro.php?pid=<?php echo $result['pro_id']; ?>"><i class="fas fa-trash-alt"></i></a></td>
						</tr>
			<?php 
					} 
				} 
			?>
		</table>
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