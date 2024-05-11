<?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'neofix_sdl';

    $category = esc_sql($category);

    $result;
    if($category == ""){
        $result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");
    } else {
        $result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE 
        AND category = '".$category."' ORDER BY id DESC");
    }

?>

<div id="neofix_sdl" <?php echo get_block_wrapper_attributes(); ?>>
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
            foreach($result as $row){
            ?>
            <tr>
            <td class="column_1" data-label="<?php echo __('Name', 'simple-downloads-list') ?>"><?php echo (empty($row->name) ? '&nbsp;' : esc_html($row->name)) ?></td>
            <td class="column_2" data-label="<?php __('Description', 'simple-downloads-list') ?>"><?php echo (empty($row->description) ? '&nbsp;' : nl2br(esc_html($row->description))) ?></td>
            <td class="column_3"><a class="sdl_download" href="'<?php (empty($row->download) ? '#' : esc_html($row->download)) ?>'" download>Download</button></td>
            </tr>
            <?php
            }
            if( count($result) == 0 ){
            ?>
            <tr>
            <td colspan="3" class="no-data" style="text-align: center;"><p><?php echo __('No downloads available', 'simple-downloads-list') ?></p></td>
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
		for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = "";
			} else {
			tr[i].style.display = "none";
			}
		}
		}
	}
	setRowColor();
</script>
