<?php
ob_start();
session_start();
$no_navbar = '';
$title_name = 'login';

if (isset($_SESSION['user'])) {
	header('location: index.php');
}
?>
    <?php include 'init.php'; 
    //check if user ciming form http post

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        if (isset($_POST['login'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

    echo $user . $pass;   
        $hashedpass = sha1($pass);

        //check user exist in database
        $stmt = $con->prepare("SELECT 
                                    userID,username, pasword 
                                FROM 
                                    users 
                                WHERE 
                                    username = ? 
                                AND 
                                    pasword = ?  
                                " );

            $stmt->execute(array($user, $hashedpass));

            $get = $stmt->fetch();



            $count = $stmt->rowcount();

            if ($count > 0) {

                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $hashedpass ;
                $_SESSION['Id.member'] =  $get['userID'];
                
                header('location: index.php');
                exit();
            }
        }else{
            

        $formsinup_error = array();

        $username = $_POST['username-singup'];
        $pass =  $_POST['pass1'];
        $pass2 =  $_POST['pass2'];
        $email = $_POST['email'];
        $shapass =  $_POST['pass1'];;


            if (isset($username)) {

                $filterUser = filter_var($_POST['username-singup'] , FILTER_SANITIZE_STRING);

                if (strlen($filterUser) < 4) {

                    $formsinup_error[] = '<div class="nice-massage-login alert alert-danger ">The User Name cant be less than 4 charcters</div>';
                
    
                }
            }
            if (isset($pass) && isset($pass2) ) {
                

                if ($pass !== $pass2) {

                    $formsinup_error[] =  '<div class="nice-massage-login alert alert-danger ">The Password not match</div>';

                }
            }
            if (isset($email)) {

                $filteremail = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);

                if (filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true ) {

                    $formsinup_error[] = '<div class="nice-massage-login alert alert-danger ">The Emailis not valid</div>';
                
    
                }
            }
            
        //valedete
        if(empty($formsinup_error)){
            

            //chck user is exist  in database
            
            $check= chckitiems("username","users",$username);

            if ($check === 1 ) {

            

                $formsinup_error[] = '<div class="nice-massage-login alert alert-danger ">Sory This name is exist the database</div>';


            }else{

                $stmt = $con->prepare("INSERT INTO
                users  (username , Email ,regstatus, pasword,Date)
                VALUES(:zuser, :zemail,0, :pasword,now()) ");
    
                    $stmt->execute(array(
                    ':zuser' => $username,
                    ':zemail' =>  $email,
                    ':pasword' => $shapass
    
                    ));

                    $formsinup_error[] =  "<div class='nice-massage-login alert alert-success ' style='color:#449d44;border-left:5px solid #449d44;'>" . $stmt->rowCount() . " Congrats You Are Registerd User</div>";

                }




            }
        }
    }
    ?>
<!--Start form login-->
<div class="login-page" >
    <div class=" container">
        <h1 class="text-center"><span class="selected" data-class="login">login</span> | <span data-class="singup">singup</span> </h1>
        <form class="login text-center"action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="input-control">
                <input class="form-control" name="user" type="text" placeholder="type the  username" autocomplete="off"required="required">
            </div>
            <div class="input-control">
                <input class="form-control" name="pass" type="password" placeholder="type the  password" autocomplete="off" required="required">
            </div>
            <div class="input-control">
                <input class="btn btn-primary btn-block " name="login" type="submit" value="Login" >
            </div>
        </form>
        
<!--end form login-->


<!--Start form singup-->
        <form class="singup text-center" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="input-control">
                <input class="form-control" name="username-singup" type="text" placeholder=" type the username" autocomplete="off" required="required">
            </div>  
            <div class="input-control">
                <input class="form-control" name="pass1" type="password" placeholder="type the password" autocomplete="off" required="required">
            </div>
            <div class="input-control">
                <input class="form-control" name="pass2" type="password" placeholder="type the password again" autocomplete="off">
            </div>
            <div class="input-control">
                <input class="form-control" name="email" type="email" placeholder="type the Email" autocomplete="off" required="required">
            </div>
            <div class="input-control">
                <input class="btn btn-success btn-block " name="singup" type="submit" value="Singup" >
            </div>
        </form>
<!--end form singup-->

<!--Start Error Form-->
<div class="the-error text-center">
<?php
    
    if(!empty($formsinup_error)){
        foreach ($formsinup_error as $value) {
            echo $value . '<br>';
        }
    }
    
    

?>
    </div>

<!-- End Error -->

    </div>
</div>







<?php   include $tpl . 'footer.php';
ob_end_flush(); ?>