<?php

/*
********Start Dashbord


*/
$numuser = 6;

$numcoom = 5;

$numitems = 6;
$numcooment = 5;

	session_start();
	$title_name = 'Dashboard';

	include 'init.php';


	if (isset($_SESSION['username'])) {

		//Start dashboard
	?>

	<div class="home-stat text-center">

		<div class=" container">

			<h1 style="margin:30px 0 30px 0 ;" class="text-center">Dashboard</h1>

			<div class="row">
				<div class="col-md-3">
				<a href="members.php"style="text-decoration: none;">
					<div class="stat st-Members">
					<i class="fa fa-users"></i>
					<div class="info">
						Total Members
						<span>
							<?php echo countitems('userID', 'users') ?>
						</span>
					</div>
					</div>
				</a>
				</div>
				<div class="col-md-3">
				<a href="members.php?page=Pending"style="text-decoration: none;">
					<div class="stat st-Pending">
					<i class="fa fa-user-plus"></i>
						<div class="info">
							Pending Members<span><?php echo chckitiems('regstatus', 'users', 0) ?></span>
						</div>
					</div>
				</a>
				</div>
				<div class="col-md-3">
				<a href="items.php" style="text-decoration: none;">
					<div class="stat st-items">
					<i class="fa fa-tag"></i>
						<div class="info">
							Total Items <span><?php echo countitems('itmeId', 'items') ?> </span>
						</div>
					</div>
					</a>
				</div>
				<div class="col-md-3">
				<a href="comments.php" style="text-decoration: none;">
					<div class="stat st-Comments">
					<i class="fa fa-comments"></i>
						<div class="info">
							Total Comments<span><?php echo countitems('id', 'comments') ?> </span>
						</div>
					</div>
				</a>
				</div>

			</div>
		</div>
	</div>

	<div class="lates">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						
						<div class="panel-heading"><i class="fa fa-user"></i> Latest Registerd User <?php echo ' ' . $numuser;?>
						<span class="taggel-info pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
						</div>
						
						<div class="panel-body">
							<ul class="lates-user list-unstyled">
								<?php
								
								$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 LIMIt $numuser ");
								
								$stmt->execute();
						
								$latesuser = $stmt->fetchAll();
								if (!empty($latesuser)) {

								foreach ($latesuser as $user) {
									echo '<li>';
									echo $user["username"];
									echo $user["Date"];
									echo '<a href="members.php?do=edit&userid=' . $user["userID"] . '">';
										echo '<span class="btn btn-success pull-right">';
										echo '<i class="fa fa-edit"></i>Edit';
											if ($user['regstatus'] == 0){
												echo '<a href="members.php?do=Activate&userid=' .   $user['userID']  . '" class="btn btn-info acteveted pull-right "><i class="fa fa-check "></i> Acteveted</a>';
											}
										echo '</span>';
									echo '</a>';
									echo '</li>';
								}
								?>
							</ul>
							<?php }else {
									echo '<div class=" container">
												<div >There\'s No Record To Show</div>
						
										</div>';
						
						
								}?>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading lates-items"> <i class="fa fa-tags"></i> items<?php echo ' ' . $numitems;?>
						<span class="taggel-info pull-right">
							<i class="fa fa-plus fa-lg"></i>
						</span>
						</div>
						<div class="panel-body">
						<ul class="lates-user list-unstyled">
								<?php
								
								$stmt = $con->prepare("SELECT * FROM items WHERE itmeId ORDER BY itmeId ASC LIMIT $numitems ");
								
								$stmt->execute();
						
								$latesuser = $stmt->fetchAll();
								
								if (!empty($latesuser)) {

								foreach ($latesuser as $item) {
									echo '<li>';
									echo $item["name"];
									echo $item["add_Date"];
									echo '<a href="members.php?do=edit&userid=' . $item["itmeId"] . '">';
										echo '<span class="btn btn-success pull-right">';
										echo '<i class="fa fa-edit"></i>Edit';
										if ($item['Approve'] == 0){
											echo '<a href="items.php?do=Approve&itmeId=' .   $item['itmeId']  . '" class="btn btn-info acteveted pull-right "><i class="fa fa-check"></i> Approve</a>';
										}
										echo '</span>';
									echo '</a>';
									echo '</li>';
								}
								?>
							</ul>
							<?php	}else {
									echo '<div class=" container">
												<div  ">There\'s No Record To Show</div>
				
										</div>';
						
						
								}?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class=" container">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default ">
					
					<div class="panel-heading "><i class="fa fa-comments"></i> Latest Comment <?php echo ' ' . $numuser;?>
					<span class="taggel-info pull-right">
						<i class="fa fa-plus fa-lg"></i>
					</span>
					</div>
					
					<div class="panel-body">
					<ul class="lates-comment  list-unstyled">
						<?php
						
						$stmt = $con->prepare("SELECT `comments`.*,
						`users`.`username` AS member_name

						FROM `comments` 


						INNER JOIN
						`users` ON `users`.`userID` = `comments`.`user_id` ORDER BY id ASC  LIMIt $numcooment  ");
										
						$stmt->execute();
				
						$latescomment = $stmt->fetchAll();

						if (!empty($latescomment)) {

						foreach ($latescomment as $comment) {

											echo '<div class="comment-box">';
												echo '<span class="member-n">' . '<a href="comments.php?do=edit&id=' .   $comment['id'] . '">' .  $comment["member_name"] . '</a>' . '</span> ';
												echo '<p class="member-c">' . $comment["comment"]. '</p> ';
											echo '</div>';


						}
						?>
					</ul>
					<?php }else {
							echo '<div class=" container">
										<div >There\'s No Record To Show</div>
				
								</div>';
				
				
						}?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php

	//End Dashboard


	} else {
	header('location: index.php');
	}

?>