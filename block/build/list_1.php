<div id="neofix_sdl">
    <input type="text" id="neofix_sdl_search" onkeyup="myFunction()" placeholder="<?php echo __('Search...', 'simple-downloads-list') ?>">
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
            <td class="column_2" data-label="<?php __('Description', 'simple-downloads-list') ?>">'.(empty($row->description) ? '&nbsp;' : nl2br(esc_html($row->description))).'</td>
            <td class="column_3"><a class="sdl_download" href="'.(empty($row->download) ? '#' : esc_html($row->download)).'" download>Download</button></td>
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
	function myFunction() {
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
