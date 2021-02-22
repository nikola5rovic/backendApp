<?php 
    ob_start();
    session_start();

    $title = " | Login Page";

    require_once 'inc/autoload.php';
    require_once 'inc/header.php';

    $adminObj = new Admin();

    if (isset($_POST['submitAdmin'])) {
        $adminObj->logAdmin($_POST['email'], $_POST['password']);
    }    
?>
<body>
	<center>
		<h1>Login</h1>
		<form method="post">
			<input style="width: auto; border: none; border-radius: 3px; background-color: lightblue; height: 22px; padding-left: 1%;" type="email" placeholder="email" name="email"><br><br>
			<input style="width: auto; border: none; border-radius: 3px; background-color: lightblue; height: 22px; padding-left: 1%;" type="password" placeholder="password" name="password"><br><br>
			<input style="float: none; margin-left: 20px;" type="submit" name="submitAdmin" value="Enter">
		</form>
	</center>
</body>
</html>
<?php 
	unset($adminObj);
?>