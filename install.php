<?php
	$servername = 'localhost';
	$username = 'root';
	$password = '123456';
	$dbName = 'camagru';

	$conn = new mysqli($servername, $username, $password);
	if ($conn->connect_error){
		die("failed to connect".$conn->connect_error);
	}else if(!$conn->connect_error){
		if ($conn->query('DROP DATABASE '.$dbName)){
			echo "data base did exist <br>";
		}else{
			echo "database did not exists <br>";
		}
		$db = "CREATE DATABASE ".$dbName;
		if ($conn->query($db)){
			echo "new database has been created <br>";
			$tableUsers = "CREATE TABLE $dbName.users(
				id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				username VARCHAR(20) NOT NULL,
				password VARCHAR(64) NOT NULL,
				salt VARCHAR(50) NOT NULL,
				name VARCHAR(50) NOT NULL,
				joined datetime NOT NULL,
				grp INT(11) UNSIGNED NOT NULL,
				email VARCHAR(40) NOT NULL,
				confirmed VARCHAR(6) NOT NULL
			)";
			$tableUser_session = "CREATE TABLE $dbName.users_session(
				id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				user_id INT(11) NOT NULL,
				hash VARCHAR(64) NOT NULL
			)";
			$tableImage = "CREATE TABLE $dbName.images(
				id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				user_id INT(11) NOT NULL,
				image_name VARCHAR(90) NOT NULL,
				likes INT(6) 
			)";
			$comments = "CREATE TABLE $dbName.comments(
				id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				image_id VARCHAR(70) NOT NULL,
				comment VARCHAR(200) NOT NULL
			)";
		if($conn->query($tableUsers)){
			echo "users table has been created<br>";
		}if($conn->query($tableUser_session)){
			echo "users_session table has been created<br>";
		}if($conn->query($tableImage)){
			echo "images table has been created <br>";
		}if($conn->query($comments)){
			echo "comments table has been created <br>";
		}
	}else{
		echo "error creating the database";
	}
}
	$conn->close();
?>