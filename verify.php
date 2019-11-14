<?php

    require 'core/init.php';
    $user = new User();
    $conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
    $code = input::get('code');
    //echo $code;
    if (isset($_POST['submit'])){

        $query = "SELECT * FROM camagru.users WHERE confirmed='$code'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        //$count = $stmt->rowCount();
        $res = array_reverse($stmt->fetchAll());
        //print_r($res); 
        if ($res){
            $query = "UPDATE `users` SET `confirmed` = '0' WHERE `users`.`confirmed` = '$code'";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            header("location: index.php");
        }
    }
?>

<html>
    <head>
        <h1 style="text-align:center;"><i>Input The Code Sent To Your Email</i></h1>
        <title>verify acount</title>
    </head>
    <body style="background-image: url('webimages/1920x1080 canon background download.jpg'); background-size: cover;">
        <form action="" method="post" style="text-align:center; padding-top:100px; ">
            <label for="verify_code"><h3>Input Code</h3></label><br>
            <input type="password" name="code" placeholder="input code" style="width:200px;height: 25px; border-radius: 12px;"><br> 
            <button type='submit' name="submit">Submit</button>
        </form>
    </body>
</html>