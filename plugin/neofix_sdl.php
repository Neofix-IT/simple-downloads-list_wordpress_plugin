<?php
/**
 * Plugin Name: Simple Downloads List
 * Plugin URI: http://neofix.ch/
 * Description: Create a downloads list - quick and easy.
 * Version: 1.4.0
 * Author: Neofix
 * Author URI: http://neofix.ch
 * Text Domain: simple-downloads-list
 */

define( 'NEOFIX_SDL_PATH', plugin_dir_url( __FILE__ ) );
define( 'NEOFIX_SDL_PATH_LOCAL', __DIR__ );

require_once "setup/setup.php";
require_once "admin/adminpanel_v2.php";
require_once 'lists/list_1/download_list_1.php';


?>