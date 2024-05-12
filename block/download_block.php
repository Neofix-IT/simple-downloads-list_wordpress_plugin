<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class SDL_Download_Block{
	function __construct(){
		add_action( 'init', array($this, 'register_block') );
		add_action( 'rest_api_init', array($this, 'register_api_routes') );
	}

	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Behind the scenes, it registers also all assets so they can be enqueued
	 * through the block editor in the corresponding context.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	function register_block(){
		register_block_type( __DIR__ . '/build' );
	}

	/**
	 * Registers alle the neccessary api routes required fot the download block
	 */
	function register_api_routes(){
		register_rest_route(
			'neofix-sdl/v1',
			'/editor-preview/',
			array(
				'methods' => 'GET',
				'callback' => array($this, 'sdl_preview'),
				'permission_callback' => array($this, 'has_admin_privilege')
			)
		);
		register_rest_route(
			'neofix-sdl/v1',
			'/download-categories/',
			array(
				'methods' => 'GET',
				'callback' => array($this, 'get_download_categories'),
				'permission_callback' => array($this, 'has_admin_privilege')
			)
		);
	}

	function has_admin_privilege(){
		return current_user_can( 'administrator' );
	}

	/** 
	 * Retrieves distinct download categories from WP-DB and returns an array
	 * 
	 * @return array
	 */
	function get_download_categories(){
		global $wpdb;
		$table_name = $wpdb->prefix . "neofix_sdl";

		$result = $wpdb->get_results("SELECT DISTINCT `category` FROM ".$table_name." WHERE `category` IS NOT NULL AND `category` <> '' ORDER BY `category` DESC");
		$categories = array();

		foreach( $result as $category ){
			$categories[] = esc_html($category->category);
		}
		return $categories;
	}

	/**
	 * Generates a preview of the list based on the url parameter `category`
	 * 
	 * @param object $data	the request object
	 */
	function sdl_preview( $data ){
		$category = esc_sql($data->get_param( 'category' )) ?? "";

		ob_start();
		include 'build/list_1.php';
		return ob_get_clean();
	}
}

new SDL_Download_Block();