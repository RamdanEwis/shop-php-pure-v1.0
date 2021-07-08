<?php


//gategory Tree

function categoryTree($parent_id = 0, $sub_mark = ''){
    
    global $con;

    $query = $con->prepare("SELECT * FROM categorise WHERE parent = $parent_id ORDER BY name ASC");
    
   $query->execute();
  
    if($query->rowCount() > 0){
        foreach($query->fetchAll() as $row){
            echo '<a href="'.$row['ID'].'">'.$sub_mark.$row['name'].'</option><br>';
            categoryTree($row['ID']);
        }
    }
}

//Function Get Record In Database v 2.0
function getrecord($select,$from,$where = NULL,$and = NULL ,$orderby = NULL ,$ordering = "DESC"){

    global $con;


    $getstmt= $con->prepare("SELECT $select FROM $from $where  $and ORDER BY $orderby $ordering");

    $getstmt ->execute();

    $record = $getstmt->fetchAll();

    return $record;


}

/**FUNCTION GET ITEMS WHERE + VALUE  v2.0*/
function getitemsparent($where,$table, $value){

    global $con;

    $getitems= $con->prepare("SELECT * FROM $table WHERE $where = ? ORDER BY itmeId DESC");

    $getitems ->execute(array($value));

    $items = $getitems->fetchAll();

    return $items;
}

/*The function that Echo the page title
** v 1.0
** Start function Get Title
*/

function gettitle() {

    global $title_name;

    if(isset($title_name)){

        echo $title_name;

    }else {
        
        echo "default";

    }
}



/*Home redirct Function v 2.0*/


function redairecTohome($theMsg, $url = null , $Second = 4) {
    
    if ($url == null) {

        $url = "index.php";

    }else{

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== 'empty' ) {

            $url = $_SERVER['HTTP_REFERER'];

        }else {

            $url ="index.php";
        
        }
    }

    echo  $theMsg ;

    echo '<div class="alert alert-info">You wil be redirected the page  ' .   ' after ' .   $Second  . ' Second </div>';
    
    header("refresh:$Second; url=$url");
}



/*CHk items  function in database  val 1.0*/

function chckitiems($select, $from, $value) {
    global $con;

    $statement = $con->prepare("SELECT $select FROM $from WHERE $select  = ?");

    $statement->execute(array($value));

    $count = $statement ->rowCount();

    return $count;
}


/*funcion to count items of table v 1.0*/

function countitems($item, $table) {
    global $con;
    
    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table ");

    $stmt2->execute();
    return $stmt2->fetchColumn();

}




//Function of lates items from database v 1.0
//SELECT select the itms user

function latsitems($select,$from,$order,$lIMIT = 5){

    global $con;
    $getstmt= $con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $lIMIT");

    $getstmt ->execute();
    $row = $getstmt->fetchAll();

    return $row;


}


?>
