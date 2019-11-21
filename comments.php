<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

echo '<a href="logout.php"><button >Logout</button></a>';
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

foreach($res as $like){
	$likes = $like['likes'];
}

//$likes;
if (isset($_POST['like'])){
	$likes++;
	$query = "UPDATE `images` SET `likes` = '$likes' WHERE `images`.`image_name` = '$filename'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
}

$user = new User();
if ($name){
	 $user->upload_comment(array(
		 'image_id' => $filename,
		 'comment' => $name
	 ));}
	 echo "<h1 style='text-align:center;'>comments</h1><br>
	 		<body style='background-image:url(uploads/$filename);background-size: cover;background-repeat: no-repeat;'>
	 ";

		$query = "SELECT * FROM images WHERE image_name='$filename'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$res = $stmt->fetchAll();
	foreach($res as $id){
		$likes = $id['user_id'];
	}
		//echo "///|$likes|/////";
		$query = "SELECT * FROM users WHERE id='$likes'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$res = $stmt->fetchAll();
	foreach($res as $email){
		$em = $email['email'];
	}
		$query = "SELECT * FROM users WHERE id='$likes'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$res = $stmt->fetchAll();
	foreach($res as $email){
		$send = $email['email_n'];
	}
	if ($send == 'on'){
		 
                //$code = $user->login(input::get('confirmed'));
                $to = $em;
                $subject = "Your Image has been liked";
                $message =  "One of your images have been liked";
                $headers = "From:noreply@localhost:8080 \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
				//echo "sent";
                if (mail($to,$subject,$message,$headers))
                {
                  echo ("success");
                }
                else {
                  echo("Fail");
                }
	}
		//echo ($send);
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