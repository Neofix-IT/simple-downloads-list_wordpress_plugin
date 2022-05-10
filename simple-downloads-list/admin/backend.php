<?php
    
    // Basic example of PHP script to handle with jQuery-Tabledit plug-in.
    // Note that is just an example. Should take precautions such as filtering the input data.
    
    header('Content-Type: application/json');
    
    // CHECK REQUEST METHOD
    if ($_SERVER['REQUEST_METHOD']=='POST') {
    $input = filter_input_array(INPUT_POST);
    } else {
    $input = filter_input_array(INPUT_GET);
    }
    
    // PHP QUESTION TO MYSQL DB
    
    // Connect to DB
    
    /*  Your code for new connection to DB*/
  	include __DIR__ . "/../connection.php";
    
    // Php question
    if ($input['action'] === 'edit') {
    
        // PHP code for edit actionv
       $input = $wpdb->get_results("UPDATE ".$table_name." SET name='" . $input['name'] . "', description='" . $input['description'] . "', category='" . $input['category'] . "', download='" . $input['download'] . "' WHERE id='" . $input['id'] . "'");
    
    } else if ($input['action'] === 'delete') {
    
        // PHP code for edit delete
        $input = $wpdb->get_results("UPDATE ".$table_name." SET deleted=1 WHERE id='" . $input['id'] . "'");
    
    } else if ($input['action'] === 'restore') {
    
        // PHP code for edit restore
        $input = $wpdb->get_results("UPDATE ".$table_name." SET deleted=0 WHERE id='" . $input['id'] . "'");
    
    } 
    
    // RETURN OUTPUT
    echo json_encode($input);
    
    ?>
 
 