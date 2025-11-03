<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<div class="wrap full-width-admin-panel">
    <h1><?php echo __('Downloads editor', 'simple-downloads-list') ?></h1>
    <p><?php echo __('Enter or edit your downloads here. Click the pen icon to edit a download.', 'simple-downloads-list') ?></p>
    <?php include NEOFIX_SDL_PATH_LOCAL . '/templates/table_editor.php'; ?>
</div>