<?php
require_once 'core/init.php';

if (input::exists()) {
    if (token::check(input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                //'name' => 'username'
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users',
            ),
            'password' => array(
                'required' => true,
                'min' => 6,
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password',
            ),
            'name' => array(
                'required' => true,
                'min' => '2',
                'max' => 50,
            ),
            'email' => array(
                'required' => true,
                'unique' => 'users'
            )
        ));

        if ($validation->passed()) {
        	$user = new User();
        	$salt = Hash::salt(32);
            $code = str_shuffle("1234567890-+=~abcdefABCDEFghijklmnopqrstuvwxyzGHIJKLMNPOQRSTUVWXYZ!@#$%^&*()?><:");     
            try {
                $user->create(array(
                    'username' => input::get('username'),
                    'password' => Hash::make(input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'grp' => 1,
                    'email' => input::get('email'),
                    'confirmed' => substr($code, 0, 5)
                ));
                //echo "here.....";
                echo substr($code, 0, 5);
                Session::flash('home', 'Congratulations You Have Been Registered ...>>>>>>>| Remember to Verify Email in Order To Sign In |<<<<<<<<<<');
                header('location: index.php');
               // echo "here////";

               // $msg = wordwrap("You have succesfully registered to camagru, in order to register 
               // please copy and paste the verification code provided to you onto the register page");
               //  mail("adonis7121@gmail.com", "Camagru verification", $msg, "akalomob@student.wethinkcode.co.za");

                $to = "adonis7121@gmail.com";
                $subject = "Email Verification";
                $message =  " click this link!<a href = 'http://localhost:8888/Web_Application/verify.php?vkey=$vkey'>Register Account</a>";
                $headers = "From:noreply@localhost:8080 \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                if (mail($to,$subject,$message,$headers))
                {
                  echo ("success");
                }
                else {
                  echo("Fail");
                }

              // redirect::go_to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo '<i>' . $error . '</i>', '<br>';
            }
            echo '<br>';
        }
    }
}
?>

<html>
<head>
	<title>Sign Up Page</title>
	<style type="text/css">
		i{
			color: red;
			text-align: center;
		}
		img{
			width: 20%;

		}
		body{
			//background-color: grey;
			background-image: url("webimages/1920x1080 canon background download.jpg");
            background-size: cover;

		}label{
			//color: green;
		}
		.register{
			text-align: center;
			padding-top: 10%;
		}input{
			width: 20%;
			height: 3%;
            border-radius: 25px;
		}
		.field{
			padding-top: 20px;
		}
	</style>
</head>
<body >
    <br><a href="index.php" ><button style="width: 10%;border-radius: 25px;height: 3%; background-color: grey;">HOME</button></a>
	<form action="" method="post" class="register">
		<!-- <img src="webimages/hxf_04 by Elijah Porter.png -->
		<div class="field">
			<lebel for="username" >Username</lebel><br>
			<input type="text" placeholder="Username" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"><!-- using escape function to sanitize data -->
		</div>
		<div class="field">
			<label for="password">Password</label><br>
			<input type="password" name="password" id="password" placeholder="Create Password">
		</div>
		<div class="field">
			<label for="password repeat">Repeat Password</label><br>
			<input type="password" name="password_again" id="password_again" placeholder="Repeat Password">
		</div>
		<div class="field">
			<label for="name">Name</label><br>
			<input type="text" name="name" id="name" placeholder="Name" value="<?php echo escape(Input::get('name')); ?>">
		</div>
		<div class="field">
			<label for="email">Email</label><br>
			<input type="email" name="email" id="email" placeholder="Email address" value="<?php echo escape(Input::get('email')); ?>">
		</div>
		<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
		<br><input type="submit" name="Register" style="background-color: grey "><br>
	</form>
</body>
</html>
