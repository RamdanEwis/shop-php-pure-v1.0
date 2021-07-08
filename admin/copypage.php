<?php
//=====================page members 
//=====YOT can ADD & DELETE &INSERT MEMBERS

ob_start(); //out buffering start

session_start();

$pageTitle = '';

if (isset($_SESSION['username'])) {

    include 'init.php';

    $do =   isset($_GET['do']) ? $do = $_GET['do'] :  $do ='Mange';

        //Start mange page

        if ($do == "Mange") {
            //mange page
    
    
        }elseif ($do == "add") {
        
        }elseif($do == "insert") { 

        }elseif ($do == "edit") {

        }elseif ($do == "update") { 

        }elseif($do == 'delete') {

        }elseif ($do == 'Activate') {

    }else{

        header('location: index.php');

    exit();

        }
}
    ob_end_flush();

?>