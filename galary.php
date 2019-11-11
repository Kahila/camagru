<?php
require_once 'core/init.php';

$user = new User();
if ($user->isLoggedIn()){
        $id = $user->data()->id;
        echo "<h1 style= 'text-align: center; padding-bottom: 30px;'>GALARY</h1>";
        echo "<a href='index.php'><button>HOME</button></a><br><br>";
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
                        <style type='text/css'> img{ height: 200px; width: 200px;}</style>
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

<!DOCTYPE html>
<html>
<head>
    <title>Galary</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

</body>
</html>