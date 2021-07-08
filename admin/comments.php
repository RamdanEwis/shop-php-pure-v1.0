
<?php
//=====================page comments 
//=====YOT can ADD & DELETE &INSERT MEMBERS


session_start();



if (isset($_SESSION['username'])) {

    include 'init.php';

    $do =   isset($_GET['do']) ? $do = $_GET['do'] :  $do ='Mange';

    //Start mange page

    if ($do == "Mange"){
         //mange page
        

        
        $stmt = $con->prepare("SELECT `comments`.*,`items`.`name` AS items_Name,
                                                    `users`.`username` AS member_name

                                    FROM `comments` 

                                    INNER JOIN 
                                    `items`ON `items`.`itmeId` = `comments`.`item_id`
                                    INNER JOIN
                                    `users` ON `users`.`userID` = `comments`.`user_id` ORDER BY id ASC");

        /*   في لعنه الكود ده نفس الي فوق ومش شغال

                            SELECT`comments`.*,`items`.`name`AS items_Name,
                                                        `users`.`username` AS member_name
                                FROM `comments` 
                                
                                INNER JOIN
                                    `items` ON `items`.`itmeId` = `comments`.`	item_id` 
                                INNER JOIN
                                    `users` ON `users`.`userID` = `comments`.`user_id`*/
        $stmt->execute();


        $rows = $stmt->fetchAll();
        
        if (!empty($rows)) {
        
        
        ?>


            <h1 style="margin:30px 0 30px 0 ;" class="text-center"> Mange Comments</h1>
            <div class='container'>
                <div class="table-responsive text-center">
                    <table class="table-mange table table-bordered text-center">
                        <tr>
                            <td>#ID</td>
                            <td>comments</td>
                            <td>item Name</td>
                            <td>User Name</td>
                            <td>Add Date Date</td>
                            <td>Control</td>
                        </tr>



                    <?php foreach ($rows as $row):

                            echo "<tr>";

                                echo " <td>" .$row['id']   ."</td>";
                                echo " <td>".$row['comment']   ."</td>";
                                echo " <td>" .$row['items_Name']   ."</td>";
                                echo " <td>" .$row['member_name'] ."</td>";
                                echo " <td>" .$row['commen_date'] ."</td>";
                                echo " <td>";

                                    echo '<a href="comments.php?do=edit&id=' .   $row['id'] . '" class="btn btn-success "><i class="fa fa-edit"></i> Edit</a>';
                                    echo ' <a href="comments.php?do=delete&id=' .   $row['id'] . '" class="btn btn-danger confirm"><i class="fa fa-trash"></i> Delete</a>';
                                    if ($row['stats'] == 0){
                                    echo '<a href="comments.php?do=Approve&id=' .   $row['id']  . '" class="btn btn-info acteveted "><i class="fa fa-edit"></i> Approve</a>';
                                    }
                                echo "</td>";
                                
                            echo "</tr>";

                        endforeach;

                    ?>


                    </table>
                </div>      
                
            
            <!--   <a href='members.php?do=add' class="btn btn-primary"> <i class="fa fa-plus"></i>  Add Comments</a>
            -->
            </div> 
    <?php  }else {
            echo '<div class=" container">';
            echo    '<div class="nice-massage alert alert-info ">There\'s No Record To Show</div>';

            echo  '</div>';


        }


    } elseif ($do == "edit") {
        //Start Edit

            //chack yhe user id is numeric and get the intvalue

            $comment_id = isset($_GET['id']) && is_numeric($_GET['id']) ?  intval($_GET['id']) :   0;

            //select all data in this id

            $stmt = $con->prepare("SELECT * FROM comments WHERE id = ? LIMIT 1" );

            //execute this query

            $stmt->execute(array($comment_id));
            
            //futch the data

            $row = $stmt->fetch();

            //the row is count
            $count = $stmt->rowcount();

            //if theres stch id show form

        if ($count > 0) {?>
            <h1 style="margin:30px 0 30px 0 ;" class="text-center">Edit Comments</h1>

            <div class="container">
            <div class="row">
                <form class="text-center" action="?do=update" method="post">
                <input type="hidden" name="id" value="<?php echo $comment_id ?>">
                    <!--Start comment-->
                    <div class="form-group form-group-lg">
                        <div class="row">
                            <label for="" class=" col-lg-4 col-sm-2   control-label">Comment</label>
                            <div class="col-sm-10 col-md-6">
                            <textarea name="comment" class="form-control" >
                                <?php echo $row['comment'] ?>
                            </textarea>
                            
                            </div>
                        </div>
                    </div>
                    
                    <!--Start submit-->
                    <div class="form-group form-group-lg center-block">
                            <div class="col-lg-12 " >
                                <input style="margin:30px 0 30px 0 ;" class="btn btn-primary btn-lg " type="submit" value="Save" >

                            </div>
                        
                    </div>
                </form>
                </div>
            </div>
        <!--End Edit-->
        <?php
        //no show form is not id is exist in data
        }else{

            echo "<div class='container'>";

                $theMsg =  '<br><div class="alert alert-danger"> this id is not  exist in database</div>';

                redairecTohome($theMsg);

            echo "</div>";
            }

    }elseif ($do == "update") { 

    echo '<h1 style="margin:30px 0 30px 0 ;" class="text-center">Update Comment</h1>';
    echo ' <div class="container">';
        
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comment_id = $_POST['id'];
            $comment = $_POST['comment'];



            //validete THe Form

            $validet_form = array();
            if (empty( $comment)) {
                $validet_form[] = "<div class='alert alert-danger'>The User Name Empty</div> ";
            }

            foreach ( $validet_form as $error) {

                echo $error ;

            }

        //valedete
            if(empty($validet_form)){

                $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE id = ? ");

                $stmt->execute(array($comment,$comment_id));

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

        echo  '<h1 style="margin:30px 0 30px 0 ;" class="text-center">Delete comment</h1>';

        echo '<div class="container">';
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
            //check The UserId

            $comment_id = isset($_GET['id']) && is_numeric($_GET['id']) ?  intval($_GET['id']) :   0;


            $stmt = $con->prepare("SELECT * FROM comments WHERE id = ? ");

            $stmt->execute(array($comment_id));
            
            $count = $stmt->rowCount();

                if ($count > 0) {

                    $stmt = $con->prepare("DELETE FROM comments WHERE id = :zid ");

                    $stmt->bindParam(":zid", $comment_id);

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
        
        echo  '<h1 style="margin:30px 0 30px 0 ;" class="text-center">Approve comments</h1>' ;

        echo '<div class="container">';
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
            //check The UserId

            $comment_id = isset($_GET['id']) && is_numeric($_GET['id']) ?  intval($_GET['id']) :   0;

            $stmt = $con->prepare("SELECT * FROM comments WHERE id = ? ");

            $stmt->execute(array($comment_id));
            
            $count = $stmt->rowCount();

            if ($count > 0) {

                $stmt = $con->prepare("UPDATE comments SET stats = 1 WHERE id = ? ");

                $stmt->execute(array($comment_id));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Approve</div>";

           
                redairecTohome($theMsg);

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

    }
    
    }else{

    header('location: index.php');

    exit();

    }
?>