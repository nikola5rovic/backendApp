<?php  
class Admin extends Database {
	private $id;
	private $image;
	private $email;
	private $password;
	private $name;
	private $uniqueAdm;
	private $admCheck;

	private $errMsg;
	public $regexEmail = "/^(?!.*\.\.)[\w.\-#!$%&'*+\/=?^_`{}|~]{1,35}@[\w.\-]{1,15}\.[a-zA-Z]{2,15}$/";
	public $regexPass = "/\S*(?=\S{11,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\W])(?=\S*[\d])\S*$/";

	public function logAdmin($email, $password) {
		//Authenticate credentials
		$this->logAuth($email, $password);

		//If authentication is Ok user is logged in
	    $sql = "SELECT * FROM admin WHERE admin_email=:aemail AND admin_password=:apass";
		$this->query($sql);
		$this->bindvalue(':aemail', $this->email);
    	$this->bindvalue(':apass', $this->password);
    	$admin = $this->fetchSingle();
		$res = $this->count();
		
    	if($res == 1) {
	    	$_SESSION['signed_in'] = true;
	        $_SESSION['a_user'] = $this->email;
	    	$_SESSION['a_img'] = $admin['admin_image'];
	        $_SESSION['a_id'] = $admin['admin_id'];

	        header("location:products.php");
	    }
	}

	// Method for fetching an Admin
	public function getAdmin($id) {
		$this->query("SELECT * FROM admin WHERE admin_id=:ADMID");
		$this->bindvalue(":ADMID", $id);
		return $this->fetchMultiple(); 
	}

	//Method to fetch all admins
	public function getAllAdmins() {
		$this->query("SELECT * FROM admin");
		return $this->fetchMultiple();
	}

	//Method for updating an Admin
	public function updtAdmin($id, $image, $email, $password, $name) {
		$this->logAuth($email, $password);
		
		$this->id = $id;
		$this->name = $name;

		if ($_FILES['admImg']['tmp_name'] == "") {
		$this->query("UPDATE admin SET admin_email=:ADMEMAIL, admin_password=:ADMPASS, admin_name=:ADMNAME WHERE admin_id=:ADMID");
		$this->bindvalue(":ADMID", $this->id);
		$this->bindvalue(":ADMEMAIL", $this->email);
		$this->bindvalue(":ADMPASS", $this->password);
		$this->bindvalue(":ADMNAME", $this->name);
		$this->execute();
		} else {
			$this->image = $image;
			$adm_tmp_img = $_FILES['admImg']['tmp_name'];
			move_uploaded_file($adm_tmp_img, "img/admins/$this->image");
			$this->query("UPDATE admin SET admin_picture=:ADMPIC, admin_email=:ADMEMAIL, admin_password=:ADMPASS, admin_name=:ADMNAME WHERE admin_id=:ADMID");
			$this->bindvalue(":ADMID", $this->id);
			$this->bindvalue(":ADMPIC", $this->image);
			$this->bindvalue(":ADMEMAIL", $this->email);
			$this->bindvalue(":ADMPASS", $this->password);
			$this->bindvalue(":ADMNAME", $this->name);
			$this->execute();
		}

		header("Location: adm_management.php");
	} 

	//Method for adding a new Admin
	public function addAdmin($image, $email, $password, $name) {
		$this->uniqueAdm($email);
		$this->logAuth($email, $password);

		if ($this->uniqueAdm == true && $this->admCheck == false) {} 
		else {
			//$this->email = $email;
			//$this->password = $password;
			$this->name = $name;

			$this->image = $image;
			$add_tmp_img = $_FILES['addImg']['tmp_name'];
			move_uploaded_file($add_tmp_img, "img/admins/$this->image");

			$this->query("INSERT INTO admin (admin_picture, admin_email, admin_password, admin_name) VALUES (:ADMIMG, :ADMEMAIL, :ADMPASS, :ADMNAME)");
			$this->bindvalue(":ADMIMG", $this->image);
			$this->bindvalue(":ADMEMAIL", $this->email);
			$this->bindvalue(":ADMPASS", $this->password);
			$this->bindvalue(":ADMNAME", $this->name);
			$run = $this->execute();
			
			if (isset($run)) {
				echo "<script>var confirm = confirm('Successfully Added! If you want to add more admins click OK');
					if(confirm == false) {
						window.open('adm_management.php', '_self');
					} else {
						window.open('adm_add.php', '_self');
					}
				</script>";
			}
		}
	}

	//Method for deleting an Admin
	public function delAdmin($id) {
		$this->id = $id;
		$this->query("DELETE FROM admin WHERE admin_id=:ADMID");
		$this->bindvalue(":ADMID", $this->id);
		$run = $this->execute();
	}

	//Check if admin exists method only for deleteing Admin
	public function ifAdminExists($email) {
		$this->email = $email;

		$this->query("SELECT * FROM admin WHERE admin_email=:ADMEMAIL");
		$this->bindvalue(':ADMEMAIL', $this->email);
		$this->fetchSingle();
		$ifExists = $this->count();
	
		if ($ifExists == 1) {
			header("Location: adm_management.php");
		} else {
			$_SESSION['signed_in'] = false;
			header("Location: logout.php");
		}
	}

	public function uniqueAdm($email) {
		$this->email = $email;

		$this->query("SELECT * FROM admin WHERE admin_email=:ADMEMAIL");
		$this->bindvalue(':ADMEMAIL', $this->email);
		$this->fetchSingle();
		$ifExists = $this->count();
	
		if ($ifExists == 1) {
			$this->uniqueAdm = true;
			echo "<script>alert('This email already exists. Email must be unique as a username!');
				window.open('adm_management.php','_self');
			</script>";
		}
	}

	//Mehod for authentication the Admins email and password
	public function logAuth($emailCheck, $passwordCheck) {
		if (!preg_match($this->regexEmail, $emailCheck) && !preg_match($this->regexPass, $passwordCheck)) {
			$this->admCheck = false;
			$errMsg = "<script>alert('The email & password are not valid');</script>";
			echo $errMsg;
			echo "<script>window.open('adm_management.php', '_self');</script>";
		} elseif (!preg_match($this->regexPass, $passwordCheck)) {
			$this->admCheck = false;
			$errMsg = "<script>alert('A password must contain minimum of lower & upper letter, special character, a number and be at least 11 charachters long!');</script>";
			echo $errMsg;
			echo "<script>window.open('adm_management.php', '_self');</script>";
		} elseif (!preg_match($this->regexEmail, $emailCheck)) {
			$this->admCheck = false;
			echo "<script>alert('The email format is not valid');</script>";
			echo "<script>window.open('adm_management.php', '_self');</script>";
		} elseif (preg_match($this->regexEmail, $emailCheck) && preg_match($this->regexPass, $passwordCheck)) {
			$this->password = md5($passwordCheck);
		    $this->email = $emailCheck;
			$this->query("SELECT * FROM admin WHERE admin_email=:aemail AND admin_password=:apass");
			$this->bindvalue(':aemail', $this->email);
    		$this->bindvalue(':apass', $this->password);
			$user = $this->fetchMultiple();

			if(!$user) {
				echo "<script>alert('User doesn\'t exist');</script>";
			} else {
				$this->admCheck = true;
				$this->password = md5($passwordCheck);
		    	$this->email = $emailCheck;
			}
		}
	}
}

?>