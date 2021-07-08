<?php
	//error reporting
	ini_set('display_errors','on');
	error_reporting(E_ALL);

	include 'admin/connect.php';


	$sessionUser = '';

	if(isset($_SESSION['user'])) {

		$sessionUser = $_SESSION['user'];
	}

	$tpl = 'includes/templates/'; //templates Directory
	$langs = 'includes/languages/';   //lang directory
	$func = 'includes/Functions/';//functions directory
	$css = 'layout/css/'; //css Directory
	$js =	'layout/js/' ;//js Directory


	include $func . "function.php";

	include $langs . 'en.php';

	include $tpl .  'header.php';




?>