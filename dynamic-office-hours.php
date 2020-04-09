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

function tjdoh_scripts_styles(){
    wp_enqueue_style( 'tjdoh-settings-style', plugin_dir_url( __FILE__ ) . '/assets/css/settings.css' );
    wp_enqueue_script( 'tjdoh-settings-script', plugin_dir_url( __FILE__ ) . '/assets/js/settings.js' );
}

/**
 * Create settings pages
 */
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

    // Register the hidden submenu.
    add_submenu_page(
        'dynamic_office_hours' // Use the parent slug as usual.
        , 'Dynamic Office Hours'
        , ''
        , 'manage_options'
        , 'dynamic_office_hours_daily'
        , 'tjdoh_daily_settings_page_content'
    );
}

/**
 * Hide the hidden submenu
 */
add_filter( 'submenu_file', 'tjdoh_submenu_filter' );
function tjdoh_submenu_filter( $submenu_file ) {
    global $plugin_page;

    // Hide the submenu.
    remove_submenu_page( 'dynamic_office_hours', 'dynamic_office_hours' );
    remove_submenu_page( 'dynamic_office_hours', 'dynamic_office_hours_daily' );

    return $submenu_file;
}

/**
 * General settings
 */
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
    tjdoh_scripts_styles();
    include_once (TJDOH_PLUGIN_DIR . '/includes/settings-form.php');
}

/**
 * Daily settings
 */
function tjdoh_daily_settings_page_content() {
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
            tjdoh_handle_daily_form();
        }
    }
    tjdoh_scripts_styles();
    include_once (TJDOH_PLUGIN_DIR . '/includes/daily-settings-form.php');
}

function tjdoh_hours_shortcode() { 
	include_once (TJDOH_PLUGIN_DIR . '/includes/hours-display.php');
} 
add_shortcode('tjdoh-hours', 'tjdoh_hours_shortcode');


//Functions

function tjdoh_the_days(){
    $start_day = get_option('start_of_week');
    $week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    for($i = $start_day; $i > 0; $i--){
        $shift_day = $week[0];
        array_shift($week);
        array_push($week, $shift_day);
    }
    
    for($i = 0; $i < count($week); $i++){
        echo '
            <tbody>
                <tr>
                    <th><label>'.$week[$i].' Start Time</label></th>
                    <td>
                        <select name="'.$week[$i].'-start-hour" id="'.$week[$i].'-start-hour">
                            '.tjdoh_get_hours($week[$i].'-start-hour').'
                        </select>
                        :
                        <select name="'.$week[$i].'-start-minute" id="'.$week[$i].'-start-minute">
                            '.tjdoh_get_minutes($week[$i].'-start-minute').'
                        </select>
                        <select name="'.$week[$i].'-start-ampm" id="'.$week[$i].'-start-ampm">'.tjdoh_get_ampm($week[$i].'-start-ampm').'</select>
                    </td>
                </tr>
                <tr>
                    <th><label>'.$week[$i].' End Time</label></th>
                    <td>
                        <select name="'.$week[$i].'-end-hour" id="'.$week[$i].'-end-hour">
                            '.tjdoh_get_hours($week[$i].'-end-hour').'
                        </select>
                        :
                        <select name="'.$week[$i].'-end-minute" id="'.$week[$i].'-end-minute">
                            '.tjdoh_get_minutes($week[$i].'-end-minute').'
                        </select>
                        <select name="'.$week[$i].'-end-ampm" id="'.$week[$i].'-end-ampm">'.tjdoh_get_ampm($week[$i].'-end-ampm').'</select>
                    </td>
                </tr>
            </tbody>
        ';
    }
}

function tjdoh_get_minutes($field){
    $selectedVal = get_option($field);
    if($selectedVal === false){
        $selectedVal = 0;
    }
    $str = '';
    for($i = 0; $i < 60; $i++){
        $min = $i;
        $min = sprintf("%02d", $min);
        if($i == $selectedVal){
            $str .= ('<option selected value="'.$min.'">'.$min.'</option>');
        }else{
            $str .= ('<option value="'.$min.'">'.$min.'</option>');
        }
    }
    
    return $str;
}

function tjdoh_get_hours($field){
    $selectedVal = get_option($field);
    if($selectedVal === false){
        $selectedVal = 12;
    }
    $str = '' . $selectedVal;
    for($i = 1; $i < 13; $i++){
        $hour = $i;
        if($i == $selectedVal){
            $str .= ('<option selected value="'.$hour.'">'.$hour.'</option>');
        }else{
            $str .= ('<option value="'.$hour.'">'.$hour.'</option>');
        }
    }

    return $str;
}

function tjdoh_get_ampm($field){
    $selectedVal = get_option($field);
    if($selectedVal === false){
        $selectedVal = 'am';
    }

    if($selectedVal === 'am'){
        return '
            <option selected value="am">AM</option>
            <option value="pm">PM</option>
        ';
    }else{
        return '
            <option value="am">AM</option>
            <option selected value="pm">PM</option>
        ';
    }
}

function tjdoh_form_err($str){
    echo '
    <div class="error">
        <p>'.$str.'</p>
    </div>
    ';
}

function tjdoh_form_success($str){
    echo '
    <div class="updated">
        <p>'.$str.'</p>
    </div>
    ';
}