<?php
function neofix_sdl_render_list_1($attr){

	global $wpdb;
	$table_name = $wpdb->prefix . 'neofix_sdl';

	$args = shortcode_atts( array(
		'language' => 'en',
		'category' => ''
	), $attr );
	
	$name_label;
	$description_label;
	$search_label;
	if( $args["language"] == "de" ){
		$name_label = "Name";
		$description_label = "Beschreibung";
		$search_label = "🔎︎  Suchen...";
	} else {
		$name_label = "Name";
		$description_label = "Description";
		$search_label = "🔎︎  Search...";
	}
	
	wp_enqueue_style( 'neofix_sdl_style_1', plugins_url( '../style/style_1.css' , __FILE__ ));

	$result;
	if($args["category"] == ""){
		$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");
	} else {
		$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE 
		AND category = '".$args["category"]."' ORDER BY id DESC");
	}
	
	$data = '
		<div id="neofix_sdl">
		<input type="text" id="neofix_sdl_search" onkeyup="myFunction()" placeholder="'.$search_label.'">
		<table id="neofix_sdl_table">
			<thead>
				<tr>
				<th scope="col">'.esc_html($name_label).'</th>
				<th scope="col">'.esc_html($description_label).'</th>
				<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
			';
	foreach($result as $row){
		$data .= '
			<tr>
			<td class="column_1" data-label="'.esc_html($name_label).'">'.(empty($row->name) ? '&nbsp;' : esc_html($row->name)).'</td>
			<td class="column_2" data-label="'.esc_html($description_label).'">'.(empty($row->description) ? '&nbsp;' : nl2br(esc_html($row->description))).'</td>
			<td class="column_3"><a class="sdl_download" href="'.(empty($row->download) ? '#' : esc_html($row->download)).'" download>Download</button></td>
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