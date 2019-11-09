<?php
require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()){
	redirect::go_to('index.php');
}

if (input::exists()){
	if(token::check(input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			)
		));
		if ($validation->passed()){
			try{
				$user->update(array(
					'name' => input::get('name')
				));
				Session::flash('home', 'Your details have been Updated.');
				redirect::go_to('index.php');
			}catch(Exception $e){
				die($e->getMessage());
			}
		}else{
			foreach($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}
?>

<form action="" method="post">
	<div class="field">
		<label for="name">Name</label><br>
		<input type="text" name="name" value="<?php echo escape ($user->data()->name); ?>">

		<input type="submit" value="Update">
		<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
	</div>

</form>