<?php
require_once 'core/init.php';

$user = new User();
if ($user->isLoggedIn()){
	echo "logged in\n";
        $id = $user->data()->id;
        echo $id."<br/>";
        echo "<li><a href='image_upload.php'>Back To Upload</a></li>";
    try {
		// $conn = new mysqli("localhost", "root", "123456");
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
		if ($conn) echo "Connection successful <br/>";
            $query = "SELECT * FROM camagru.images WHERE user_id=$id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            echo "num image = " . $count . "<br/>";
            $res = $stmt->fetchAll();
            foreach ($res as $image) {
                $ima = $image['image_name'];
                echo "<html>
                        <img src='uploads/$ima' legth='=30%' width='30%' border='18px solid black'></img>
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