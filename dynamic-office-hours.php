<?php
/**
 * Plugin Name: Dynamic Office Hours
 * Description: Generate the office hours of your business for each week dynamically. You can account for holidays or any other specified day of the year. Just pick your preferences and insert the generated shortcode!
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            TJ Hume
 * Author URI:        https://tjhumedesign.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

define('TJDOH_PLUGIN_DIR', dirname(__FILE__));

include_once (TJDOH_PLUGIN_DIR . '/includes/handle-settings-form.php');

function tjdoh_scripts_styles($hook_suffix) {
    if($hook_suffix != 'toplevel_page_dynamic_office_hours') {
        return;
    }

    wp_enqueue_style( 'tjdoh-settings-style', plugin_dir_url( __FILE__ ) . '/assets/css/settings.css' );
}
add_action( 'admin_enqueue_scripts', 'tjdoh_scripts_styles' );

add_action('admin_menu', 'tjdoh_create_plugin_settings_page');
function tjdoh_create_plugin_settings_page() {
    $page_title = 'Dynamic Office Hours';
    $menu_title = 'Dynamic Office Hours';
    $capability = 'manage_options';
    $slug = 'dynamic_office_hours';
    $callback = 'tjdoh_plugin_settings_page_content';
    $icon = 'dashicons-clock';
    $position = 100;

    add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
}


function tjdoh_plugin_settings_page_content() {
    if( $_POST['updated'] === 'true' ){
        if(
            ! isset( $_POST['tjdoh_form'] ) ||
            ! wp_verify_nonce( $_POST['tjdoh_form'], 'tjdoh_update' )
        ){ ?>
            <div class="error">
               <p>Sorry, your nonce was not correct. Please try again.</p>
            </div> <?php
            exit;
        } else {
            tjdoh_handle_form();
        }
    }

    include_once (TJDOH_PLUGIN_DIR . '/includes/settings-form.php');
}

function tjdoh_hours_shortcode() { 
	include_once (TJDOH_PLUGIN_DIR . '/includes/hours-display.php');
} 
add_shortcode('tjdoh-hours', 'tjdoh_hours_shortcode');
