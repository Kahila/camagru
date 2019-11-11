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
		$validate2 = new Validate();
		$validation2 = $validate2->check($_POST, array(
			'email' => array(
				'required' => true
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

		if ($validation2->passed()){
			try{
				$user->update(array(
					'email' => input::get('email')
				));
				Session::flash('home', 'Your details have been Updated.');
				redirect::go_to('index.php');
			}catch(Exception $e){
				die($e->getMessage());
			}
		}else{
			foreach($validation2->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>uploads</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
    <h1 style="text-align: center; "> Update Info </h1>
</head>
<a href="index.php"><button style="width: 100px" >HOME</button></a>
<body>
	<form action="" method="post">
		<div style="text-align: center;">
			<label for="name" >Name</label><br>
			<input style="width: 200px;" type="text" name="name" value="<?php echo escape ($user->data()->name); ?>"><br>
			<label for="email">username</label><br>
			<input style="width: 200px" type="email" name="email" value="<?php echo escape ($user->data()->email); ?>"><br>
			<input type="submit" value="Update">
			<input type="hidden" name="token" value="<?php echo token::generate(); ?>">
		</div>

	</form>
</body>
</html>

