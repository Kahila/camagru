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
					redirect::go_to('index.php');
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


<form action="" method="post">
	<div class="field">
		<label for="username">Username</label><br>
		<input type="text" name="username" autocomplete="off">
	</div>

	<div class="field">
		<label for="password">Password</label><br>
		<input type="password" name="password" autocomplete="off">
	</div>

	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="remember"> Remember me
		</label><br>
	</div>

	<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
	<br><input type="submit" value="Log in" style="background-color: grey ">
</form>