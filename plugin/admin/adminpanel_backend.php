<?php 

add_action('wp_ajax_neofix_sdl_add', 'neofix_sdl_admin_backend_add');
function neofix_sdl_admin_backend_add(){
    global $wpdb;
    $table_name = $wpdb->prefix . "neofix_sdl";
    $wpdb->query("INSERT INTO ".$table_name." (`id`, `name`, `description`, `category`, `download`, `deleted`) VALUES (NULL, NULL, NULL, NULL, NULL, false);");

    $result = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE deleted IS FALSE ORDER BY id DESC");
    
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

// Ajax action to retrieve the file url
add_action( 'wp_ajax_neofix_sdl_get_file_url', 'neofix_sdl_get_file_url'   );
function neofix_sdl_get_file_url() {
    if(isset($_GET['id']) ){
		$parsed = wp_get_attachment_url( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ) );
        wp_send_json_success( $parsed );
    } else {
        wp_send_json_error();
    }
}

?>