<?php
	require_once 'core/init.php';

	$user = new User();
	if (!$user->isLoggedIn()){
		redirect::go_to('index.php');
	}
 ?>

 <!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		img{
			height: 200px;
			width: 200px;
		}
	</style>
	<title>Uploads</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<a href="index.php"><button style="width: 100px; background-color: red;">Home</button> </a>
	<h1 style="text-align: center;">Upload Image</h1>
	<form action="upload.php" method="post" enctype="multipart/form-data" style="text-align: center;"> 
		<input type="file" name="file"><br><br>
		<button type="submit" name="submit" style="width: 200px;">Upload</button><br><br>
	</form>
</body>
</html>

<?php
require_once 'core/init.php';

$user = new User();
if ($user->isLoggedIn()){
        $id = $user->data()->id;
    try {
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "root");
		// if ($conn) echo "Connection successful <br/>";
            $query = "SELECT * FROM camagru.images WHERE user_id=$id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            echo "num image = " . $count . "<br/>";
            $res = $stmt->fetchAll();
            foreach ($res as $image) {
                $ima = $image['image_name'];
                echo "<html>
                        <img src='uploads/$ima' legth='=200px' width='200px' border='5px solid black'></img>
                    </html>
                ";
            }
}catch(PDOException $ex) {
	echo "ERROR: " . $ex->getMessage() . "<br/>";
}
}else{
    header("location: includes/404.php");
}
?>