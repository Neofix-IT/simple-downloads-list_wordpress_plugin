<?php
/**
 * Plugin Name:       Neofix Sdl
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       neofix-sdl
 *
 * @package           neofix-sdl
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function neofix_sdl_neofix_sdl_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'neofix_sdl_neofix_sdl_block_init' );

add_action( 'rest_api_init', 'neofix_sdl_routes' );

function neofix_sdl_routes(){
	register_rest_route(
		'neofix-sdl/v1',
		'/editor-preview/',
		array(
			'methods' => 'GET',
			'callback' => 'neofix_sdl_editor_preview',
			'permission_callback' => 'neofix_sdl_preview_permission'
		)
	);
}

function neofix_sdl_preview_permission(){
	return is_admin();
}

function neofix_sdl_editor_preview(){
	
}