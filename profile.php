<?php
	$title_name = 'profile';

	session_start();

	include 'init.php';


	if (isset($_SESSION['user'])) {

		$getUser = $con->prepare('SELECT * FROM users WHERE username = ?');

		$getUser->execute(array($sessionUser));

		$info = $getUser->fetch();?>





	<div class="information">

		<h1 class=" text-center" >My Profile</h1>
		<div class=" container">
				<div class="panel panel-primary">
				<div class="panel-heading">My informtion</div>
					<div class="panel-body">
						<div class="form-group row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group" id="last_name_div">
									<div class="input-group">
										<span class="input-group-addon"><i class=" fa fa-user"></i></span>
										<input type="text" class="form-control" value="<?php echo $info['fullname']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group" id="first_name_div">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-users"></i></span>
									<input type="text"class="form-control" value="<?php echo $info['username'];?>">
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group" id="last_name_div">
									<div class="input-group">
										<span class="input-group-addon"><i class=" fa  fa-calendar-check-o"></i></span>
										<input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $info['Date']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group" id="first_name_div">
									<div class="input-group">
									<span class="input-group-addon"><i class="fa  fa-envelope-o"></i></span>
									<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $info['Email'];?>">
									</div>
								</div>
							</div>
						</div>
						<input type="submit" class="btn  btn-success center-block" value="Edit My informtion">
					</div>
					
				</div>

				<div class="panel panel-primary">
					<div class="panel-heading">My Items</div>
						<div class="panel-body">
							<div class="row">
							
								<?php foreach( getitemsparent('member_id','items' , $info['userID']) as $items ) { ?>
										
										<div class="col-md-4 col-sm-6">
											<div class=" thumbnail item-box box-caption">

												<?php if ($items['Approve'] == 0) {?>
												<span class="approve-item"style="background-color: red;color: #fff;" >Wating Approve Item</span>
												<?php } ?>

												<span class="prodct-tag">$<?php $items['price'] ; ?></span>
												<img src='layout\images\<?php echo $items['avatar'] ;?> ' alt='' />

												<div class="caption">
													<ul class=" list-unstyled">
														<?php echo '<a href="itemspc.php?itemId=' . $items['itmeId']  . '"> <li>' . $items['name']   . '</li></a>'?>
														<li><?php echo $items['descirption']   ?></li>
														<a href="tel:+01207008183" class=" " style="direction: ltr"><p style="color: #25d366;" class=
														"pull-right"><i class="fa fa-whatsapp fa-2x "></i> 01207008183 </p></a>
														<div class=" clearfix"></div>
														<li class="pull-right" ><?php echo $items['add_Date']  ;?></li> <br>
													</ul>
												</div>
											</div>
										</div>

								<?php } ?>

							</div>
							
							<?php if (empty($items['itmeId'])) {
								
								echo "sorry There' No Ads To Show Create <a href='new-ad.php'>New Ad</a> ";

							} ?>
						</div>
				</div>

				<div class="panel panel-primary">
					<div class="panel-heading">Lates Comments</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
								
									<div class="panel-body">
											<?php
											
												$stmt = $con->prepare("SELECT * FROM comments
												WHERE `user_id` = ? ");
																
												$stmt->execute(array( $info['userID']));
										
												$comments = $stmt->fetchAll();
						
												if (!empty($comments)) {
						
												foreach ($comments as $comment) {
						
																	
																		echo '<p >' . $comment["comment"]. '</p> ';
																	
						
												
												}
											?>
										
										<?php

											}else {
												echo 'There\'s No Comment To Show Create <a href="">New Ad</a> ';
											}

										?>
									
								</div>
							</div>
						</div>
					</div>
				</div>
	</div>

<?php

	}else{

		header('Location: login.php');
		exit();
	}



include $tpl . 'footer.php';


?>