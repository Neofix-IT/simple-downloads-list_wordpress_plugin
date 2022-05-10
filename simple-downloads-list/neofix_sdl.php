<?php
/**
 * Plugin Name: Simple downloads list
 * Plugin URI: http://www.neofix.ch/
 * Description: Create a downloads list - quick and easy.
 * Version: 1.0
 * Author: Martin Heini
 * Author URI: http://www.neofix.ch
 */


require_once "admin/adminpanel.php";

//
// Admin section
//
function SDL_adminMenu()
{
    add_menu_page( 'Simple Download List', 'Simple downloads list', 'manage_options', 'render_admin_panel', 'render_admin_panel');
}
add_action('admin_menu','SDL_adminMenu');


// 
// Setup and success message
//
register_activation_hook( __FILE__, 'fx_admin_notice_example_activation_hook' );
function fx_admin_notice_example_activation_hook() {
    set_transient( 'fx-admin-notice-example', true, 5 );
}

add_action( 'admin_notices', 'fx_admin_notice_example_notice' );
function fx_admin_notice_example_notice(){

    /* Check transient, if available display notice */
    if( get_transient( 'fx-admin-notice-example' ) ){
        ?>
        <div class="updated notice is-dismissible">
            <p>Thank you for using this plugin! <strong>You are awesome</strong>.</p>
        </div>
        <?php
        /* Delete transient, only display this notice once. */
        delete_transient( 'fx-admin-notice-example' );
    }
}

// Setup DB
register_activation_hook( __FILE__, 'neofix_sdl_install' );
function neofix_sdl_install() {
	require_once "connection.php";
	$charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE ".$table_name." (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(250) DEFAULT NULL,
        `description` text DEFAULT NULL,
        `category` varchar(250) DEFAULT NULL,
        `download` text DEFAULT NULL,
        `deleted` tinyint(1) DEFAULT 0,
        PRIMARY KEY (`id`)
    ) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
}

// 
// Uninstall code
// 
function deactivate_neofix_sdl(){
	require_once "connection.php";
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
register_uninstall_hook(__FILE__, 'deactivate_neofix_sdl');

//
// Add shortcode
//
require_once 'lists/download_list_1.php';
add_shortcode('neofix_sdl', 'render_list_1');

?>