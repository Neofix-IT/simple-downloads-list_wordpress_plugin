<?php

class NeofixSdlEditor
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
        add_action('admin_menu', [$this, 'add_admin_menu_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    function enqueue_admin_assets($hook)
    {
        // Only load on your custom admin page
        if ($hook !== 'toplevel_page_sdl-adminpanel') {
            return;
        }

        // Load fontawesome
        wp_enqueue_style(
            'sdl-fontawesome',
            NEOFIX_SDL_PATH . 'dist/fontawesome/fontawesome-7.1.0/css/all.min.css',
            [],
            '7.1.0'
        );

        // Admin styles
        $style_asset_path = NEOFIX_SDL_PATH_LOCAL . '/dist/admin/admin-styles.asset.php';
        $style_asset = require($style_asset_path);
        wp_enqueue_style(
            'sdl-admin-style',
            NEOFIX_SDL_PATH . 'dist/admin/admin-styles.css',
            $style_asset['dependencies'],
            $style_asset['version']
        );

        // Admin scripts
        $script_asset_path = NEOFIX_SDL_PATH_LOCAL . '/dist/admin/admin-scripts.asset.php';
        $script_asset = require($script_asset_path);

        wp_enqueue_script(
            'sdl-admin-script',
            NEOFIX_SDL_PATH . 'dist/admin/admin-scripts.js',
            $script_asset['dependencies'],
            $script_asset['version'],
            true // Load in footer
        );

        // Enqueue media uploader, required for media selection
        wp_enqueue_media();

        // Pass rest-url to script.js
        wp_localize_script('sdl-admin-script', 'sdlRest', array(
            'rest_url' => esc_url_raw(rest_url('neofix-sdl/v1/')),
            'nonce'    => wp_create_nonce('wp_rest')
        ));
    }


    public function register_routes()
    {
        register_rest_route('neofix-sdl/v1', '/all', [
            'methods' => 'GET',
            'callback' => [$this, 'get_all_downloads'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);

        register_rest_route('neofix-sdl/v1', '/add', [
            'methods' => 'POST',
            'callback' => [$this, 'add_download'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);

        register_rest_route('neofix-sdl/v1', '/edit', [
            'methods' => 'POST',
            'callback' => [$this, 'edit_download'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);

        register_rest_route('neofix-sdl/v1', '/delete', [
            'methods' => 'POST',
            'callback' => [$this, 'delete_download'],
            'permission_callback' => [$this, 'check_permissions'],
        ]);
    }


    public function check_permissions()
    {
        return current_user_can('manage_options');
    }

    public function add_admin_menu_page()
    {
        add_menu_page('Simple Download List', 'Simple downloads list', 'manage_options', 'sdl-adminpanel', [$this, 'render_adminpanel']);
    }

    public function render_adminpanel()
    {
        include NEOFIX_SDL_PATH_LOCAL . "/templates/adminpanel.php";
    }

    public function get_all_downloads(WP_REST_Request $request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "neofix_sdl";

        $results = $wpdb->get_results("SELECT * FROM `$table_name` WHERE deleted IS FALSE ORDER BY id DESC");

        $downloads = array_map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'description' => $row->description,
                'category' => $row->category,
                'download' => $row->download,
            ];
        }, $results);

        return rest_ensure_response($downloads);
    }

    public function add_download(WP_REST_Request $request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "neofix_sdl";

        // Get and sanitize JSON body values
        $params = $request->get_json_params();
        $name = isset($params['name']) ? sanitize_text_field($params['name']) : null;
        $description = isset($params['description']) ? sanitize_textarea_field($params['description']) : null;
        $category = isset($params['category']) ? sanitize_text_field($params['category']) : null;
        $download = isset($params['download']) ? esc_url_raw($params['download']) : null;

        // Insert sanitized values using prepared statement
        $wpdb->insert(
            $table_name,
            [
                'name' => $name,
                'description' => $description,
                'category' => $category,
                'download' => $download,
                'deleted' => false,
            ],
            [
                '%s', // name
                '%s', // description
                '%s', // category
                '%s', // download
                '%d', // deleted
            ]
        );

        // Retrieve the latest inserted row
        $latest = $wpdb->get_row("SELECT * FROM `$table_name` WHERE deleted = 0 ORDER BY id DESC LIMIT 1");

        return rest_ensure_response(["success" => "Data inserted", "data" => $latest]);
    }


    public function edit_download(WP_REST_Request $request)
    {
        $id = intval($request->get_param('id'));
        if (!$id || $id <= 0) {
            return new WP_REST_Response(['error' => 'ID is not valid'], 400);
        }

        $data = [
            'name' => sanitize_text_field($request->get_param('name')),
            'description' => sanitize_textarea_field($request->get_param('description')),
            'category' => sanitize_text_field($request->get_param('category')),
            'download' => esc_url_raw($request->get_param('download')),
        ];

        global $wpdb;
        $table_name = $wpdb->prefix . "neofix_sdl";

        $updated = $wpdb->update($table_name, $data, ['id' => $id]);

        return rest_ensure_response($updated ? ['success' => 'Data updated'] : ['error' => 'Data not updated']);
    }

    public function delete_download(WP_REST_Request $request)
    {
        $id = intval($request->get_param('id'));
        if (!$id || $id <= 0) {
            return new WP_REST_Response(['error' => 'ID is not valid'], 400);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . "neofix_sdl";
        $updated = $wpdb->update($table_name, ['deleted' => 1], ['id' => $id]);

        return rest_ensure_response($updated ? ['success' => 'Data updated'] : ['error' => 'Data not updated']);
    }
}

new NeofixSdlEditor();
