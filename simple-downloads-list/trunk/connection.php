<?php
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));

	global $wpdb;
	$table_name = $wpdb->prefix."neofix_sdl";
?>