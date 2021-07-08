<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php gettitle()?></title>
		<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
		<link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
		<link rel="stylesheet" href="<?php echo $css; ?>frontend.css">

	</head>
	<body>

		<div class="upper-bar">
			<div class=" container">

				<?php
					if (isset($_SESSION['user'])) {
						?>
						<!-- Single button -->

						<div class=" col-md-6">
								<img src="../../../ecommerce/layout/images//<?php echo 'male_boy_person_people_avatar_icon_159358 - Copy.png' ?> "  class="img-header  img-responsive img-circle img-thumbnail alt="">
						
							
								<div class="btn-group " >
								
										<span class="  btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?php echo $_SESSION['user']    ?>
											<span class="caret"></span>
										</span>

										<ul class="dropdown-menu">
											<li><a href="../../../ecommerce/admin/index.php"><i class="fa fa-edit"></i> VistDashbord</a></li>
											<li><a href="../../../ecommerce/profile.php"><i class="fa fa-edit"></i> MyProfile</a></li>
											<li><a href="../../../ecommerce/new-ad.php"><i class="fa fa-edit"></i> newadd</a></li>
											<li><a href="../../../ecommerce/logout.php"><i class="fa fa-close"></i> loguot</a></li>
										</ul>
								</div>
							</div>

							<div class="col-md-6">
							<a href="tel:+01207008183" class="pull-right " style="direction: ltr">
							<i class=" fa fa-phone-square fa-lg"> </i>
								<span>+01207008183</span>
								
							</a>
							</div>

						

						<?php

							$user_status = checkUserStatus($_SESSION['user']);
							if ($user_status == 1) {
									//user is not acteve
								echo " your user name need to activiateve";
							}
						}else{
							
						
							?>
							<a href="login.php">

								<span class="pull-right">login/Signup</span>

							</a>
							<?php }   ?>
			</div>
		</div>
		
	<nav class="navbar navbar-inverse ">
		<div class="container">
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Logo Shop</a>
			</div>

			<div class="collapse navbar-collapse navbar-right" id="app-nav">
			<ul class="nav navbar-nav">
			
			<?php 
			$categoris = getrecord("*","categorise","WHERE parent = 0","","ID","ASC");

			foreach($categoris as $cats) {
				
				echo '<li><a href="categoris.php?pageid=' . $cats['ID'] . '">' .   $cats['name'] . '</a></li>' ;

			}
			?>
			

			</ul>

			
			</div>

		</div>

	</nav>