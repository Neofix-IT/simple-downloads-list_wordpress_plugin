<?php

class NeofixSdlAdminpanel{
    function __construct(){
        add_action( 'admin_menu', array( $this, 'add_admin_menu_page' ) );
    }

    function add_admin_menu_page(){
        add_menu_page( 'Simple Download List', 'Simple downloads list', 'manage_options', 'sdl-adminpanel', array( $this, 'render_adminpanel' ) );
    }

    function render_adminpanel(){
        require_once "render_adminpanel.php";
    }
    
    function add_download(){
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
    
    function edit_download(){
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


}

new NeofixSdlAdminpanel();

?>