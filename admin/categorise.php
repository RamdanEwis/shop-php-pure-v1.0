<?php
//=====================page members 
//=====YOT can ADD & DELETE &INSERT MEMBERS

ob_start(); //out buffering start

session_start();

$pageTitle = 'categorise';

if (isset($_SESSION['username'])) {

    include 'init.php';

    $do =   isset($_GET['do']) ? $do = $_GET['do'] :  $do ='Mange';

        //Start mange page

        if ($do == "Mange") {
            //mange page
            $sort = 'ASC';

            $sort_array = array('ASC','DESC');

            if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)) {

                $sort = $_GET['sort'];

            }

            $stmt2 = $con->prepare("SELECT * FROM categorise WHERE parent = 0  ORDER BY ordring $sort");


            $stmt2->execute();
    
    
            $cats = $stmt2->fetchAll();
            
            if (!empty($cats)) {
                
            
            ?>

                <h1 style="margin:30px 0 30px 0 ;" class="text-center">Mange Categorise</h1>

                <div class=" container categorise">
                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i> Mange categorise
                        <div class="pull-right ordering-sort">
                        <i class="fa fa-sort"></i>   Ordring:[
                        <a href="?sort=DESC" class="<?php if($sort == 'DESC'){echo'active' ;} ?>">DESC</a>|
                        <a href="?sort=ASC" class="<?php if($sort == 'ASC'){echo'active' ;} ?>">ASC</a>
                        ]
                        </div>
                    </div>
                    <div class="panel-body">
                    <?php

                        foreach ($cats as $catsis){
                            echo "<div class='cat'>";

                                echo '<div class="buttoncat">';

                                echo '<a href="categorise.php?do=edit&catid=' .   $catsis['ID'] . '" class="btn btn-success "><i class="fa fa-edit"></i> Edit</a>';
                                echo ' <a href="categorise.php?do=delete&catid=' .   $catsis['ID'] . '" class="btn btn-danger confirm"><i class="fa fa-trash"></i> Delete</a>';
                            
                                echo'</div>';

                                echo '<span class="cat-icone pull-left">
                                    <i class="fa fa-tag"></i>
                                    </span>';
                                echo "<h2>" .  $catsis['name'] .  "</h2>";
                                if ($catsis['descirption'] == "" ) { echo "The categorise Has no descirption<br>" ;} else {echo $catsis['descirption'] . "<br>";};
                                //echo "The ordring is " . $catsis['ordring'] ;
                                if ($catsis['visibility'] == 1 ) { echo "<span class='visibility'><i class='fa fa-eye'></i>Hidden</span>" ;} ;
                                if ($catsis['Allow_Comment'] == 1 ) { echo "<span class='Comment'><i class='fa fa-close'></i> Comment Disable</span>" ;};
                                if ($catsis['Allow_ads'] == 1 ) { echo "<span class='Adscat'><i class='fa fa-close'></i> AdsDisable</span>" ;};
                                

                        
                                //$categoryTree =  categoryTree($catsis['ID']);
                            
                                /*  if (! empty($categoryTree)) {
                                        foreach ($categoryTree as $sub_category){
                                            echo '<li class="link-chiled"><a " href="categorise.php?do=edit&catid=' .  $chiled['ID'] . '" > ' . $chiled['name'] . '</a> <a class="delete-chiled" href="categorise.php?do=delete&catid=' .   $chiled['ID']  . '"> <i class="fa fa-trash"> </i>Delete</a></li>' ;
                                        }
                                    
                                    }*/
                            
                                //$catchiled = getitemsparent('categorise','parent = {catsis['ID']} ,'' );

                                $catchiled =  getrecord("*","categorise","WHERE parent = {$catsis['ID']} ","" ,"ID");

                                    foreach ($catchiled as $chiled) {?>

                                        

                                    <div class="chiled-cat-head">
                                    <h4>  Chiled Categoris</h4>
                                    <ul class=" list-unstyled">
                                    <a href="<?php $chiled['ID']?>"><?php $chiled['name']?></option>
                                    <?php $catchiled ;
                                    echo '<li class="link-chiled"><a " href="categorise.php?do=edit&catid=' .  $chiled['ID'] . '" > ' . $chiled['name'] . '</a> <a class="delete-chiled" href="categorise.php?do=delete&catid=' .   $chiled['ID']  . '"> <i class="fa fa-trash"> </i>Delete</a></li>' ;
                                    
                                  ?>  </ul>
                                    </div>
                                

                                    
                                    
                                
                                <?php }
                                echo "</div>";


                            echo "<hr>";
                        }

                    ?>
                    </div>
                    </div>
                    <a href='categorise.php?do=add' class="btn btn-primary"> <i class="fa fa-plus"></i>  Add New categorise</a>
                </div> <?php } else {
                    echo '<div class=" container">
                                <div class=" alert alert-info nice-massage ">There\'s No Record To Show</div>
                                <a href="categorise.php?do=add" class="btn btn-primary"> <i class="fa fa-plus"></i>  Add New categorise</a>
                                

                        </div>';


                }
                
    
        }elseif ($do == "add") { ?>

                
        <h1 style="margin:30px 0 30px 0 ;" class="text-center">Add New catgorise</h1>
        <div class="add-categorise">
        <div class="container">
        <div class="row">
            <form class="text-center" action="?do=insert" method="post">
                <!--Start Name-->
                <div class="form-group form-group-lg">
                    <div class="row">
                        <label for="" class=" col-lg-4 col-xs-5"   control-label">Name</label>
                        <input class=" col-lg-6 col-xs-6" name="name" placeholder=" Name off Categoris" type="text" required>
                    </div>
                </div>
                <!--Start Description-->
                <div class="form-group form-group-lg">
                    <div class="row">
                        <label for="" class=" col-lg-4 col-xs-5"   control-label">Description</label>
                        <input class=" col-lg-6 col-xs-6 " type="text" placeholder="Description" name="Description" required >
                    
                    </div>
                </div>
                <!--Start ordring-->
                <div class="form-group form-group-lg">
                    <div class="row">
                        <label for="" class=" col-lg-4 col-xs-5"   control-label">ordring</label>
                        <input class="  col-lg-6 col-xs-6 " type="text" placeholder="numbur ordring" name="ordring" required >
                    </div>
                </div>
                
                <!--Start Parent-->
                <div class="form-group form-group-lg ">
                        <label for="" class=" col-lg-4 col-xs-5"   control-label>Parent</label>
                        <div class="col-lg-6 col-xs-6 Parent">
                            <select class=" select-status" name="parent" id="" required>
                                <option value="0">NONE</option>
                                <?php 

                                    $getparent = getrecord("*","categorise","WHERE parent = 0","","ID", "DESC" );
                                    foreach($getparent as $cat ) {
                                        echo   "<option  value='". $cat['ID'] . "'>" . $cat['name'] . "</option>";
                                        $catchiled =  getrecord("*","categorise","WHERE parent = {$cat['ID']} ","" ,"ID");

                                        foreach ($catchiled as $chiled) {
                                            
                                                echo '<option value="'. $chiled['ID'] .'">----'. $chiled['name'] . '</option>';
                                        }
                                    }


                                ?>
                            </select>
                        </div>
                </div>
                    <!--Start visibility-->
                    <div class="form-group form-group-lg">
                    <div class="row">
                        <label for="" class=" col-lg-4 col-xs-5 "   control-label>visibility</label>
                        <div class="col-sm-10 col-md-6">
                        <div class="col-sm-6 col-md-6">
                                <input  type="radio" name="visibility" placeholder="visibility" value="0" checked  >
                                <label for="">yes</label>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <input  type="radio" name="visibility" placeholder="visibility" value="1" checked >
                                <label for="">No</label>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!--Start Commenting-->
                    <div class="form-group form-group-lg">
                    <div class="row">
                        <label for="" class=" col-lg-4 col-xs-5 "   control-label">Allow-Commenting</label>
                        <div class="col-sm-10 col-md-6">
                            <div class="col-sm-6 col-md-6">
                            <input  type="radio" name="Comment" placeholder="Allow_Comment Or No" value="0" checked  >
                            <label for="">yes</label>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <input  type="radio" name="Comment" placeholder="Allow_Comment Or No" value="1" checked >
                                <label for="">No</label>
                            </div>
                        </div>
                    </div>

                    </div>   <!--Start ads -->
                    <div class="form-group form-group-lg">
                    <div class="row">
                        <label for="" class=" col-lg-4 col-xs-5 "   control-label">Allow-ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div class="col-sm-6 col-md-6">
                            <input  type="radio" name="ads" placeholder="ads" value="0" checked  >
                            <label for="Yes ads">yes</label>
                            </div>
                            <div class="col-sm-6 col-md-6">
                            <input  type="radio" name="ads" placeholder="ads" value="1" checked >
                            <label for="">No</label>
                            </div>
                        </div>
                    </div>
                    </div>
                <!--Start submit-->
                    <div class="form-group form-group-lg center-block">
                        <div class="col-lg-12 " >
                            <input style="margin:30px 0 30px 0 ;" class="btn btn-primary btn-lg " type="submit" value="Add catgorise" >

                        </div>
                    
                </div>
            </form>
            </div>
            </div>
        </div>


      <?php }elseif($do == "insert") {
        

        echo  '<h1 style="margin:30px 0 30px 0 ;" class="text-center">insert Categoris</h1>';

        echo  ' <div class="container">';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $Description = $_POST['Description'];
                $ordring = $_POST['ordring'];
                $parent = $_POST['parent'];
                $visibility = $_POST['visibility'];
                $Comment = $_POST['Comment'];
                $ads = $_POST['ads'];



                //validete THe Form

            //valedete
            
                

                //chck categoris is exist  in database
                
                $check= chckitiems("name","categorise",$name);

                if ($check === 1 ) {

                
                    echo "<div class='container'>";

                    $theMsg =  '<div class="alert alert-danger">Sory This categorise is exist the database</div>';


                    $url = 'categorise.php';
                    redairecTohome($theMsg,$url);

                echo "</div>";

                }else{

                    if (!empty($name) ) {

                    $stmt = $con->prepare("INSERT INTO
                    categorise  (`name`, descirption, ordring ,parent,visibility, Allow_Comment,Allow_ads)
                    VALUES(:zname, :zDescription, :zordring,:zparent,:zvisibility, :zCommen,:zads) ");

                        $stmt->execute(array(
                        ':zname' => $name,
                        ':zDescription' =>  $Description,
                        ':zordring' => $ordring,
                        ':zparent' => $parent,
                        ':zvisibility' => $visibility,
                        ':zCommen' => $Comment,
                        ':zads' => $ads
                        
                        ));

                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record insert</div>";

                        $url = "categorise.php";
                    
                        redairecTohome($theMsg,$url);

                        }else{

                            $theMsg =  "<div class='alert alert-danger'>" . "The User Name Is Empty" . "</div>"; 
                            
                            redairecTohome($theMsg);
                        }

                }


            }else{

            
                echo "<div class='container'>";

                    $theMsg =  'sory your no show this page direct';



                    redairecTohome($theMsg);

                echo "</div>";
            }

            echo "</div>";


        }elseif ($do == "edit") {
              //Start Edit

            //chack yhe user id is numeric and get the intvalue

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  intval($_GET['catid']) :   0;

            //select all data in this id

            $stmt = $con->prepare("SELECT * FROM categorise WHERE 	ID = ? " );

            //execute this query

            $stmt->execute(array($catid));
            
            //futch the data

            $cat = $stmt->fetch();

            //the row is count
            $count = $stmt->rowcount();

            //if theres stch id show form

            if ($count > 0) {?>

                                
            <h1 style="margin:30px 0 30px 0 ;" class="text-center">Edit catgorise</h1>
                

            <div class="container">
            <div class="row">
                <form class="text-center" action="?do=Update" method="post">
                <input type="hidden" name="catid" value="<?php echo $catid ?>">
                    <!--Start Name-->
                    <div class="form-group form-group-lg">
                        <div class="row">
                            <label for="" class=" col-lg-4 col-xs-5"   control-label">Name</label>
                            <input class=" col-lg-6 col-xs-6" name="name" placeholder=" Name off Categoris" type="text" value="<?php echo $cat['name']  ?>" ">
                        </div>
                    </div>
                    <!--Start Description-->
                    <div class="form-group form-group-lg">
                        <div class="row">
                            <label for="" class=" col-lg-4 col-xs-5"   control-label">Description</label>
                            <input class=" col-lg-6 col-xs-6 " type="text" placeholder="Description" name="Description" value="<?php echo $cat['descirption']  ?>" >
                        
                        </div>
                    </div>
                    <!--Start ordring-->
                    <div class="form-group form-group-lg">
                        <div class="row">
                            <label for="" class=" col-lg-4 col-xs-5"   control-label">ordring</label>
                            <input class="  col-lg-6 col-xs-6 " type="text" placeholder="numbur ordring" name="ordring" value="<?php echo $cat['ordring']  ?>" >
                        </div>
                    </div>
                <!--Start Parent-->
                <div class="form-group form-group-lg ">
                        <label for="" class=" col-lg-4 col-xs-5"   control-label>Parent</label>
                        <div class="col-lg-6 col-xs-6 cat-parent">
                            <select class=" select-status" name="parent" id="" required>
                                <option value="0">None</option>
                                <?php 
                                    
                                    $getparent = getrecord("*","categorise","WHERE parent = 0","","ID", "DESC" );


                                    foreach($getparent as $cat_edit ) {
                                    

                                    
                                        echo   "<option  value='". $cat_edit['ID'] . "'";
                                            if ($cat['parent'] == $cat_edit['ID']) {
                                                echo 'selected';
                                            }
                                        
                                        echo">" . $cat_edit['name'] . "</option>";

                                        $catchiled =  getrecord("*","categorise","WHERE parent = {$cat_edit['ID']} ","" ,"ID");

                                        foreach ($catchiled as $chiled) {
                                            
                                                echo '<option value="'. $chiled['ID'] .'">----'. $chiled['name'] . '</option>';
                                        }
                                    
                                    }
                                
                                ?>
                            </select>

                            
                        </div>
                </div>
                        <!--Start visibility-->
                        <div class="form-group form-group-lg">
                        <div class="row">
                            <label for="" class=" col-lg-4 col-xs-5 "   control-label">visibility</label>
                            <div class="col-sm-10 col-md-6">
                            <div class="col-sm-6 col-md-6">
                                    <input  type="radio" name="visibility" placeholder="visibility" value="0" <?php if ($cat['visibility'] == 0) { echo "checked" ;} ?>   >
                                    <label for="">yes</label>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <input  type="radio" name="visibility" placeholder="visibility" value="1" <?php if ($cat['visibility'] == 1) { echo "checked" ;}?>   >
                                    <label for="">No</label>
                                </div>
                            </div>
                        </div>

                        </div>
                        <!--Start Commenting-->
                        <div class="form-group form-group-lg">
                        <div class="row">
                            <label for="" class=" col-lg-4 col-xs-5 "   control-label">Allow-Commenting</label>
                            <div class="col-sm-10 col-md-6">
                                <div class="col-sm-6 col-md-6">
                                <input  type="radio" name="Comment" placeholder="Allow_Comment Or No" value="0" <?php if ($cat['Allow_Comment'] == 0) { echo 'checked' ;}?>  >
                                <label for="">yes</label>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <input  type="radio" name="Comment" placeholder="Allow_Comment Or No" value="1" <?php if ($cat['Allow_Comment'] == 1) { echo 'checked' ;}?>   >
                                    <label for="">No</label>
                                </div>
                            </div>
                        </div>

                        </div>   <!--Start ads -->
                        <div class="form-group form-group-lg">
                        <div class="row">
                            <label for="" class=" col-lg-4 col-xs-5 "   control-label">Allow-ads</label>
                            <div class="col-sm-10 col-md-6">
                                <div class="col-sm-6 col-md-6">
                                <input  type="radio" name="ads" placeholder="ads"  value="0" <?php if ($cat['Allow_ads'] == 0) { echo 'checked' ;}?>  >
                                <label for="Yes ads">yes</label>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                <input  type="radio" name="ads" placeholder="ads"   value="1" <?php if ($cat['Allow_ads'] == 1) { echo 'checked' ;}?> >
                                <label for="">No</label>
                                </div>
                            </div>
                        </div>
                        </div>
                    <!--Start submit-->
                        <div class="form-group form-group-lg center-block">
                            <div class="col-lg-12 " >
                                <input style="margin:30px 0 30px 0 ;" class="btn btn-primary btn-lg " type="submit" value=" Save catgorise" >

                            </div>
                        
                    </div>
                </form>
                </div>
            </div>
                
            <?php
            //no show form is not id is exist in data
            }else{

                echo "<div class='container'>";

                    $theMsg =  '<br><div class="alert alert-danger"> this id is not  exist in database</div>';

                    redairecTohome($theMsg);

                echo "</div>";
                }

        }elseif ($do == "Update") { 
            
       echo '<h1 style="margin:30px 0 30px 0 ;" class="text-center">Update categorise</h1>';
       echo ' <div class="container">';
        
        
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['catid'];
            $name = $_POST['name'];
            $Desc = $_POST['Description'];
            $ordring = $_POST['ordring'];
            $parent_edit = $_POST['parent'];
            $visibility = $_POST['visibility'];
            $Comm = $_POST['Comment'];
            $ads = $_POST['ads'];


            //validete THe Form

            $validet_form = array();
            if (empty( $name)) {
                $validet_form[] = "<div class='alert alert-danger'>The  Name Empty</div> ";
            }

            foreach ( $validet_form as $error) {

                echo $error ;

            }

        //valedete
            if(empty($validet_form)){

                $stmt = $con->prepare("UPDATE
                                            categorise 
                                            
                                            SET
                                            `name` = ?,
                                            `descirption` = ?,
                                            ordring = ?,
                                            parent = ?,
                                            visibility = ?,
                                            Allow_Comment	 = ?,
                                            Allow_ads = ?
                                                WHERE ID = ? ");

                $stmt->execute(array($name, $Desc, $ordring,$parent_edit,$visibility,$Comm,$ads,$id));


                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Updated</div>";

            
            
                redairecTohome($theMsg,'back');
            
            }


        }else{
        
            echo "<div class='container'>";

                $theMsg =  '<br><div class="alert alert-danger">sory your no show this page direct</div>';

                redairecTohome($theMsg);

              echo "</div>";
        }

        echo "</div>";

        }elseif($do == 'delete') {
            
        echo  '<h1 style="margin:30px 0 30px 0 ;" class="text-center">Delete categorise</h1>';

        echo '<div class="container">';
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
            //check The UserId

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  intval($_GET['catid']) :   0;

            $stmt = $con->prepare("SELECT * FROM categorise WHERE ID = ? ");

            $stmt->execute(array($catid));
            
            $count = $stmt->rowCount();

                if ($count > 0) {

                    $stmt = $con->prepare("DELETE FROM categorise WHERE ID = :zuser ");

                    $stmt->bindParam(":zuser", $catid);

                    $stmt->execute();

                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";

            
                    redairecTohome($theMsg,'back');

                }else{
                        
                    echo "<div class='container'>";

                    $theMsg =  '<br><div class="alert alert-danger"> this id is not  exist in database</div>';

                    redairecTohome($theMsg);

                    echo "</div>";
                }

        
        }else{

        
        echo "<div class='container'>";

        $theMsg = '<div class="alert alert-danger">The Page not diroct</div>';

            redairecTohome($theMsg,'back');

        echo "</div>";

        }


        }elseif ($do == 'Activate') {

    }else{

        header('location: index.php');

    exit();

        }
}
    ob_end_flush();

?>