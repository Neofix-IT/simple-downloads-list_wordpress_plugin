<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_shortcode('neofix_sdl', 'neofix_sdl_render_list_1');

function neofix_sdl_render_list_1($attr)
{
	wp_enqueue_style('neofix_sdl_style_1', NEOFIX_SDL_PATH . '/dist/blocks/sdl/style-index.css');
	$args = shortcode_atts(array(
		'category' => ''
	), $attr);
	$category = $args["category"];

	ob_start();
	include NEOFIX_SDL_PATH_LOCAL . '/templates/download_lists/list_1.php';
	$data = ob_get_clean();

	return $data;
}
