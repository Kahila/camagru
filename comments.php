<?php



require_once 'core/init.php';
$filename = $_GET['filename'];
echo $filename;

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if (isset($_POST['submit'])){

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>coments</title>
</head>
<body style="background-color: grey;">
	<form method="post">
		<input type="form" name="coments" placeholder="input new coment here" style="width: 200px; height: 200px;"><br>
		<button type="submit" name="submit">Submit</button><br>
	</form>
</body>
</html>