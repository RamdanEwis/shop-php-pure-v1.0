
<?php
session_start();
 include 'init.php'; ?>
<?php
$cat_id = $_GET['pageid']
?>
<div class=" container cat-front"> 
    <?php
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

            cat_id = ? " );

//execute this query

            $stmt->execute(array($cat_id));

            //futch the data

            $item = $stmt->fetch();

            echo '<h1 class="text-center">' . $item['categorise_name']   . '</h1>';

        ?>

<div class="row">
    <?php
    
        foreach( getitemsparent('cat_id' ,'items',$cat_id) as $items ){
                
                echo '<div class="col-md-4 col-sm-6">';
                
                    echo '<div class=" thumbnail item-box box-caption">';
                    if ($items['Approve'] == 0) {
                        echo '<span class="approve-item"style="background-color: red;color: #fff;" >Wating Approve Item</span>';
                    }
                        echo '<span class="prodct-tag">$' . $items['price'] . '</span>';?>

                        <img src='layout\images\<?php echo $items['avatar']?> '  alt='' />
                        <?php echo '<div class="caption">';

                        echo '<a href="itemspc.php?itemId=' . $items['itmeId']  . '"> '. '<h2> ' . $items['name']   . '</h2>'  
                        . '</a>';
                            echo '<p>' . $items['descirption']   .'</p>';
                            echo '<a href="tel:+01207008183" class=" " style="direction: ltr"><p style="color: #25d366;" class=
                            "pull-right"><i class="fa fa-whatsapp fa-2x "></i> 01207008183 </p></a>';
                            echo '<div class=" clearfix"></div>';
                            echo '<p class=" pull-right">' . $items['add_Date']   .'</p><br>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
    } ?>
    
</div>


</div>
<?php   include $tpl . 'footer.php'; ?>