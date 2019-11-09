<?php
require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()){
	redirect::go_to('index.php');
}
if (input::exists()){
	if (token::check(input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true,
				'min' => 6,
				'max' => 20
			),
			'password_new' => array(
				'required' => true,
				'min' => 6,
				'max' => 20
			),
			'password_new_again'=> array(
				'required' => true,
				'min' => 6,
				'max' => 20,
				'matches' => 'password_new'
			)
		));

		if ($validation->passed()){

			if(hash::make(input::get('password_current'), $user->data()->salt) !== $user->data()->password){
				echo "current code wrong";
			}else{
				$salt = hash::salt(32);
				$user->update(array(
					'password' => hash::make(input::get('password_new'), $salt),
					'salt' => $salt
				));

				Session::flash('home', 'Your password has been changed!!');
				redirect::go_to('index.php');
			}
		}else{
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}echo '<br>';
		}
	}
}
?>

<form action="" method="post">
	<div class="field">
		<label for="password_current">Current Password</label><br>
		<input type="password" name="password_current" id="password_current" placeholder="Current Password">
	</div>
	<div class="field">
		<label for="password_new">New Password</label><br>
		<input type="Password" name="password_new" id="password_new" placeholder="New Password">
	</div>
	<div class="field">
		<label for="password_new_again">Repeat Password</label><br>
		<input type="Password" name="password_new_again" id="password_new_again" placeholder="Repeat Password">
	</div>
	<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
	<br><input type="submit" name="Register" style="background-color: grey ">
</form>