<?php
add_shortcode('neofix_sdl', 'neofix_sdl_render_list_1');

function neofix_sdl_render_list_1($attr){

	global $wpdb;
	$table_name = $wpdb->prefix . 'neofix_sdl';

	$args = shortcode_atts( array(
		'category' => ''
	), $attr );

	
	wp_enqueue_style( 'neofix_sdl_style_1', NEOFIX_SDL_PATH . '/lists/list_1/style.css' );

	$category = esc_sql( $args["category"] );

	if($category == ""){
		$query = "SELECT * FROM `$table_name` WHERE deleted IS false  ORDER BY id DESC";
	} else {
		$query = $wpdb->prepare("SELECT * FROM `$table_name` WHERE deleted IS false AND category=%s ORDER BY id DESC", $category);
	}
	$result = $wpdb->get_results($query);
 
	$data = '
		<div id="neofix_sdl">
		<input type="text" id="neofix_sdl_search" onkeyup="myFunction()" placeholder="'.__('Search...', 'simple-downloads-list').'">
		<table id="neofix_sdl_table">
			<thead>
				<tr>
				<th scope="col">'.__('Name', 'simple-downloads-list').'</th>
				<th scope="col">'.__('Description', 'simple-downloads-list').'</th>
				<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
			';
	foreach($result as $row){
		$data .= '
			<tr>
			<td class="column_1" data-label="'.__('Name', 'simple-downloads-list').'">'.(empty($row->name) ? '&nbsp;' : esc_html($row->name)).'</td>
			<td class="column_2" data-label="'.__('Description', 'simple-downloads-list').'">'.(empty($row->description) ? '&nbsp;' : nl2br(esc_html($row->description))).'</td>
			<td class="column_3"><a class="sdl_download" href="'.(empty($row->download) ? '#' : esc_html($row->download)).'" download>Download</button></td>
			</tr>
			';
	}
	if( count($result) == 0 ){
		$data .= '
			<tr>
			<td colspan="3" class="no-data" style="text-align: center;"><p>'.__('No downloads available', 'simple-downloads-list').'</p></td>
			</tr>
			';
	}
	$data .= '
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
		';
	return $data;
}
?>