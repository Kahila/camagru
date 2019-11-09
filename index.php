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

<?php 
}else{
	echo '<p><a href="login.php">Log in</a> or  <a href="register.php">Register </a> </p>';
}
?>
<!-- 
// echo $user->data()->username;
// $otheruser = new User(1);//outher user at id 1
//echo Session::get(config::get('session/session_name')); -->
