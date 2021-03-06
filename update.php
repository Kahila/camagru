<?php
require_once 'core/init.php';

$user = new User();
$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
if (!$user->isLoggedIn()){
	redirect::go_to('index.php');
}
echo '<a href="logout.php"><button >Logout</button></a>';
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
$id = $user->data()->id;
if (isset($_POST['email_n'])){
	$query = "UPDATE `users` SET `email_n` = 'on' WHERE `users`.`id` = '$id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	echo "email verifiation turned on";
}if(isset($_POST['email_n_off'])){
	$query = "UPDATE `users` SET `email_n` = 'no' WHERE `users`.`id` = '$id'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	echo "email verificaton turned off";
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
			<input type="hidden" name="token" value="<?php echo token::generate(); ?>"><br>
		</div>
			<br><button name='email_n' style="width:100px;">email allow</button><br>
			<button name='email_n_off' style="width:100px;">email deny</button>
	</form>
</body>
</html>