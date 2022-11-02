<?php

require_once "adminpanel_backend.php";

function neofix_sdl_render_admin_panel(){
	// enqueue scripts for media selection
	wp_enqueue_media();
    wp_enqueue_script( 'neofix_sdl_media_selection', plugins_url( '/media_selection.js' , __FILE__ ), array('jquery'), '0.1' );

	// enqueue styles
	wp_enqueue_style( 'font_awesome', plugins_url('../includes/fontawesome-6.1.1-web/css/all.min.css', __FILE__));
	wp_enqueue_style( 'bootstrap', plugins_url('../includes/bootstrap-4.6.1-dist/css/bootstrap.min.css', __FILE__));

	// enqueue scripts
	wp_enqueue_script( 'bootstrap', plugins_url('../includes/bootstrap-4.6.1-dist/js/bootstrap.min.js', __FILE__));
	wp_enqueue_script( 'neofix_sdl_tabledit', plugins_url('jquery.tabledit.min.js', __FILE__), array('jquery', 'bootstrap'));
	wp_enqueue_script( 'neofix_sdl_admin', plugins_url('sdl.js', __FILE__), array('jquery', 'neofix_sdl_tabledit'));

	// Pass ajax_url to script.js
	wp_localize_script( 'neofix_sdl_admin', 'plugin_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	

	// Echo the HTML
	global $wpdb;
	$table_name = $wpdb->prefix . "neofix_sdl";

	$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");

	echo '
	<body>
		<div style="padding: 20px;">
			<h1 style="text-align:center;">Simple downloads list</h1>
			<div style="box-shadow: 1px 1px 3px; padding: 10px; border-radius: 5px; text-align: center; background-color: #DCDCDC;">
				<p style="font-size: 15px;"><b>How to use the Shortcode:</b></p>
				<p style="font-size: 15px; display: inline-block; padding: 5px 10px; background-color: #959595"><b>[neofix_sdl]</b></p>
				<p><b>Additional properties</b><br/>
				<b>category:</b> Name of the category to filter<br>
			</div>
			<div class="row" style="padding: 20px;">
				<div class="col-md-12 m-b-20">
				<input type="button" value="Add download" id="addRow10" class="btn btn-info pull-right" style="float: right">
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered" id="example10">
					<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Description</th>
						<th>Category</th>
						<th>Download</th>
					</tr>
					</thead>
					<tbody>';
	
	foreach($result as $row){
		echo '
		<tr>
		<td>'.esc_html($row->id).'</td>
		<td>'.esc_html($row->name).'</td>
		<td>'.esc_html($row->description).'</td>
		<td>'.esc_html($row->category).'</td>
		<td class="sdl_upload">'.esc_html($row->download).'</td>
		</tr>
		';
	}
						
	echo '
					</tbody>
					</table>
				</div>
				</div>
			</div>
		</div>
	</body>
	';
}	

?>