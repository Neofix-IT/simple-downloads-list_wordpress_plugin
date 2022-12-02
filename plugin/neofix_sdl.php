<?php
/**
 * Plugin Name: Simple Downloads List
 * Plugin URI: http://neofix.ch/
 * Description: Create a downloads list - quick and easy.
 * Version: 1.3.0
 * Author: Neofix
 * Author URI: http://neofix.ch
 * Text Domain: simple-downloads-list
 */

define( 'NEOFIX_SDL_PATH', plugin_dir_url( __FILE__ ) );
define( 'NEOFIX_SDL_PATH_LOCAL', __DIR__ );

require_once "admin/adminpanel.php";

add_action('plugins_loaded', 'neofix_sdl_plugin_init'); 

function neofix_sdl_plugin_init() {

    load_plugin_textdomain( 'simple-downloads-list', false, dirname(plugin_basename(__FILE__)).'/languages/' );

}

//
// Admin section
//
add_action('admin_menu','neofix_sdl_add_add_menu_page');
function neofix_sdl_add_add_menu_page()
{
    add_menu_page( 'Simple Download List', 'Simple downloads list', 'manage_options', 'neofix_sdl_render_admin_panel', 'neofix_sdl_render_admin_panel');
}

// 
// Setup and success message
//
register_activation_hook( __FILE__, 'neofix_sdl_admin_notice_activation_hook' );
function neofix_sdl_admin_notice_activation_hook() {
    set_transient( 'neofix_sdl_admin_notice', true, 5 );
}

add_action( 'admin_notices', 'neofix_sdl_admin_notice_show' );
function neofix_sdl_admin_notice_show(){

    /* Check transient, if available display notice */
    if( get_transient( 'neofix_sdl_admin_notice' ) ){
        ?>
        <div class="updated notice is-dismissible">
            <p>Thank you for using Simple Downloads List! <strong>You are awesome</strong>.</p>
        </div>
        <?php
        /* Delete transient, only display this notice once. */
        delete_transient( 'neofix_sdl_admin_notice' );
    }
}

// Setup DB
register_activation_hook( __FILE__, 'neofix_sdl_setup_db' );
function neofix_sdl_setup_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'neofix_sdl';
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
register_uninstall_hook(__FILE__, 'neofix_sdl_teardown_db');
function neofix_sdl_teardown_db(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'neofix_sdl';
    
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}


//
// Add shortcode
//
require_once 'lists/download_list_1.php';
add_shortcode('neofix_sdl', 'neofix_sdl_render_list_1');

?>