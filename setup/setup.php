<?php

class NeofixSdlSetup{
    function __construct(){
        $plugin_file_path = NEOFIX_SDL_PATH_LOCAL . "/neofix_sdl.php";

        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) ); 
        add_action( 'admin_notices', array( $this, 'register_installation_confirmation_notice' ) );
        register_activation_hook( $plugin_file_path, "NeofixSdlSetup::show_installation_confirmation_notice" );
     
        // DB Setup and teardown
        register_activation_hook( $plugin_file_path, "NeofixSdlSetup::setup_db" );
        register_uninstall_hook( $plugin_file_path, "NeofixSdlSetup::teardown_db" );
    }
    function load_textdomain() {
        load_plugin_textdomain( 'simple-downloads-list', false, dirname(plugin_basename(__FILE__)).'/languages/' );
    }

    function register_installation_confirmation_notice(){
        /* Check transient, if available display notice */
        if( get_transient( 'neofix_sdl_admin_notice' ) ){
            ?>
            <div class="updated notice is-dismissible">
                <p><?php echo __('Thank you for using Simple Downloads List! <strong>You are awesome</strong>.', 'simple-downloads-list')?></p>
            </div>
            <?php
            /* Delete transient, only display this notice once. */
            delete_transient( 'neofix_sdl_admin_notice' );
        }
    }
    static function show_installation_confirmation_notice() {
        set_transient( 'neofix_sdl_admin_notice', true, 5 );
    }

    static function setup_db() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'neofix_sdl';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE `$table_name` (
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

    static function teardown_db(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'neofix_sdl';
        
        $wpdb->query("DROP TABLE IF EXISTS `$table_name`");
    }
}

new NeofixSdlSetup();

?>