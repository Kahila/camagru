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
            <a href="camera.php"><button >Capture Image</button></a><br>
            <a href="galary.php"><button >GALARY</button></a>
         </ul>
    </div>  
</head>
<body >
</body>
</html>

<?php 
}
else{
    echo "
            <h1 style='text-align: center;'>CaMaGrU</h1><br><br><br>
    <a href='login.php'><button>Log In</button></a> <br>  <a href='register.php'><button>Register</button></a>
            <br><a href='galary.php'><button>View GAalary</button></a>
    ";
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

