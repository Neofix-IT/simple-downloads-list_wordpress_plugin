<?php
	function render_admin_panel(){
		// enqueue scripts
		wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js');
		wp_enqueue_script( 'neofix_sdl_tabledit', plugins_url('jquery.tabledit.min.js', __FILE__), array('jquery', 'bootstrap'));
		wp_enqueue_script( 'neofix_sdl_admin', plugins_url('sdl.js', __FILE__), array('jquery', 'neofix_sdl_tabledit'));
		
		// enqueue styles
		wp_enqueue_style( 'font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css');
		wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css', array('font_awesome'));
		
		// localize api url
		wp_localize_script('neofix_sdl_admin', 'neofix_sdl_folder', array('pluginsUrl' => plugins_url()."/simple-downloads-list"));

		
		

		require_once __DIR__ . "/../connection.php";
		$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");

 		echo '
		<body>
			<div style="padding: 20px;">
				<h1 style="text-align:center;">Simple downloads list</h1>
						<div style="padding: 20px;margin: 0px 50px; text-align: center; background-color: #DCDCDC;">
			<p style="font-size: 20px;">How to use</p>
			<b>Simply add shortcode: [neofix_sdl category="category_name" language="language"]</b><br><br>
			<b>category:</b> Name of the category to filter<br>
			<b>language:</b> Language of the plugin. Currently available: "en" and "de"
		</div>
				<div class="row" style="padding: 20px;">
				  <div class="col-md-12 m-b-20">
					<input type="button" value="Add row" id="addRow10" class="btn btn-info pull-right">
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