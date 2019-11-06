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
            ),
        ));


        if ($validation->passed()) {
        	$user = new User();


        // echo $salt = Hash::salt(10);
        // // echo $salt;
        // die();

        	 $salt = Hash::salt();
                  
            try {
                $user->create(array(
                    'username' => input::get('username'),
                    'password' => Hash::make(input::get('password'), $salt),
                    'salt' => $salt,
                    'name' => input::get('name'),
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1
                ));

                //echo "here.....";
               Session::flash('home', 'you have been registered. Have fun!');
               //header('location: index.php');
               // echo "here////";
               redirect::go_to('index.php');

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

		}label{
			//color: green;
		}
		.register{
			text-align: center;
			padding-top: 10%;
		}input{
			width: 20%;
			height: 3%;
		}
		.field{
			padding-top: 20px;
		}
	</style>
</head>
<body >
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
		<br><input type="submit" name="Register" style="background-color: grey ">
	</form>
</body>
</html>
