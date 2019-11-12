<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");

require_once 'core/init.php';
$filename = $_GET['filename'];
$name = $_POST['coments'];

$user = new User();
if ($name){
	 $user->upload_comment(array(
		 'image_id' => $filename,
		 'comment' => $name
	 ));}
	 echo "<h1 style='text-align:center;'>comments</h1>"
?>
<!DOCTYPE html>
<html>
<head>
	<title>coments</title>
</head>
<body style="background-color: grey;">
	<form method="post">
		<textarea type="text" name="coments" placeholder="input new coment here" style="width: 200px; height: 200px;"></textarea><br>
		<button type="submit" name="submit">Submit</button><br>
	</form>
	
	
	</form>
</body>
</html>
<?php
	$query = "SELECT * FROM camagru.comments";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$count = $stmt->rowCount();
	$res = $stmt->fetchAll();
	echo $count;

	echo "<form action='' style='text-align:center;'>";
	foreach($res as $comment){
		echo "
				<textarea type='text' readonly='readonly' name='coments' placeholder='input new coment here' style='width: 200px; 	height: 200px; text-align:center;'>
				</textarea>
		";
	 }
	echo "</form>";
?>