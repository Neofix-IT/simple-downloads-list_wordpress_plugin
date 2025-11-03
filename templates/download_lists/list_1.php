<?php
global $wpdb;
$table_name = $wpdb->prefix . 'neofix_sdl';

if ($category == "") {
    $query = "SELECT * FROM `$table_name` WHERE deleted IS false  ORDER BY id DESC";
} else {
    $query = $wpdb->prepare("SELECT * FROM `$table_name` WHERE deleted IS false AND category=%s ORDER BY id DESC", $category);
}

$result = $wpdb->get_results($query);
?>

<div id="neofix_sdl" <?php echo $block_wrapper_attributes ?? ''; ?>>
    <input type="text" id="neofix_sdl_search" onkeyup="filterSDL()" placeholder="<?php echo __('Search...', 'simple-downloads-list') ?>">
    <table id="neofix_sdl_table">
        <thead>
            <tr>
                <th scope="col"><?php echo __('Name', 'simple-downloads-list') ?></th>
                <th scope="col"><?php echo __('Description', 'simple-downloads-list') ?></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $row) {
            ?>
                <tr>
                    <td class="column_1" data-label="<?php echo __('Name', 'simple-downloads-list') ?>"><?php echo (empty($row->name) ? '&nbsp;' : esc_html($row->name)) ?></td>
                    <td class="column_2" data-label="<?php __('Description', 'simple-downloads-list') ?>"><?php echo (empty($row->description) ? '&nbsp;' : nl2br(esc_html($row->description))) ?></td>
                    <td class="column_3">
                        <a class="sdl_download" href="<?php echo empty($row->download) ? '#' : esc_url($row->download); ?>" download>
                            <?php echo __('Download', 'simple-downloads-list'); ?>
                        </a>
                    </td>

                </tr>
            <?php
            }
            if (count($result) == 0) {
            ?>
                <tr>
                    <td colspan="3" class="no-data" style="text-align: center;">
                        <p><?php echo __('No downloads available', 'simple-downloads-list') ?></p>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    function filterSDL() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("neofix_sdl_search");
        filter = input.value.toUpperCase();
        table = document.getElementById("neofix_sdl_table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who dont match the search query
        for (let i = 1; i < tr.length; i++) {
            const td1 = tr[i].getElementsByTagName("td")[0]; // Column 1
            const td2 = tr[i].getElementsByTagName("td")[1]; // Column 2

            const txt1 = td1 ? td1.textContent || td1.innerText : "";
            const txt2 = td2 ? td2.textContent || td2.innerText : "";

            if (
                txt1.toUpperCase().indexOf(filter) > -1 ||
                txt2.toUpperCase().indexOf(filter) > -1
            ) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>