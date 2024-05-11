<?php

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

function neofix_sdl_download_categories(){
	global $wpdb;
	$table_name = $wpdb->prefix . "neofix_sdl";
	$wpdb->query("INSERT INTO ".$table_name." (`id`, `name`, `description`, `category`, `download`, `deleted`) VALUES (NULL, NULL, NULL, NULL, NULL, false);");

	$result = $wpdb->get_results("SELECT DISTINCT `category` FROM ".$table_name." WHERE `category` IS NOT NULL ORDER BY `category` DESC");
	$categories = array();

	foreach( $result as $category ){
		$categories[] = $category->category;
	}
	return $categories;
}