<?php
ob_start();
session_start();

$title = " | Admin Management";

require_once 'inc/autoload.php';
require_once 'inc/header.php';
require_once 'inc/bodyleft.php';

$adminObj = new Admin();
$results = $adminObj->getAllAdmins();
?>
<body>
<?php 
if ($_SESSION['signed_in'] == true) { 
?>
	<div style="float: right; background-color: grey; width: 80%; text-align: center; color: white; border-radius: 5px;">
		<h2>Admin List</h2>
		<a title="Add new" style="color: blue;" href="adm_add.php"><i style="font-size: 25px;" class="fas fa-user-plus"></i></a>
		<hr>
		<br>
		<form method="post" enctype="multipart/form-data">
		<table>
			<tr>
			    <th>Image</th>
			    <th>User Name</th>
			    <th>Admin Name</th>
			    <th>Edit Admin</th>
			    <th>Delete Admin</th>
		    </tr>
		<?php
			if($results) {
			    foreach($results as $result) {
		?>
					<tr>
						<td><img src="img/admins/<?php echo $result['admin_picture'] ?>"></td>
						<td><?php echo $result['admin_email']; ?></td>
						<td><?php echo $result['admin_name']; ?></td>
						<td><a href="adm_edit.php?aid=<?php echo $result['admin_id']; ?>"><i class="fas fa-pen-alt"></i></a></td>
						<td><a style="color: red;" href="adm_delete.php?aid=<?php echo $result['admin_id']; ?>"><i class="fas fa-trash-alt"></i></a></td>
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

unset($adminObj);
?>
</body>
</html>