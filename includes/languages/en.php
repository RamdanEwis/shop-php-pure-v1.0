<?php

function lang($words) {
    static $lang = array(

        //Navbar links
        'categorise' => 'Categorise',
        'home-admin'   => 'Home',
        'items' => 'Items',
        'members' => 'Members',
        'comments' => 'Comments',
        'statistics' => 'Statistics',
        'logs' => 'Logs'

    );
    return $lang[$words];
}

?>