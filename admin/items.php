<?php
//=====================page Itmes 
//=====YOT can ADD & DELETE &INSERT MEMBERS

ob_start(); //out buffering start

session_start();

$pageTitle = 'itmes';

if (isset($_SESSION['username'])) {

    include 'init.php';



    $do =   isset($_GET['do']) ? $do = $_GET['do'] :  $do ='Mange';

        //Start mange page

        if ($do == "Mange") {
               //mange page
        

        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

        }

         $stmt = $con->prepare("SELECT
                                    `items`.*,`categorise`.`name`AS Cat_name,
                                    `users`.`username` AS member_name
                                FROM 
                                    `items` 
                                INNER JOIN
                                    `categorise` ON `categorise`.`ID` = `items`.`cat_id` 
                                INNER JOIN
                                    `users` ON `users`.`userID` = `items`.`member_id`");


        $stmt->execute();


        $rows = $stmt->fetchAll();

        if (!empty($rows)) {

        
        ?>


            <h1 style="margin:30px 0 30px 0 ;" class="text-center"> Mange Items</h1>
            <div class='container'>
                <div class="table-responsive text-center">
                    <table class="table-mange table table-bordered text-center">
                        <tr>
                            <td>ID</td>
                            <td>Name items</td>
                            <td>descirption</td>
                            <td>price</td>
                            <td>add Date</td>
                            <td>categorise</td>
                            <td>member</td>
                            <td> control</td>
                        </tr>
                        
                    <?php 

                        foreach ($rows as $row):

                            echo "<tr>";

                                echo " <td>" .$row['itmeId']   ."</td>";
                                echo " <td>" .$row['name']   ."</td>";
                                echo " <td>" .$row['descirption']   ."</td>";
                                echo " <td>" .$row['price']   ."</td>";
                                echo " <td>" .$row['add_Date'] ."</td>";
                                echo " <td>" .$row['Cat_name']   ."</td>";
                                echo " <td>" .$row['member_name']   ."</td>";
                                echo ' <td>
                                <a href="items.php?do=edit&itmeId=' .   $row['itmeId'] . '" class="btn btn-success "><i class="fa fa-edit"></i> Edit</a>'
                                . ' <a href="items.php?do=delete&itmeId=' .   $row['itmeId'] . '" class="btn btn-danger confirm"><i class="fa fa-trash"></i> Delete</a>';
                                if ($row['Approve'] == 0){
                                echo '<a href="items.php?do=Approve&itmeId=' .   $row['itmeId']  . '" class="btn btn-info acteveted "><i class="fa fa-edit"></i> Approve</a>';
                                }
                                echo "</td>" ;
                                
                            echo "</tr>";

                        endforeach;

                    ?>


                    </table>
                </div>      
                
            
                <a href='items.php?do=add' class="btn btn-primary"> <i class="fa fa-plus"></i>  Add items Members</a>
            
            </div> <?php }else {
                echo '<div class=" container">
                            <div class="nice-massage alert alert-info ">There\'s No Record To Show</div>

                            <a href="items.php?do=add" class="btn btn-primary"> <i class="fa fa-plus"></i>  Add items Members</a>

                    </div>';


            }

        
        }elseif ($do == "add") {?>


            <h1 style="margin:30px 0 30px 0 ;" class="text-center">Add New items</h1>

            <div class="container">
                    <form class="text-center form-horizontal" action="?do=insert" method="POST">
                        <!--Start name-->

                        <div class="form-group form-group-lg">
                        
                                <label for="" class=" col-lg-4 col-sm-2"   control-label>Name</label>
                                <div class="col-sm-6 ">
                                <input class="form-control col-md-6 col-xs-10" name="nameitems" placeholder="Name Of The Items" type="text" >
                                </div>
                        </div>
                        
                        <!--Start Description-->
                        <div class="form-group form-group-lg">
                            
                                <label for="" class=" col-lg-4 col-xs-5"   control-label>Description</label>
                                <div class="col-sm-6 ">
                                <input class="form-control col-lg-6 col-xs-6" name="Description" placeholder="Description Of The Items" type="text" >
                                </div>
                        </div>
                        
                        <!--Start price-->
                        <div class="form-group form-group-lg">
                        
                                <label for="" class=" col-lg-4 col-xs-5"   control-label>price</label>
                                <div class="col-sm-6 ">
                                <input class="form-control col-lg-6 col-xs-6" name="price" placeholder="price Of The Items" type="text" ">
                                </div>
                        </div>
                        
                        <!--Start country-->
                        <div class="form-group form-group-lg">
                        
                                <label for="" class=" col-lg-4 col-xs-2"   control-label>country</label>
                                <div class="col-sm-6 ">
                                <input class="form-control" name="country" placeholder="country Of Mode" type="text" ">
                                </div>
                        </div>
                        
                        <!--Start status-->
                        <div class="form-group form-group-lg">
                            
                                <label for="" class=" col-lg-4 col-sm-2"   control-label>status</label>
                                <div class="col-sm-10 col-md-6">
                                    <select class=" select-status" name="status" id="">
                                        <option value="0">...</option>
                                        <option value="1">new</option>
                                        <option value="2">likenew</option>
                                        <option value="3">used</option>
                                    </select>
                                </div>
                                
                        </div>
                        <!--Start member-->
                        <div class="form-group form-group-lg">
                            
                            <label for="" class=" col-lg-4 col-sm-2"   control-label>Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select class=" select-status" name="memberid" id="">
                                    <option value="0">...</option>
                                    <?php 
                                        $getuser = getrecord("*","users","","" ,"userID");

                                        foreach($getuser as $user){
                                            echo '<option value="'. $user['userID'] .'">'. $user['username'] .'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                        <!--Start member-->
                        <div class="form-group form-group-lg">
                            
                            <label for="" class=" col-lg-4 col-sm-2"   control-label>Categeries</label>
                            <div class="col-sm-10 col-md-6">
                                <select class=" select-status" name="catid" id="">
                                    <option value="0">...</option>
                                    <?php 
                                        $get_cat = getrecord("*","categorise","WHERE parent = 0","" ,"ID");
                                       // $get_cat = getrecord("*","categorise","parent = 0","" ,"ID");

                                        foreach($get_cat as $cat){

                                            echo '<option value="'. $cat['ID'] .'">'. $cat['name'] .'</option>';

                                            

                                            $catchiled =  getrecord("*","categorise","WHERE parent = {$cat['ID']} ","" ,"ID");

                                            foreach ($catchiled as $chiled) {
                                                
                                                    echo '<option value="'. $chiled['ID'] .'">----'. $chiled['name'] . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                        <!--Start submit-->
                        <div class="form-group form-group-lg ">
                            <div class=" col-lg-offset-2 col-lg-6" >
                                <input style="margin:30px 0 30px 0 ;" class="btn btn-primary btn-lg " type="submit" value="Add Items" >
                            </div>
                        </div>
                    
                    </form>
            </div>
        
    <?php }elseif($do == "insert") { ?>

            <h1 style="margin:30px 0 30px 0 ;" class="text-center">insert items</h1>

            <div class="container">


            <?php  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $nameitems = $_POST['nameitems'];
                $Desc = $_POST['Description'];
                $price = $_POST['price'];
                $country = $_POST['country'];
                $status = $_POST['status'];
                $memberid = $_POST['memberid'];
                $catid = $_POST['catid'];


                //validete THe Form

                $validet_form = array();


                if (empty( $nameitems)) {
                    $validet_form[] = "<div class='alert alert-danger'>The  Name is Empty</div> ";
                }

                if (empty( $Desc)) {
                    $validet_form[] ="<div class='alert alert-danger'>The Desc  Empty</div> ";
                }
                if (empty( $price)) {
                    $validet_form[] = "<div class='alert alert-danger'>The  price is Empty</div> ";
                }

                if (empty( $country)) {
                    $validet_form[] ="<div class='alert alert-danger'>The country is  Empty</div> ";
                }
                
                if ( $status === 0) {
                    $validet_form[] ="<div class='alert alert-danger'>The status is  Empty</div> ";
                }
                if ( $memberid === 0) {
                    $validet_form[] ="<div class='alert alert-danger'>The member is  Empty</div> ";
                }
                if ( $catid === 0) {
                    $validet_form[] ="<div class='alert alert-danger'>The categorise is  Empty</div> ";
                }
                

                foreach ( $validet_form as $error) {

                    echo $error ;

                }

            //valedete
            if(empty($validet_form)){
                

              //chck user is exist  in database
                    $stmt = $con->prepare("INSERT INTO items (`name`, descirption, price, add_Date, country_mode, `status`,  cat_id, member_id) 
                    VALUES(:zname, :zdesc, :zprice, now() , :zcountry, :zstatus,  :zcat_id, :zmember_id)");

                        $stmt->execute(array(

                        ':zname' => $nameitems,
                        ':zdesc' =>  $Desc,
                        ':zprice' => $price,
                        ':zcountry' =>  $country,
                        ':zstatus' => $status,
                        ':zcat_id' => $catid,
                        ':zmember_id' =>  $memberid
                        ));
                        

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record insert</div>";

                    
                    
                        redairecTohome($theMsg);

                    


                }else{

                
                    

                    $theMsg = "<div class='alert  alert-danger'>" .  "Try Again" . "</div>";

                    redairecTohome($theMsg, 'back');

                
                }
            }
            echo "</div>";

        }elseif ($do == "edit") {
             //Start Edit

            //chack yhe user id is numeric and get the intvalue

            $itmeId = isset($_GET['itmeId']) && is_numeric($_GET['itmeId']) ?  intval($_GET['itmeId']) :   0;

            //select all data in this id
            
            $stmt = $con->prepare("SELECT * FROM items WHERE itmeId = ?  " );

            //execute this query

            $stmt->execute(array($itmeId));
            
            //futch the data

            $item = $stmt->fetch();

            //the row is count
            $count = $stmt->rowcount();

            //if theres stch id show form

        if ($count > 0) {?>
            <h1 style="margin:30px 0 30px 0 ;" class="text-center">Edit Items</h1>

            <div class="container">
            <div class="row">
                <form class="text-center" action="?do=update" method="post">
                <input type="hidden" name="itmeId" value="<?php echo $itmeId ?>">
                <div class=" form-group-lg">
                        
                        <label for="" class=" col-lg-4 col-sm-2   control-label">Name</label>
                        <div class="col-sm-6 ">
                        <input class="form-control col-md-6 col-xs-10" name="name" placeholder="Name Of The Items" type="text" value="<?php echo $item['name'] ?>">
                        </div>
                </div>
                
                <!--Start Description-->
                <div class="form-group form-group-lg">
                    
                        <label for="" class=" col-lg-4 col-xs-5   control-label">Description</label>
                        <div class="col-sm-6 ">
                        <input class="form-control col-lg-6 col-xs-6" name="Description" placeholder="Description Of The Items" type="text" value="<?php echo $item['descirption'] ?>" >
                        </div>
                </div>
                
                <!--Start price-->
                <div class="form-group form-group-lg">
                
                        <label for="" class=" col-lg-4 col-xs-5   control-label">price</label>
                        <div class="col-sm-6 ">
                        <input class="form-control col-lg-6 col-xs-6" name="price" placeholder="price Of The Items" type="text" value="<?php echo $item['price'] ?>">
                        </div>
                </div>
                
                <!--Start country-->
                <div class="form-group form-group-lg">
                
                        <label for="" class=" col-lg-4 col-xs-2"   control-label>country</label>
                        <div class="col-sm-6 ">
                        <input class="form-control" name="country" placeholder="country Of Mode" type="text" value="<?php echo $item['country_mode'] ?>">
                        </div>
                </div>
                
                <!--Start status-->
                <div class="form-group form-group-lg">
                    
                        <label for="" class=" col-lg-4 col-sm-2"   control-label>status</label>
                        <div class="col-sm-10 col-md-6">
                            <select class=" select-status" name="status" id="" >
                                <option value="1"<?php if($item['status'] == 1) {echo 'selected';} ?>">new</option>
                                <option value="2"<?php if($item['status'] == 2) {echo 'selected';}  ?>">likenew</option>
                                <option value="3"<?php if($item['status'] == 3) {echo 'selected';}  ?>">used</option>
                            </select>
                        </div>
                        
                </div>
                <!--Start member-->
                <div class="form-group form-group-lg">
                            
                            <label for="" class=" col-lg-4 col-sm-2"   control-label>Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select class=" select-status" name="memberid" id="">
                                    <option value="">...</option>
                                    <?php 
                                        $stmt = $con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $users = $stmt->fetchAll();
                                        foreach($users as $user){

                                            echo '<option value="'. $user['userID'] .'"';

                                            if($item['member_id'] == $user['userID']) {echo 'selected';} 

                                            echo '>'. $user['username'] .'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                        <!--Start member-->
                        <div class="form-group form-group-lg">
                            
                            <label for="" class=" col-lg-4 col-sm-2   control-label">Categeries</label>
                            <div class="col-sm-10 col-md-6">
                                <select class=" select-status" name="catid" id="">
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
                        <input style="margin:30px 0 30px 0 ;" class="btn btn-primary btn-lg " type="submit" value="Save" >
                    </div>
                </div>

                </form>

                
            </div>
            <?php
            
                $stmt = $con->prepare("SELECT `comments`.*,`users`.`username` AS member_name

                FROM `comments` 

                INNER JOIN

                `users` ON `users`.`userID` = `comments`.`user_id` WHERE item_id = ?");


        $stmt->execute(array($itmeId));


                        
        //`users` ON `users`.`userID` = `comments`.`user_id` WHERE item_id = ?");


        //$stmt->execute(array($itmeId));

        $rows = $stmt->fetchAll();

        if (!empty($rows)) {


        ?>

        
        <h1 style="margin:30px 0 30px 0 ;" class="text-center"> Mange<?PHP echo "[ " .  $item['name']  . "]" ?> Comments</h1>
        <div class='container'>
        <div class="table-responsive text-center">
        <table class="table-mange table table-bordered text-center">
        <tr>
        <td>#ID</td>
        <td>comments</td>
        <td>User Name</td>
        <td>Add Date Date</td>
        <td>Control</td>
        </tr>



        <?php  foreach ($rows as $row):

        echo "<tr>";

            echo " <td>" .$row['id']   ."</td>";
            echo " <td>".$row['comment']   ."</td>";
            echo " <td>" .$row['member_name'] ."</td>";
            echo " <td>" .$row['commen_date'] ."</td>";
            echo ' <td>
            <a href="comments.php?do=edit&id=' .   $row['id'] . '" class="btn btn-success "><i class="fa fa-edit"></i> Edit</a>'
            . ' <a href="comments.php?do=delete&id=' .   $row['id'] . '" class="btn btn-danger confirm"><i class="fa fa-trash"></i> Delete</a>';
            if ($row['stats'] == 0){
            echo '<a href="comments.php?do=Approve&id=' .   $row['id']  . '" class="btn btn-info acteveted "><i class="fa fa-edit"></i> Approve</a>';
            }
            echo "</td>" ;
            
        echo "</tr>";

        endforeach;

        ?>


        </table>
        </div>      

        </div> 
        <?php  }else {

        }

            ?>
        </div>

        
        <!--End Edit-->
        <?php
        //no show form is not id is exist in data
        }else{

            echo "<div class='container'>";

                $theMsg =  '<br><div class="alert alert-danger"> this id is not  exist in database</div>';

                redairecTohome($theMsg,'back');

            echo "</div>";
            }

        }elseif ($do == "update") { 
            echo '<h1 style="margin:30px 0 30px 0 ;" class="text-center">Update items</h1>';

            echo ' <div class="container">';
        
            
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['itmeId'];
            $name = $_POST['name'];
            $desc = $_POST['Description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $catid = $_POST['catid'];
            $memberid = $_POST['memberid'];


            //validete THe Form


            $validet_form = array();

            if (empty( $name)) {
                $validet_form[] = "<div class='alert alert-danger'>The User Name Empty</div> ";
            }

            if (empty( $desc)) {
                $validet_form[] ="<div class='alert alert-danger'>The Email  Empty</div> ";
            }

            if (empty( $price)) {

                $validet_form[] ="<div class='alert alert-danger'>The Full Name Empty</div> ";

            }

            foreach ( $validet_form as $error) {

                echo $error ;

            }

        //valedete
            if(empty($validet_form)){

                $stmt = $con->prepare("UPDATE
                                            items 
                                        SET
                                            `name` = ?, descirption = ?, price = ?, country_mode = ?, `status` = ?,cat_id = ?,member_id = ?
                                        WHERE
                                            itmeId = ? ");

                $stmt->execute(array($name, $desc, $price,$country,$status, $catid, $memberid,$id));    
    

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";

                redairecTohome($theMsg,'back');
            
            }


        }else{
           
            echo "<div class='container'>";

                $theMsg =  '<br><div class="alert alert-danger">sory your no show this page direct</div>';

                redairecTohome($theMsg,'back');

              echo "</div>";
        }

        echo "</div>";

        }elseif($do == 'delete') {
        
            echo  '<h1 style="margin:30px 0 30px 0 ;" class="text-center">Delete Member</h1>';

            echo '<div class="container">';
            
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            
                //check The UserId
    
                $itmeId = isset($_GET['itmeId']) && is_numeric($_GET['itmeId']) ?  intval($_GET['itmeId']) :   0;
    
                $stmt = $con->prepare("SELECT * FROM items WHERE itmeId = ? ");
    
                $stmt->execute(array($itmeId));
                
                $count = $stmt->rowCount();
    
                    if ($count > 0) {
    
                        $stmt = $con->prepare("DELETE FROM items WHERE itmeId = :zitemsid ");
    
                        $stmt->bindParam(":zitemsid", $itmeId);
    
                        $stmt->execute();
    
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";
    
                
                        redairecTohome($theMsg,'back');
    
                    }else{
                            
                        echo "<div class='container'>";
    
                        $theMsg =  '<br><div class="alert alert-danger"> this id is not  exist in database</div>';
    
                        redairecTohome($theMsg,'back');
    
                        echo "</div>";
                    }
    
            
            }else{
    
            
            echo "<div class='container'>";
    
            $theMsg = '<div class="alert alert-danger">The Page not diroct</div>';
    
                redairecTohome($theMsg,'back');
    
            echo "</div>";
    
            }
    
    
    

    }elseif ($do == 'Approve') {
        
        echo  '<h1 style="margin:30px 0 30px 0 ;" class="text-center">Approve items</h1>' ;

        echo '<div class="container">';
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
            //check The UserId

            $itmeId = isset($_GET['itmeId']) && is_numeric($_GET['itmeId']) ?  intval($_GET['itmeId']) :   0;

            $stmt = $con->prepare("SELECT * FROM items WHERE itmeId = ? ");

            $stmt->execute(array($itmeId));
            
            $count = $stmt->rowCount();

            if ($count > 0) {

                $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE itmeId = ? ");

                $stmt->execute(array($itmeId));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Approve</div>";

                
                redairecTohome($theMsg,'back');

            }else{
                    
                echo "<div class='container'>";

                $theMsg =  '<br><div class="alert alert-danger"> this id is not  exist in database</div>';

                redairecTohome($theMsg,'back');

                echo "</div>";
            }

 
        
    
        echo "</div>";

        

        
        }else{

         
            echo "<div class='container'>";

            $theMsg = '<div class="alert alert-danger">The Page not diroct</div>';

                redairecTohome($theMsg,'back');

            echo "</div>";

         }

    
  

    }else{

        header('location: index.php');

    exit();

        }
}
    ob_end_flush();

?>