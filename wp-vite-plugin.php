<?php
/**
 * Plugin Name: Vite Integration for WordPress
 * Plugin URI: https://dontbrickyourwebsite.com
 * Description: Integrates Vite for efficient handling of SCSS and JavaScript in WordPress and bicksbuilder.
 * Version: 1.0.0
 * Author: David O'Connell
 * License: GPL3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function dbyw_vite_assets_enqueue() {

    if (get_option('dev_mode') == 1) {
        $dev_server = 'http://localhost:3000'; // URL of your Vite server
        wp_enqueue_script('dbyw_vite_hot_module_reload', $dev_server . '/@vite/client', [], null, true);
        wp_enqueue_script('dbyw_vite_main_js', $dev_server . '/assets/src/js/main.js', [], null, true);
    } 
    
    if (get_option('dev_mode') == 0){
        $manifest_file = plugin_dir_path(__FILE__) . 'assets/dist/manifest.json';
        if (file_exists($manifest_file)) {
            $manifest = json_decode(file_get_contents($manifest_file), true);
            $main_js_file = 'main.js';
            $main_css_file = 'main.css';

            foreach ($manifest as $key => $value) {
                if (strpos($key, 'main.js') !== false) {
                    $main_js_file = $value['file'];
                } elseif (strpos($key, 'main.css') !== false) {
                    $main_css_file = $value['file'];
                }
            }

            $main_js_path = plugin_dir_path(__FILE__) . 'assets/dist/' . $main_js_file;
            $main_css_path = plugin_dir_path(__FILE__) . 'assets/dist/' . $main_css_file;

            if (file_exists($main_css_path)) {
                wp_enqueue_style('dbyw_vite_plugin_styles', plugin_dir_url(__FILE__) . 'assets/dist/' . $main_css_file, array('bricks-frontend', 'bricks-admin'));
            }

            if (file_exists($main_js_path)) {
                wp_enqueue_script('dbyw_vite_plugin_scripts', plugin_dir_url(__FILE__) . 'assets/dist/' . $main_js_file, array(), false, true);
            }
        }   
    }
}


// prevent css and js in Bricks Builder
if (!function_exists('bricks_is_builder') || !bricks_is_builder()) {
        add_action('wp_enqueue_scripts', 'dbyw_vite_assets_enqueue');
}


function dbyw_vite_add_module_type_attribute($tag, $handle, $src) {
    $scripts_with_module_type = array('dbyw_vite_hot_module_reload', 'dbyw_vite_main_js');
    foreach ($scripts_with_module_type as $script) {
        if ($script === $handle) {
            return '<script type="module" src="' . esc_url($src) . '"></script>';
        }
    }
    return $tag;
}
add_filter('script_loader_tag', 'dbyw_vite_add_module_type_attribute', 10, 3);

add_action('admin_menu', 'dbyw_vite_plugin_admin_menu');

function dbyw_vite_plugin_admin_menu() {
    add_menu_page(
        'Vite Integration Settings',
        'Vite Integration',
        'manage_options',
        'dbyw_vite_integration_settings',
        'dbyw_vite_plugin_settings_page',
        'dashicons-admin-generic',
        100
    );
}

function dbyw_vite_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Vite Integration Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('dbyw_vite_integration_settings_group'); ?>
            <?php do_settings_sections('dbyw_vite_integration_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Dev Mode</th>
                    <td><input type="checkbox" name="dev_mode" value="1" <?php checked(1, get_option('dev_mode'), true); ?> /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'dbyw_vite_plugin_settings_init');

function dbyw_vite_plugin_settings_init() {
    register_setting('dbyw_vite_integration_settings_group', 'dev_mode');
}



function check_if_bricks_builder_is_installed(){
    if (defined('BRICKS_VERSION')) {
        // If Bricks Builder is active, do nothing
        return true;
    }
}