<?php
	include 'connect.php';

 $tpl = 'includes/templates/'; //templates Directory
 $langs = 'includes/languages/';   //lang directory
 $func = 'includes/Functions/';//functions directory
 $css = 'layout/css/'; //css Directory
 $js =	'layout/js/' ;//js Directory


include $func . "function.php";

include $langs . 'en.php';

include $tpl .  'header.php';

if (!isset($no_navbar)){
	
	include $tpl . 'navbar.php';
}

include $tpl . 'footer.php';
?>