<?php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<div class="table-editor">
    <button class="add-btn sdl-btn"><?php echo __('Add Download', 'simple-downloads-list') ?></button>
    <table id="data-table">
        <thead>
            <tr>
                <th style="width: 200px"><?php echo __('Name', 'simple-downloads-list') ?></th>
                <th style="width: auto"><?php echo __('Description', 'simple-downloads-list') ?></th>
                <th style="width: 10%"><?php echo __('Category', 'simple-downloads-list') ?></th>
                <th style="width: 15%"><?php echo __('Download', 'simple-downloads-list') ?></th>
                <th style="width: 230px"><?php echo __('Actions', 'simple-downloads-list') ?></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="popupOverlay" style="display: none;">
        <div class="popupBox">
            <h2 class="popup-title">Popup Title</h2>
            <p class="popup-subtitle">This is a simple popup message.</p>
            <form>
                <input type="hidden" id="id" name="id">

                <label for="name"><?php echo __('Name', 'simple-downloads-list') ?>:</label>
                <input type="text" id="name" name="name" required>

                <label for="description"><?php echo __('Description', 'simple-downloads-list') ?>:</label>
                <textarea id="description" name="description"></textarea>

                <label for="category"><?php echo __('Category', 'simple-downloads-list') ?>:</label>
                <input type="text" id="category" name="category">

                <div class="download-selection">
                    <div class="input">
                        <label for="download"><?php echo __('Download link', 'simple-downloads-list') ?>:</label>
                        <input type="url" id="download" name="download" required>
                    </div>
                    <span class="gallery-picker"><?php echo __('Select', 'simple-downloads-list') ?></span>
                </div>
            </form>
            <div class="popup-actions">
                <button class="cancel-btn sdl-btn"><?php echo __('Cancel', 'simple-downloads-list') ?></button>
                <button class="save-btn sdl-btn"><?php echo __('Save', 'simple-downloads-list') ?></button>
            </div>
        </div>
    </div>
</div>