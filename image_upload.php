<?php
	require_once 'core/init.php';

	$user = new User();
	if (!$user->isLoggedIn()){
		redirect::go_to('index.php');
	}
 ?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data"> 
	<input type="file" name="file">
	<button type="submit" name="submit">Upload</button><br>
	<li><a href="index.php">BAck to Home</a></li>
	<li><a href="galary.php">View Galary</a></li>
</form>
</body>
</html>