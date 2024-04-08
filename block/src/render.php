<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

 function neofix_sdl_get_downloads($attr){
	global $wpdb;
	$table_name = $wpdb->prefix . 'neofix_sdl';

	$args = shortcode_atts( array(
		'category' => ''
	), $attr );

	$result;
	if($args["category"] == ""){
		$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");
	} else {
		$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE 
		AND category = '".$args["category"]."' ORDER BY id DESC");
	}

	ob_start();
	include 'list_1.php';
	echo ob_get_clean();
}
neofix_sdl_get_downloads('');

?>