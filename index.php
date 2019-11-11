<?php
require_once 'core/init.php';

if (Session::exists('home')){
	echo '<p>'.Session::flash('home').'</p>';
}
$user = new User();//current user
if ($user->isLoggedIn()){
?>
<html><!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <div class="bg-text">
        <h1 style="text-align: center;">Welcome <?php echo escape($user->data()->username)?> </h1>
    </div>
    <a href="logout.php"><button style="background-color: red; float: right; width: 100px">Log out</button></a><br>
    <div class="index">
         <ul>   
            <a href="update.php"><button >Update Details</button></a><br>
            <a href="changepassword.php"><button >Change Password</button></a><br>
            <a href="image_upload.php"><button >Image Management</button></a><br>
            <a href="capture.php"><button >Capture Image</button></a><br>
            <a href="galary.php"><button >MY GALARY</button></a>
         </ul>
    </div>  
</head>
<body >
</body>
</html>

<?php 
}else{
	echo "<a href='login.php'><button >Log in</button'></a><a href='register.php'><button>Register</button></a><br><br><br><br><br><br>";

	$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "root");
		// if ($conn) echo "Connection successful <br/>";
            $query = "SELECT * FROM camagru.images";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            // echo "num image = " . $count . "<br/>";
            $res = $stmt->fetchAll();
            foreach ($res as $image) {
                $ima = $image['image_name'];
                echo "<html>
                        <style type='text/css'> img{ height: 200px; width: 200px;}</style>
                        <img src='uploads/$ima' legth='=200px' width='200px' border='5px solid black'></img>
                    </html>
                ";
            }
		}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HELLO</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

</body>
</html>
<!-- 
// echo $user->data()->username;
// $otheruser = new User(1);//outher user at id 1
//echo Session::get(config::get('session/session_name')); -->
