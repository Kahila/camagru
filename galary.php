<?php
require_once 'core/init.php';

$page_num = $_GET['pagenum'] ;
if (!$page_num){
    $page_num = 1;
}

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
                        <style type='text/css'> img{ height: 200px; width: 200px;}</style>
                            <button type='submit'>
                                <img src='uploads/$ima' name='$ima' legth='=30%' width='30%' border='8px solid black'>
                                    <h3>name $ima<h3>
                                    <h3>likes: <h3>
                                    <a href='comments.php'>Coments</a>
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
            // UPDATE `images` SET `likes` = '0' WHERE `images`.`image_name` = '635097.jpg'
            // foreach ($res as $image) {
            //     $ima = $image['image_name'];
            //     if(isset($ima)){
            //         echo "$ima is set";
            //         //break;
            //     }
            // }
            // $query = "INSERT ";
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
                        <style type='text/css'> img{ height: 200px; width: 200px;}</style>
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