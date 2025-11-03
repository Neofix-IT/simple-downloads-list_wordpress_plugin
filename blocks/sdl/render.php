<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

if (!function_exists('neofix_sdl_get_downloads')) {
    function neofix_sdl_get_downloads($attr)
    {
        $category = $attr['category'] ?? "";

        ob_start();
        $block_wrapper_attributes = get_block_wrapper_attributes();
        include NEOFIX_SDL_PATH_LOCAL . '/templates/download_lists/list_1.php';
        echo ob_get_clean();
    }
}

neofix_sdl_get_downloads($attributes);
