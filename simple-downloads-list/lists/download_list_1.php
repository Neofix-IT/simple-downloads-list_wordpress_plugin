<?php
	function render_list_1($attr){
 
    $args = shortcode_atts( array(
     
            'language' => 'en',
            'category' => ''
 
        ), $attr );
 
		
		echo $args["lang"];
		
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
		
		require_once __DIR__ . "/../connection.php";
		
		wp_enqueue_style( 'neofix_sdt_style_1', plugins_url( '../style/style_1.css' , __FILE__ ));
		global $wpdb;


		$result;
		if($args["category"] == ""){
			$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");
		} else {
			$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE 
			AND category = '".$args["category"]."' ORDER BY id DESC");
		}
		
		echo  '
			<div id="neofix_sdt">
			<input type="text" id="neofix_sdt_search" onkeyup="myFunction()" placeholder="'.$search_label.'">
			<table id="neofix_sdt_table">
				<thead>
				  <tr>
					<th scope="col">'.$name_label.'</th>
					<th scope="col">'.$description_label.'</th>
					<th scope="col"></th>
				  </tr>
				</thead>
				<tbody>
				';
		foreach($result as $row){
			echo '
				<tr>
				<td class="column_1" data-label="'.$name_label.'">'.(empty($row->name) ? '&nbsp;' : $row->name).'</td>
				<td class="column_2" data-label="'.$description_label.'">'.(empty($row->description) ? '&nbsp;' : $row->description).'</td>
				<td class="column_3"><a class="sdt_download" href="'.(empty($row->download) ? '#' : $row->download).'">Download</button></td>
				</tr>
				';
		}
		echo '
				</tbody>
			  </table>
			</div>
			
			<script>
		function myFunction() {
		  // Declare variables
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById("neofix_sdt_search");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("neofix_sdt_table");
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
	}

	function startsWith ($string, $startString)
	{
		$len = strlen($startString);
		return (substr($string, 0, $len) === $startString);
	}
?>