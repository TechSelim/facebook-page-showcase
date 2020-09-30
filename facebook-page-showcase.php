<?php

/**
 * Plugin Name: facebook-page-showcase
 * 
 * Plugin URI:        https://techics.com/facebook-page-showcase
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Selim Ahmad
 * Author URI:        https://techics.com/
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

function fa_facebook_page_submission()
{
    add_menu_page('Facebook Showcase', 'Facebook Showcase', 'manage_options', 'facebook-page-showcase', 'fa_facebook_page');
}
add_action('admin_menu', 'fa_facebook_page_submission');

function fa_facebook_page()
{
    if( $_GET['action'] == 'add' ){
        if( $_POST ){

            global $wpdb;
            $wpdb->insert(
                'brian_facebook_pages',
                array(
                    'name'          => $_POST['name'], 
                    'phone'         => $_POST['phone'], 
                    'email'         => $_POST['email'],
                    'page_link'     => $_POST['page_link'],
                    'is_approved'   => $_POST['is_approved'] 
                )
            );
            include_once('views/list-table.php');
        }else{
            include_once('views/add.php');
        }
    }else if ($_GET['action'] == 'edit') {
        if ($_POST) {
            global $wpdb;
            $wpdb->update(
                'brian_facebook_pages',
                array(
                    'name'      => $_POST['name'],
                    'phone'     => $_POST['phone'],
                    'email'     => $_POST['email'],
                    'page_link' => $_POST['page_link'],
                    'is_approved'   => $_POST['is_approved'] 
                ),
                array(
                    'id' => $_POST['id']
                )
            );
            include_once('views/list-table.php');
        }else{
            include_once('views/edit.php');
        }
        
    } else if($_GET['action'] == 'delete'){
        global $wpdb;
        $wpdb->delete(
            'brian_facebook_pages',
            array('id' => $_GET['id'])
        );
        include_once('views/list-table.php');
    }else{
        include_once('views/list-table.php');
    }
    
    
}