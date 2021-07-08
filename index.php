<?php
	$title_name = 'HomePage';
	session_start();

	include 'init.php';?>

    <div class="home_page ">
		<div class=" container">

        <?php $get_items_index =  getitemsparent('cat_id' ,'items',"") ?>
        <?php $fechItems = getrecord("*","categorise","","","parent = 0","Asc") ;
            if (empty($get_items_index)){

            foreach ($fechItems as $cat ) { ?>

                <h1 class="text-center" ><?php echo $cat['name']?></h1>
                <div class="items-home"></div>
                <div class="row">
                <?php foreach( getitemsparent('cat_id' ,'items', $cat['ID']) as $items ) {
                echo '<div class="col-md-4 col-sm-6">';
                    echo '<div class=" thumbnail item-box box-caption ">';
                    if ($items['Approve'] == 0) {
                        echo '<span class="approve-item"style="background-color: red;color: #fff;" >Wating Approve Item</span>';
                    }
                        echo '<span class="prodct-tag">$' . $items['price'] . '</span>';?>
                        <img src='layout\images\<?php echo $items['avatar']?> '  alt='' />

                    
                    <?php echo '<div class="caption">';

                        echo '<a href="itemspc.php?itemId=' . $items['itmeId']  . '"><h2> ' . $items['name']   . '</h2></a>';
                            echo '<p>' . $items['descirption']   .'</p>';
                            
                            echo '<a href="tel:+01207008183" class=" " style="direction: ltr"><p style="color: #25d366;" class=
                            "pull-right"><i class="fa fa-whatsapp fa-2x "></i>  01207008183 </p></a>';
                            echo '<div class=" clearfix"></div>';
                            echo '<p class=" pull-right">' . $items['add_Date']   .'</p><br>';
                        
                        echo '</div>';
                    echo '</div>';
                echo '</div>'; }?>
                
                </div>


            <?php }
            } ?>

    
    

	</div>

	</div>

	<?php include $tpl . 'footer.php'; ?>