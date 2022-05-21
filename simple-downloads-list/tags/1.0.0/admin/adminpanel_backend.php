<?php 

add_action('wp_ajax_neofix_sdl_add', 'neofix_sdl_admin_backend_add');
function neofix_sdl_admin_backend_add(){
    global $wpdb;
    $table_name = $wpdb->prefix . "neofix_sdl";
    $wpdb->query("INSERT INTO ".$table_name." (`id`, `name`, `description`, `category`, `download`, `deleted`) VALUES (NULL, NULL, NULL, NULL, NULL, false);");

    $result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");

    $data = '';
    foreach($result as $row){
        $data .= '
        <tr>
        <td>'.$row->id.'</td>
        <td>'.$row->name.'</td>
        <td>'.$row->description.'</td>
        <td>'.$row->category.'</td>
        <td>'.$row->download.'</td>
        </tr>
        ';
    }
    echo esc_html($data);
    wp_die();
}

add_action('wp_ajax_neofix_sdl_edit', 'neofix_sdl_admin_backend_edit');
function neofix_sdl_admin_backend_edit(){

    // sanitize input
    $id = intval($_POST['id']);
    if(!$id || $id <= 0){
        wp_send_json_error('ID is not valid');
    }
    else{
        $data = array(  'name' => sanitize_text_field( $_POST['name'] ),
                        'description' => sanitize_textarea_field( $_POST['description'] ),
                        'category' => sanitize_text_field( $_POST['category'] ),
                        'download' => sanitize_text_field( $_POST['download'] )
        );

        // update data
        global $wpdb;
        $table_name = $wpdb->prefix . "neofix_sdl";

        if($wpdb->update($table_name, $data, array('id' => $id))){
        wp_send_json_success('Data updated');
        } else{
        wp_send_json_error('Data not updated');
        }
    }
    wp_die();
}

add_action('wp_ajax_neofix_sdl_delete', 'neofix_sdl_admin_backend_delete');
function neofix_sdl_admin_backend_delete(){
    // sanitize input
    $id = intval($_POST['id']);
    if(!$id || $id <= 0){
        wp_send_json_error('ID is not valid');
    }
    else{
        $data = array(  'deleted' => 1);

        // update data
        global $wpdb;
        $table_name = $wpdb->prefix . "neofix_sdl";

        if($wpdb->update($table_name, $data, array('id' => $id))){
        wp_send_json_success('Data updated');
        } else{
        wp_send_json_error('Data not updated');
        }
    }
    wp_die();
}


add_action('wp_ajax_neofix_sdl_restore', 'neofix_sdl_admin_backend_restore');
function neofix_sdl_admin_backend_restore(){
    // sanitize input
    $id = intval($_POST['id']);
    if(!$id || $id <= 0){
        wp_send_json_error('ID is not valid');
    }
    else{
        $data = array(  'deleted' => 0);

        // update data
        global $wpdb;
        $table_name = $wpdb->prefix . "neofix_sdl";

        if($wpdb->update($table_name, $data, array('id' => $id))){
        wp_send_json_success('Data updated');
        } else{
        wp_send_json_error('Data not updated');
        }
    }
    wp_die();
}

?>