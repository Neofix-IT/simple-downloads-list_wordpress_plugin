<?php

class NeofixSdlAdminpanel{
    function __construct(){
        add_action( 'admin_menu', array( $this, 'add_admin_menu_page' ) );
    }

    function add_admin_menu_page(){
        add_menu_page( 'Simple Download List', 'Simple downloads list', 'manage_options', 'sdl-adminpanel', array( $this, 'render_adminpanel' ) );
    }

    function render_adminpanel(){
        
    }
}



?>