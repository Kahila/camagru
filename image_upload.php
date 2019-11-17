<?php
	require_once 'core/init.php';
	echo "
        <html>
            <body style = 'background-color:gray; text-align:center;'>
            </body>
        </html>
        ";
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
	<!-- <link rel="stylesheet" type="text/css" href="css/main.css"> -->
<a href='logout.php'><button >Logout</button></a>
</head>
<body>
	<h1 style="text-align: center;">Upload Image</h1>
	<a href="index.php"><button style="width: 100px; background-color: green; float: left;">Home</button> </a>
	<form action="upload.php" method="post" enctype="multipart/form-data" style="text-align: center;"> 
		<input type="file" name="file">
		<button type="submit" name="submit" style="width: 200px;">Upload</button>
	</form>
	<a href="delete.php"><button style="width: 200px;">DELETE IMAGES</button></a><br><br>
</body>
</html>

<?php
require_once 'core/init.php';

$user = new User();
if ($user->isLoggedIn()){
        $id = $user->data()->id;
    try {
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
		// if ($conn) echo "Connection successful <br/>";
            $query = "SELECT * FROM camagru.images WHERE user_id=$id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            echo "<h3>you have " . $count . " images that are uploaded by you</h3><br/>";
            $res = $stmt->fetchAll();
            foreach ($res as $image) {
                $ima = $image['image_name'];
                echo "
                        <style type='text/css'> img{ height: 200px; width: 200px;}</style>
                        <button type='submit'><img src='uploads/$ima' name='$ima' legth='=30%' width='30%' border='8px solid black'><h3>name $ima<h3></img></button></a>
                ";
            }
}catch(PDOException $ex) {
	echo "ERROR: " . $ex->getMessage() . "<br/>";
}
}else{
    header("location: includes/404.php");
}
?>