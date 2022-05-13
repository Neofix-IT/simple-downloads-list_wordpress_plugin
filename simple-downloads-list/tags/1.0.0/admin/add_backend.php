<?php
    
    // Basic example of PHP script to handle with jQuery-Tabledit plug-in.
    // Note that is just an example. Should take precautions such as filtering the input data.
    
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die("Nothing to see here");
    
    // PHP QUESTION TO MYSQL DB
    
    // Connect to DB
    
    /*  Your code for new connection to DB*/
  	include __DIR__ . "/../connection.php";
    
    // Php question
    global $edata;
    
    /*  Your code for insert data to DB */
    $wpdb->query("INSERT INTO ".$table_name." (`id`, `name`, `description`, `category`, `download`, `deleted`) VALUES (NULL, NULL, NULL, NULL, NULL, false);");
    
    $result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");
    
	foreach($result as $row){
		$edata .= '
		<tr>
		<td>'.esc_html($row->id).'</td>
		<td>'.esc_html($row->name).'</td>
		<td>'.esc_html($row->description).'</td>
		<td>'.esc_html($row->category).'</td>
		<td>'.esc_html($row->download).'</td>
		</tr>
		';
	}
    
    // RETURN OUTPUT
    echo $edata;
    
    ?>
 
