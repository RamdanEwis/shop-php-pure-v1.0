<?php
	$title_name = 'creat new Item';

	session_start();

	include 'init.php';




	if (isset($_SESSION['user'])) {

		$getUser = $con->prepare('SELECT * FROM users WHERE username = ?');

		$getUser->execute(array($sessionUser));

		$info = $getUser->fetch();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
            $avatarname = $_FILES['avatar']['name'];
            $avatartype = $_FILES['avatar']['type'];
            $avatartmp_name = $_FILES['avatar']['tmp_name'];
            $avatarsize = $_FILES['avatar']['size'];

            //list of allowed file type to upload
            $avatarAllowedExtension = array("jpeg", "jpg","png","gif");
            
            

            //$avatarExtension

            //$avatarExtension = strtolower(end(explode(".", $avatarname )));


            $nameitems = filter_var( $_POST['nameitems'] , FILTER_SANITIZE_STRING);
            $Desc =  filter_var($_POST['Description'], FILTER_SANITIZE_STRING);
            $price =  filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $country = filter_var( $_POST['country'], FILTER_SANITIZE_STRING);
            
            $status =  filter_var($_POST['status'], FILTER_SANITIZE_STRING);
            $catid =  filter_var($_POST['catid'], FILTER_SANITIZE_NUMBER_INT);
            
            

            //validete THe Form

            $Error_form = array();


            if (empty( $nameitems)) {
                $Error_form[] = "<div class='alert alert-danger'>The  Name is Empty</div> ";
            }

            if (empty( $Desc)) {
                $Error_form[] ="<div class='alert alert-danger'>The Desc  Empty</div> ";
            }


            if (empty( $country)) {
                $Error_form[] ="<div class='alert alert-danger'>The country is  Empty</div> ";
            }
            
            if ( $status === 0) {
                $Error_form[] ="<div class='alert alert-danger'>The status is  Empty</div> ";
            }

            if ( $catid === 0) {
                $Error_form[] ="<div class='alert alert-danger'>The categorise is  Empty</div> ";
            }
            //if (! empty($avatarname) && ! in_array($avatarExtension , $avatarAllowedExtension)) {

            //    $Error_form[] ="<div class='alert alert-danger'>The Extenstion Is Not <strong>Allowed</strong></div>";

                //}
            if (empty($avatarname)) {

                $Error_form[] ="<div class='alert alert-danger'> Avatar  cant be larger than   <strong> 4MB </strong></div>";

            }
            if ($avatarsize > 4194304) {

                $Error_form[] ="<div class='alert alert-danger'>The Avatar  Is  <strong> Required</strong></div>";

            }
            
            

        //valedete
        if(empty($validet_form)){
            
            
            $avatar = rand(0, 1000000 ) . "_" . $avatarname;

            
            move_uploaded_file($avatartmp_name,"layout\images\\" . $avatar);


            
            //chck user is exist  in database
                $stmt = $con->prepare("INSERT INTO items (`name`, descirption, price, add_Date, country_mode,avatar, `status`,  cat_id, member_id) 
                VALUES(:zname, :zdesc, :zprice, now() , :zcountry,:zavatar, :zstatus,  :zcat_id, :zmember_id)");

                    $stmt->execute(array(

                    ':zname' => $nameitems,
                    ':zdesc' =>  $Desc,
                    ':zprice' => $price,
                    ':zcountry' =>  $country,
                    ':zavatar' =>  $avatar,
                    ':zstatus' => $status,
                    ':zcat_id' => $catid,
                    ':zmember_id' =>  $_SESSION['Id.member']
                    ));
                    

                $Error_form[] = "<div class='alert alert-success'>" . $stmt->rowCount() . " The Member is  insertted</div>";

                
                
                

                


            }else{

            
                

            echo $Error_form[] = "<div class='alert  alert-danger'>" .  "Try Again" . "</div>";

                

            
            }
            
        
        }
?>


<div class="creat-new-ad">

	<h1 class=" text-center" >Create New items</h1>

	<div class=" container">
			<div class="panel panel-primary">
				<div class="panel-heading">My informtion</div>
				<div class="panel-body formnew-item">
                    <div class="row">
                        <div class="col-md-8">
                        <form class="text-center form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                        <!--Start name-->

                        <div class="form-group form-group-lg">
                        
                                <label for="" class=" col-lg-4 col-sm-2"   control-label>Name</label>
                                <div class="col-sm-7 ">
                                <input class="form-control col-md-6 col-xs-10 live " data-class=".live-name" name="nameitems" placeholder="Name Of The Items" type="text" required="required" >
                                </div>
                        </div>
                        
                        <!--Start Description-->
                        <div class="form-group form-group-lg">
                            
                                <label for="" class=" col-lg-4 col-xs-5"   control-label>Description</label>
                                <div class="col-sm-7">
                                <input class="form-control col-lg-6 col-xs-6 live " data-class=".live-desc" name="Description" placeholder="Description Of The Items" type="text"  required="required">
                                </div>
                        </div>
                        
                        <!--Start price-->
                        <div class="form-group form-group-lg">
                        
                                <label for="" class=" col-lg-4 col-xs-5"   control-label>price</label>
                                <div class="col-sm-7">
                                <input value="" class="form-control col-lg-6 col-xs-6 live "data-class=".live-price" name="price" placeholder="price Of The Items" type="text" required="required" >
                                </div>
                        </div>
                        
                        <!--Start country-->
                        <div class="form-group form-group-lg">
                        
                                <label for="" class=" col-lg-4 col-xs-2"   control-label>country</label>
                                <div class="col-sm-7 ">
                                <input class="form-control" name="country" placeholder="country Of Mode" type="text" required="required">
                                </div>
                        </div>
                            <!--Start full-->
                            <!--Start country-->
                        <div class="form-group form-group-lg">
                        
                        <label for="" class=" col-lg-4 col-xs-2"   control-label>Avater</label>
                        <div class="col-sm-7 ">
                        <input class="form-control" name="avatar" placeholder="Avater" type="file" required="required">
                        </div>
                        </div>

                        <!--Start status-->
                        <div class="form-group form-group-lg">
                            
                                <label for="" class=" col-lg-4 col-sm-2"   control-label>status</label>
                                <div class="col-sm-10  col-md-7">
                                    <select class=" select-status" name="status" id="" required>
                                        <option value="">...</option>
                                        <option value="1">new</option>
                                        <option value="2">likenew</option>
                                        <option value="3">used</option>
                                    </select>
                                </div>
                                
                        </div>

                        <!--Start member-->
                        <div class="form-group form-group-lg">
                            
                            <label for="" class=" col-lg-4 col-sm-2"   control-label>Categeries</label>
                            <div class="col-sm-10 col-md-7">
                                <select class=" select-status" name="catid" id="" required>
                                    <option value="">...</option>
                                    <?php 
                                        $stmt = $con->prepare("SELECT * FROM categorise");
                                        $stmt->execute();
                                        $users = $stmt->fetchAll();
                                        foreach($users as $user){
                                            echo '<option value="'. $user['ID'] .'">'. $user['name'] .'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                        <!--Start submit-->
                        <div class="form-group form-group-lg ">
                            <div class=" col-lg-offset-2 col-lg-6" >
                                <input style="margin:10px -21px 30px 0 ;" class="btn btn-primary btn-lg " type="submit" value="Add Items" >
                            </div>
                        </div>
                    
                    </form>
                    </div>
                        <div class="col-md-4">
                            <div class=" thumbnail item-box live-preview">
                                <div class="price-tag"><span class="prodct-tag">
                                    $<span class="live-price"></span> 
                                </span>
                                </div>
                                <img src="layout/images/images.jpg" style=" max-height: 200px;"  class=" img-responsive"> 
                                <div class="caption">
                                    <h2 class="live-name">Titel</h2>
                                    <p class="live-desc">Description</p>
                                </div>
                            </div>
                        </div>
                    </div>

                            <div class="the-error text-center">
                                <?php
                                    
                                    if(!empty($Error_form)){
                                        foreach ($Error_form as $value) {
                                            echo $value . '<br>';
                                        }
                                    }
                                    
                                    

                                ?>
                            </div>

                            <!-- End Error -->
                </div>
        </div> 
    </div>
</div>


	

<?php }else{

	header('Location: login.php');
	exit();
}



include $tpl . 'footer.php';


?>