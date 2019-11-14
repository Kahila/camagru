<?php
require_once 'core/init.php';


	if (input::exists()){
		if (token::check(input::get('token'))){
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array('required' => true),
				'password' => array('required' => true)
			));
			
			if ($validation->passed()){
				$user = new User();
				$remember = (input::get('remember') === 'on') ? true : false;
				$Login = $user->login(input::get('username'), input::get('password'), $remember);
				if ($Login){
					if (strlen($user->data()->confirmed)==5){
						$user->logout();
						redirect::go_to('verify.php');
					}else {
						redirect::go_to('index.php');
					}
				}else{
					echo "failed to log in";
				}
			}else{
				foreach ($validation->errors() as $error) {
					echo '<i>'.$error, '<i><br>';
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>camagru login</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
		.log{
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
<body>
	<br><a href="index.php" ><button style="width: 10%;border-radius: 25px;height: 3%; background-color: grey;">HOME</button></a>
	<form action="" method="post" class="log">
		<div class="field">
			<label for="username">Username</label><br>
			<input type="text" name="username" autocomplete="off">
		</div>

		<div class="field">
			<label for="password">Password</label><br>
			<input type="password" name="password" autocomplete="off">
		</div>

		<div class="field">
			<label for="remember">Remember me </label><br>
				<input type="checkbox" name="remember" id="remember" placeholder="Remember me">
			</label><br>
		</div>

		<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
		<br><input type="submit" value="Log in" style="background-color: grey ">
	</form>
</body>
</html>
