<?php
require_once 'core/init.php';

$user = new User();
if ($user->isLoggedIn()){
       $id = $user->data()->id;
        echo "<h1 style= 'text-align: center; padding-bottom: 30px;'>IMAGE DELETION</h1>";
        echo "<a href='index.php'><button>HOME</button></a> <br><br>";
        echo "
        <html>
	        <body style = 'background-color:gray; text-align:center;'>
	        	<form class='del' method='post'>
					<label for='name'>Delete image</label><br>
					<input type='text' name='text' id='text' placeholder='file name'>
					<br><input type='submit' name='submit' style='background-color: grey'><br>
				</form>
			</body>
		</html>
        ";
    try {
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
		// if ($conn) echo "Connection successful <br/>";
            $query = "SELECT * FROM camagru.images WHERE user_id=$id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            echo "num image = " . $count . "<br/>";
            $res = array_reverse($stmt->fetchAll());
            //$arr = array();
            foreach ($res as $image) {
                $ima = $image['image_name'];
                $nme = substr($ima, 0, 6);
                echo "
                        <style type='text/css'> img{ height: 200px; width: 200px;}</style>
                        <button type='submit'><img src='uploads/$ima' name='$ima' legth='=30%' width='30%' border='18px solid black'><h3>name $ima<h3></img></button></a>
                ";
            }
		if (isset($_POST['submit'])){
		//echo input::get('text');
		$found = 0;
		foreach ($res as $key) {
			$ima = $key['image_name'];
			if (strcmp($ima, input::get('text')) == 0){
				$query = "DELETE FROM camagru.images WHERE image_name='$ima'";
				$stmt = $conn->prepare($query);
	            $stmt->execute();
	            $found++;
			}
		}
	}
		}catch(PDOException $ex) {
		echo "ERROR: " . $ex->getMessage() . "<br/>";
	}
}else{
    header("location: includes/404.php");
}
?>