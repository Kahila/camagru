<?php
require_once 'core/init.php';

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
				//$images = new DB();
				//echo $images->get_images();
				//get_images();
				move_uploaded_file($fileTmpName, $fileDestination);
				header("location: image_upload.php");
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
?>