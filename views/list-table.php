<?php

require_once( ABSPATH . 'wp-content/plugins/facebook-page-showcase/shocase-list-table.php' );
$viewTable = new Shocase_list_table();
echo '<div style="padding: 15px;">';
echo '<h1>Facebook Pages <a href="?page=' . $_REQUEST['page'] . '&action=add">Add New</a></h1> ';



echo '<form action="">';
$viewTable->prepare_items();
$viewTable->display();
echo '</form>';
echo '</div>';