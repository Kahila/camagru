<?php
require_once 'core/init.php';

ini_set('display_errors', 'off');

$page_num = $_GET['pagenum'] ;
if (!$page_num){
    $page_num = 1;
}

echo '<a href="logout.php"><button >Logout</button></a>';
$i = 0;
$user = new User();
$nextpg = $page_num+1;
$prevpg = $page_num-1;
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
        $amount = 6;
        $start = ($page_num - 1) * $amount ;
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
		// if ($conn) echo "Connection successful <br/>";
            $query = "SELECT * FROM camagru.images ORDER BY id DESC LIMIT  $start , $amount";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            $likes = 0;
            
            if ($page_num >= 2)
                echo "<a href='galary.php?pagenum=$prevpg'><-PREV<a/><br/>";
            if ($count >= $amount)
                echo "<a href='galary.php?pagenum=$nextpg'>NEXT |-><a/><br/>";

            $res = $stmt->fetchAll();
            $i = 0;
            foreach ($res as $image) {
                $ima = $image['image_name'];

                $query = "SELECT * FROM images WHERE image_name='$ima'";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                $l = $stmt->fetchAll();
                
                foreach($l as $like){
                	$likes = $like['likes'];
                }
                echo "
                        <style type='text/css'> img{ height: 250px; width: 250px; }</style>
                            <button type='submit'>
                                <img src='uploads/$ima' name='$ima' legth='=30%' width='30%' border='8px solid black'>
                                    <h3>name $ima<h3>
                                    <h3>likes: $likes<h3>
                                    <a href='comments.php?filename=$ima'>Coment OR Like</a>
                                </img>
                        </button></a>      
                ";
                if($i == 2){
                        echo '<br>';
                        $i = -1;
                    }
                $i++;
            }
            $c = 0;
}catch(PDOException $ex) {
	echo "ERROR: " . $ex->getMessage() . "<br/>";
}
}else{
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
        $amount = 6;
        $start = ($page_num - 1) * $amount ;
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
            $query = "SELECT * FROM camagru.images LIMIT  $start , $amount";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            $likes = 0;
            
            if ($page_num >= 2)
                echo "<a href='galary.php?pagenum=$prevpg'><-PREV<a/><br/>";
            if ($count >= $amount)
                echo "<a href='galary.php?pagenum=$nextpg'>NEXT |-><a/><br/>";

            $res = array_reverse($stmt->fetchAll());
            $i = 0;
            foreach ($res as $image) {
                $ima = $image['image_name'];
                echo "
                        <style type='text/css'> img{ height: 250px; width: 250px;}</style>
                            <button type='submit'>
                               <img src='uploads/$ima' name='$ima' legth='=30%' width='30%' border='8px solid black'>
                                </img>
                        </button></a>      
                ";
                if($i == 2){
                        echo '<br>';
                        $i = -1;
                    }
                $i++;
            }
            $c = 0;
}catch(PDOException $ex) {
	echo "ERROR: " . $ex->getMessage() . "<br/>";
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