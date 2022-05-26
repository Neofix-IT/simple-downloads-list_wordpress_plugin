<?php

require_once "adminpanel_backend.php";

function neofix_sdl_render_admin_panel(){
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
					<div style="padding: 20px;margin: 0px 50px; text-align: center; background-color: #DCDCDC;">
		<p style="font-size: 20px;">How to use</p>
		<p><b>Simply add shortcode:<br>[neofix_sdl category="category_name" language="language"]</b></p>
		<p><b>category:</b> Name of the category to filter<br>
		<b>language:</b> Language of the plugin. Currently available: "en" and "de"</p>
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
		<td>'.esc_html($row->download).'</td>
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