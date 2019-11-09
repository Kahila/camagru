<?php
require_once 'core/init.php';

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if (isset($_POST['submit'])){
	$file = $_FILES['file'];
	//print_r($file);
	$fileName = $_FILES['file']['name'];
	$fileTmpName= $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));
	$allowed = array('jpg', 'jpeg', 'png');

	try {
		// $conn = new mysqli("localhost", "root", "123456");
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
		if ($conn) echo "Connection successful <br/>";
		if (in_array($fileActualExt, $allowed)){
			if (!$fileError){
				if ($fileSize < 3000000){
					$fileNameNew = uniqid('', true).".".$fileActualExt;
					$fileDestination = 'uploads/'.$fileNameNew;
					$image = new User();
					//print_r($this->_data);
					$image->upload_image(array(
						'user_id' => $image->data()->id,
						'image_name' => $fileNameNew
					));
					//$images = new User();
					//echo $images->get_images();
					//get_images();
					$query = "SELECT * FROM camagru.images";
					$stmt = $conn->prepare($query);
					$stmt->execute();
					// $name =  ($conn->query($query));
					$count = $stmt->rowCount();
					echo "num image = " . $count . "<br/>";
					// print_r ($name->fetch_All_assoc());
					$res = $stmt->fetchAll();
					// print_r($res);
					foreach ($res as $image) {
						$ima = $image['image_name'];
						//echo "uploads/".$ima."<br>";
						echo "<html>
							<img src='uploads/$ima' legth='=30%' width='30%'></img>
						</html>
						";
					}
					//print_r ($name->fetch_assoc());
					move_uploaded_file($fileTmpName, $fileDestination);
					echo "<li><a href='image_upload.php'>BAck to Home</a></li>";
					//header("location: image_upload.php");
				}else{
					echo "file size is too big";
				}
			}else{
				echo "error uploading";
			}
		}else{
			echo 'invalid file';
	}
}
	catch(PDOException $ex) {
		echo "ERROR: " . $ex->getMessage() . "<br/>";
	}
}
?>