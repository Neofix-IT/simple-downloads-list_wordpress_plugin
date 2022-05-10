<?php
	function render_admin_panel(){
		wp_enqueue_script( 'fff', plugins_url( 'jquery.tabledit.min.js' , __FILE__ ), array("jquery"));
		wp_enqueue_script( 'gg_loader', plugins_url( 'sdl.js' , __FILE__ ), array("jquery"));
		wp_localize_script('gg_loader', 'neofix_sdl_folder', array('pluginsUrl' => plugins_url()."/simple-downloads-list"));

		require_once __DIR__ . "/../connection.php";
		$result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");

 		echo '
			<head>  
				<title>Live Table Data Edit Delete using Tabledit Plugin in PHP</title>  
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
			</head>  
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
			<td>'.$row->id.'</td>
			<td>'.$row->name.'</td>
			<td>'.$row->description.'</td>
			<td>'.$row->category.'</td>
			<td>'.$row->download.'</td>
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