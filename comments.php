<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
echo "<a href='galary.php'><button>GALARY</button></a>";
require_once 'core/init.php';
$filename = $_GET['filename'];

$name = null;
if (isset(($_POST['new']))){
	$name = $_POST['new'];
}

$query = "SELECT * FROM images WHERE image_name='$filename'";
$stmt = $conn->prepare($query);
$stmt->execute();
$res = $stmt->fetchAll();

//print_r ($res);
//$likes = 0;
foreach($res as $like){
	$likes = $like['likes'];
}

//$likes;
if (isset($_POST['like'])){
	$likes++;
	$query = "UPDATE `images` SET `likes` = '$likes' WHERE `images`.`image_name` = '$filename'";
	$stmt = $conn->prepare($query);
    $stmt->execute();
	//echo $likes;
}

$user = new User();
if ($name){
	 $user->upload_comment(array(
		 'image_id' => $filename,
		 'comment' => $name
	 ));}
	 echo "<h1 style='text-align:center;'>comments</h1><br>
	 		<body style='background-image:url(uploads/$filename);background-size: cover;background-repeat: no-repeat;'>
	 "
?>
<!DOCTYPE html>
<html>
<head>
	<title>coments</title>
</head>
<body style="background-color: grey;">
	<form method="post">
		<textarea type="text" name="new" placeholder="input new coment here" style="width: 200px; height: 200px;"></textarea><br>
		<button type="submit" name="submit">Submit</button><br>
		<button type="submit" name="like">like image</button>
	</form>
	
</body>
</html>
<?php
	$query = "SELECT * FROM camagru.comments WHERE image_id='$filename'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$count = $stmt->rowCount();
	$res = $stmt->fetchAll();
	echo $count, " coments";
	echo "<form action='' style='text-align:center;'>";
	foreach($res as $comment){
		$ima = $comment['comment'];
		echo "
				<textarea type='text' readonly='readonly' name='coments' style='width: 120px; 	height: 120px; text-align:center; background-color: orange;'>
				$ima</textarea>
		";
	 }
	echo "</form>";
	
?>