<?php  
	spl_autoload_register('autoloader');

	function autoloader($className) {
		$path = "classes/";
		$extension = ".class.php";
		$fullPath = $path.$className.$extension;

		include_once $fullPath;
	}
?>