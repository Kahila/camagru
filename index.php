<?php
require_once 'core/init.php';

if (Session::exists('home')){
	echo '<p>'.Session::flash('home').'</p>';
}

$user = new User();//current user
if ($user->isLoggedIn()){
	echo "logged in";
?>

<p>Welcome <a href= '#'><?php echo escape($user->data()->username); ?>!</p>

	<ul>
		<li><a href="logout.php">Log out</a></li>
		<li><a href="update.php">Update Details</a></li>
		<li><a href="changepassword.php">Change Password</a></li>
		<li><a href="image_upload.php">Upload Image</a></li>
		<li><a href="capture.php">Capture Image</a></li>

<?php 
}else{
	echo '<p><a href="login.php">Log in</a> or  <a href="register.php">Register </a> </p>';

	$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
		if ($conn) echo "Connection successful <br/>";
            $query = "SELECT * FROM camagru.images";
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
		}
?>
<!-- 
// echo $user->data()->username;
// $otheruser = new User(1);//outher user at id 1
//echo Session::get(config::get('session/session_name')); -->
