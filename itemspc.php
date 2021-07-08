<?php



	$title_name = 'Show items';

	session_start();

    include 'init.php';

	
    $itmeId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ?  intval($_GET['itemId']) :   0;

    //select all data in this id
    
    $stmt = $con->prepare("SELECT items.*,

                            categorise.name as categorise_name,
                            users.username FROM items
                            INNER JOIN categorise
                            ON
                            categorise.ID = items.cat_id
                            INNER JOIN users
                            ON
                            users.userID = items.member_id
                            WHERE

                            itmeId = ?  " );

    //execute this query

    $stmt->execute(array($itmeId));
    
    //futch the data

    $item = $stmt->fetch();

    $count = $stmt->rowcount();

    //if theres stch id show form

        if ($count > 0) {

        }else{

            echo "<div class='container'>";

                $theMsg =  '<br><div class="alert alert-danger"> this id is not  exist in database</div>';

                redairecTohome($theMsg,'back');

            echo "</div>";
            }
        if ($item["Approve"] == 0 ){

            echo "<div class='container'>";

            $theMsg =  '<br><div class="alert alert-danger"> This Item Not Approve</div>';

                    redairecTohome($theMsg, "back",2);
            echo '<div  style="margin: 50px 0 307px 0;"></div>';

            

                 echo "</div>";

        }else {
?>
    <h1 class=" text-center"> <?php echo $item["name"]   ?></h1>
    <div class="itemespc">
        <div class="container ">

            <div class="col-md-3">
                    <img src="layout/images/images.jpg" alt="" class=" img-responsive center-block">

                    
            </div>
            <div class="col-md-9 itemepc">
            <h2><?php echo $item["name"]    ?></h2>
            <p><?php echo $item["descirption"]    ?></p>
                    <ul class=" list-unstyled">
                        
                        <li>
                            <i class="fa fa-calendar-check-o  fa-fw"></i>
                            <strong>date:</strong>  <?php echo $item["add_Date"]    ?>
                        </li>

                        <li>
                        <i class="fa fa-money fa-fw"></i>
                            <strong> price: $</strong><?php echo $item["price"]    ?>
                        </li>

                        <li>
                        <i class="fa fa-building fa-fw"></i>
                            <strong>mode in :</strong><?php echo $item["country_mode"]    ?>
                        </li>

                        <li>
                        <i class="fa  fa-tags fa-fw"></i>
                            <strong>Category :</strong> <a href="categoris.php?pageid=<?php echo  $item["cat_id"]?>&pagename=<?php echo $item["categorise_name"] ?>"> <?php echo $item["categorise_name"] . "</a>";   ?>
                        </li>

                        <li>
                        <i class="fa fa-users fa-fw"></i>
                            <strong>Add By :</strong> <a href="../../../ecommerce/profile.php"></a>  <?php echo $item["username"]    ?>
                        </li>
                    </ul>
                
            </div>


        </div>

        <div class="items-comment">
            <div class=" container">
                <hr>

                <?php
                if (isset($_SESSION['user'])){
                    ?>
                    <div class="row">
                        <div class=" col-md-offset-3">
                            <div class="item-comment">
                            <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                                <h3> <strong  name='' >Add your Comments</strong> </h3>
                                <textarea required class="" name="comment" id="" cols="30" rows="10"></textarea><br>
                                <input type="submit" class="btn btn-primary" >
                            </form>
                            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    
                                    $comment = filter_var( $_POST['comment'], FILTER_SANITIZE_STRING);
                                    $user_id =  $item['member_id'];
                                    $item_id = $item["itmeId"];
                                    if (! empty($comment)) {
                                    $stm2 = $con->prepare("INSERT INTO
                                                                comments(comment, stats, commen_date, `user_id`, item_id) 
                                                                VALUES(:zcomment , 0, now(), :zuser_id , :zitem_id )");
                                            
                                    $stm2->execute(array(
                                        ':zcomment' => $comment,
                                        ':zuser_id' =>  $user_id,
                                        ':zitem_id' =>  $item_id

                                    ));
                                    if($stm2){

                                        echo  "<div class='alert alert-success'>The Comment is inserted</div>";
                                    
                                }
                            }else
                            echo  "<div class='alert alert-danger'>You must Add Comment</div>";
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                
                    <?php }else {?>
                    
                        <p> <a class="col-md-offset-3" href="login.php">login</a>  or <a href="login.php">register</a>  To Add Comments </p>
                    
                <?php } ?>
                



                <hr>

                <?php 


                        $stmt3 = $con->prepare("SELECT `comments`.*,`users`.`username` AS member_name

                        FROM `comments` 

                        INNER JOIN
                        `users` ON `users`.`userID` = `comments`.`user_id` WHERE item_id = ? AND stats = 1 ORDER BY id ASC");


                        $stmt3->execute(array($itmeId));


                        $comments = $stmt3->fetchAll();

                        if (! empty($comments)){

                            foreach ($comments as $comment){?>
                            <div class="comment-box text-center">
                                <div class=" container">
                                    <div class="row">
                                        
                                            <div class="col-md-4 text-center">
                                            <img src="layout/images/images.jpg" alt="" class=" img-responsive center-block img-circle img-thumbnail">
                                            <?php echo $comment['member_name']; ?>
                                            
                                            </div>
                                        

                                            <div class="col-md-8 comment-text ">
                                            <?php echo $comment['comment']; ?>
                                            </div><br>
                                        
                                    </div>
                                    <hr>
                                </div>
                            </div>

                            
                        <?php }

                    } else{
                        echo "Not Comments Is Show";
                    }?>
            </div>
        </div>
    </div>

    <?php  }  ?>
    

    


        <?php include $tpl . 'footer.php';?>


