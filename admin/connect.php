<?php
	//connect pdo 

	//This data sorce name
	$dsn = 'mysql:host=localhost;dbname=shop';

	//name the user name
	$user = 'root';

	//the password
	$pass = '';


	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);
//this is the catch is useing to try con
	try {
		//Start connection with pdo
		$con = new PDO($dsn, $user, $pass, $option);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	}


	catch(PDOException $e) {
		echo 'Failed To Connect' . $e->getMessage();
		
	}