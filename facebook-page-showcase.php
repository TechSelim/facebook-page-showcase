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

function showcase_activation_cb()
{
    global $wpdb;
    $wpdb->query('CREATE TABLE IF NOT EXISTS brian_facebook_pages (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(30) NOT NULL,
        `phone` VARCHAR(30) NOT NULL,
        `email` VARCHAR(50),
        `page_link` TEXT,
        `is_approved` INT(2) DEFAULT 0
        )');
}
register_activation_hook(__FILE__, 'showcase_activation_cb');

function showcase_deactivation_cb()
{
    global $wpdb;
    $wpdb->query('DROP TABLE IF EXISTS `brian_facebook_pages`');
}
register_deactivation_hook(__FILE__, 'showcase_deactivation_cb');

function fa_scripts()
{
    wp_enqueue_script('fa-ajax', plugin_dir_url(__FILE__) . 'js/faajax.js', array('jquery'), '20181011', true);
    wp_localize_script('fa-ajax', 'fa_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'fa_scripts');

function fa_facebook_page()
{
    if ($_GET['action'] == 'add') {
        if ($_POST) {

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
        } else {
            include_once('views/add.php');
        }
    } else if ($_GET['action'] == 'edit') {
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
        } else {
            include_once('views/edit.php');
        }
    } else if ($_GET['action'] == 'delete') {
        global $wpdb;
        $wpdb->delete(
            'brian_facebook_pages',
            array('id' => $_GET['id'])
        );
        include_once('views/list-table.php');
    } else {
        include_once('views/list-table.php');
    }
}



// [facebook_showcase_submission]
function fa_showcase_submission($atts)
{
    ob_start();
?>
    <div id="feedback"></div>
    <form action="" id="faSubmission" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" id="name" class="form-control" name="name" value=""><br>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" class="form-control" name="phone" value=""> <br>
        </div>
        <div class="form-group">
            <label for="email">Email: </label>
            <input type="text" id="email" class="form-control" name="email" value=""> <br>
        </div>

        <div class="form-group">
            <label for="page_link">Page Link:</label>
            <input type="text" id="page_link" class="form-control" name="page_link" value=""> <br>
        </div>

        <div class="form-group">
            <input type="submit" class="form-control btn btn-success" value="Submit">
        </div>
    </form>
<?php
    return ob_get_clean();
}
add_shortcode('facebook_showcase_submission', 'fa_showcase_submission');


add_action("wp_ajax_faaction", "faaction");
add_action("wp_ajax_nopriv_faaction", "faaction");

function faaction()
{
    $name       = $_POST['name'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email'];
    $page_link  = $_POST['page_link'];


    global $wpdb;

    $res = $wpdb->insert('brian_facebook_pages', array(
        'name'      => $name,
        'phone'     => $phone,
        'email'     => $email,
        'page_link' => $page_link
    ));

    if ($res) {
        echo 1;
    } else {
        echo 0;
    }
    wp_die();
}
