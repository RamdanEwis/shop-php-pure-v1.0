<?php

session_start();
$no_navbar = '';
$title_name = 'login';

if (isset($_SESSION['username'])) {
	header('location: dashboard.php');
}



	include 'init.php';

	//check if user ciming form http post

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedpass = sha1($password);
	
	//check user exist in database
	$stmt = $con->prepare("SELECT 
								userID,username, pasword 
							FROM 
								users 
							WHERE 
								username = ? 
							AND 
								pasword = ?  
							AND 
								GroupID = 1
							LIMIT 1" );

	$stmt->execute(array($username, $hashedpass));
	$row = $stmt->fetch();
	$count = $stmt->rowcount();
	
	if ($count > 0) {

		$_SESSION['username'] = $username;
		$_SESSION['ID'] = $row['userID'];
		header('location: dashboard.php');
		exit();
	}

	}
	?>
	
	<form  class='login' action="<?php echo$_SERVER['PHP_SELF'] ?>" method="POST">
		<h4 class=" text-center ">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off"/>
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password"/>
		<input class="btn btn-primary btn-block" type="submit" value="login"> 

	</form>





