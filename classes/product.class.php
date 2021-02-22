<?php  
class Product extends Database {
	private $id;
	private $image;
	private $title;
	private $price;
	private $stock;

	//Mehod for fetching all products
	public function getAllProducts() {
		$this->query("SELECT * FROM products");
		$run = $this->fetchMultiple();

		if (isset($run)) {
			return $run;
		} else {
			echo "<script>alert('Data could not be loded at this time. Try again later!');</script>";
		}
	}

	public function getProduct($id) {
		$this->query("SELECT * FROM products WHERE pro_id=:PROID");
		$this->bindvalue(":PROID", $id);
		$run = $this->fetchMultiple(); 

		if (isset($run)) {
			return $run;
		} else {
			echo "<script>alert('Data could not be loded at this time. Try again later!');</script>";
		}
	}

	public function addProduct($title, $price, $stock) {
		$this->title = $title;
		$this->price = $price;
		$this->stock = $stock;

		$this->image = $_FILES['addImg']['name'];
		$add_tmp_img = $_FILES['addImg']['tmp_name'];
		move_uploaded_file($add_tmp_img, "img/products/$this->image");

		$this->query("INSERT INTO products (pro_img, pro_title, pro_price, pro_stock) VALUES (:PROIMG, :PROTITLE, :PROPRICE, :PROSTOCK)");
		$this->bindvalue(":PROIMG", $this->image);
		$this->bindvalue(":PROTITLE", $this->title);
		$this->bindvalue(":PROPRICE", $this->price);
		$this->bindvalue(":PROSTOCK", $this->stock);
		$run = $this->execute();
		
		if (isset($run)) {
			echo "<script>var confirm = confirm('Successfully Added! If you want to add more items click OK');
				if(confirm == false) {
					window.open('products.php', '_self');
				} else {
					window.open('add_pro.php', '_self');
				}
			</script>";
		}
	}

	public function updtProduct($id, $image, $title, $price, $stock) {
		$this->id = $id;
		$this->title = $title;
		$this->price = $price;
		$this->stock = $stock;
		
		
		if ($_FILES['proImg']['tmp_name'] == "") {
			$this->query("UPDATE products SET pro_title=:PROTITLE, pro_price=:PROPRICE, pro_stock=:PROSTOCK WHERE pro_id=:PROID");
			$this->bindvalue(":PROID", $this->id);
			$this->bindvalue(":PROTITLE", $this->title);
			$this->bindvalue(":PROPRICE", $this->price);
			$this->bindvalue(":PROSTOCK", $this->stock);
			$run = $this->execute();

			if (!isset($run)) {
				echo "<script>alert('Something went wrong and data could not be edited at this time. Try again later!');</script>";
			}
		} else {
			$this->image = $_FILES['proImg']['name'];
			$pro_tmp_img = $_FILES['proImg']['tmp_name'];
			move_uploaded_file($pro_tmp_img, "img/products/$this->image");
			$this->query("UPDATE products SET pro_img=:PROIMG, pro_title=:PROTITLE, pro_price=:PROPRICE, pro_stock=:PROSTOCK WHERE pro_id=:PROID");
			$this->bindvalue(":PROID", $this->id);
			$this->bindvalue(":PROIMG", $this->image);
			$this->bindvalue(":PROTITLE", $this->title);
			$this->bindvalue(":PROPRICE", $this->price);
			$this->bindvalue(":PROSTOCK", $this->stock);
			$run = $this->execute();

			if (!isset($run)) {
				echo "<script>alert('Something went wrong and data could not be edited at this time. Try again later!');</script>";
			}
		}
		header("Location: products.php");
	}

	public function delProduct($id) {
		$this->id = $id;
		$this->query("DELETE FROM products WHERE pro_id=:PROID");
		$this->bindvalue(":PROID", $this->id);
		$run = $this->execute();

		if (!isset($run)) {
			echo "<script>var confirm = confirm('Something went wrong and product could not be deleted at this time. Clik Ok and return to products page!');
				if(confirm == false) {
					window.open('delete_pro.php', '_self');
				} else {
					window.open('products.php', '_self');
				}
			</script>";
		}

		header("Location: products.php");
	}
}

?>