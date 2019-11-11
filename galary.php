<?php
require_once 'core/init.php';

$user = new User();
if ($user->isLoggedIn()){
       // $id = $user->data()->id;
        echo "<h1 style= 'text-align: center; padding-bottom: 30px;'>GALARY</h1>";
        echo "<a href='index.php'><button>HOME</button></a><br><br>";
        echo "
        <html>
            <body style = 'background-color:gray; text-align:center;'>
                <form class='del' method='post'>
                    <label for='name'>All Images</label><br>
                </form>
            </body>
        </html>
        ";
    try {
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "root");
		// if ($conn) echo "Connection successful <br/>";
            $query = "SELECT * FROM camagru.images";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            echo "num image = " . $count . "<br/>";
            $res = array_reverse($stmt->fetchAll());
            foreach ($res as $image) {
                $ima = $image['image_name'];
                echo "
                        <style type='text/css'> img{ height: 200px; width: 200px;}</style>
                            <button type='submit'>
                                <img src='uploads/$ima' name='$ima' legth='=30%' width='30%' border='8px solid black'>
                                    <h3>name $ima<h3>
                                    <h3>likes: <h3>
                                </img>
                        </button></a>
                ";
            }
}catch(PDOException $ex) {
	echo "ERROR: " . $ex->getMessage() . "<br/>";
}
}else{
    echo "
        <html>
            <body style = 'background-color:gray; text-align:center;'>
                <form class='del' method='post'>
                    <label for='name'><h1>Galary</h1></label><br>
                </form>
            </body>
        </html>
        ";
    $conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "root");
        // if ($conn) echo "Connection successful <br/>";
    echo "<a href='index.php'><button>HOME</button></a><br><br>";
            $query = "SELECT * FROM camagru.images";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            //echo "num image = " . $count . "<br/>";
            $res = array_reverse($stmt->fetchAll());
            foreach ($res as $image) {
                $ima = $image['image_name'];
                echo "
                        <style type='text/css'> img{ height: 200px; width: 200px;}</style>
                        <button type='submit'><img src='uploads/$ima' name='$ima' legth='=30%' width='30%' border='8px solid black'><h3>name $ima<h3></img></button></a>
                ";
            }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Galary</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/main.css"> -->
</head>
<body>

</body>
</html>