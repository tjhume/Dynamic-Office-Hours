<?php

/**
 * Handle general settings form submission
 */
if(!function_exists('tjdoh_handle_form')){
    function tjdoh_handle_form(){

        // Get form input
        $typical_open_hour = sanitize_text_field( $_POST['typical-open-hour'] );
        $typical_open_minute = sanitize_text_field( $_POST['typical-open-minute'] );
        $typical_open_ampm = sanitize_text_field( $_POST['typical-open-ampm'] );
        $typical_close_hour = sanitize_text_field( $_POST['typical-close-hour'] );
        $typical_close_minute = sanitize_text_field( $_POST['typical-close-minute'] );
        $typical_close_ampm = sanitize_text_field( $_POST['typical-close-ampm'] );

        // Check for invalid submissions
        if(($typical_open_ampm !== 'am' && $typical_open_ampm !== 'pm') ||
        ($typical_close_ampm !== 'am' && $typical_close_ampm !== 'pm')){
            tjdoh_form_err('Invalid AM/PM Input');
            return;
        }

        // Update settings
        update_option('typical-open-hour', $typical_open_hour);
        update_option('typical-open-minute', $typical_open_minute);
        update_option('typical-open-ampm', $typical_open_ampm);
        update_option('typical-close-hour', $typical_close_hour);
        update_option('typical-close-minute', $typical_close_minute);
        update_option('typical-close-ampm', $typical_close_ampm);

        tjdoh_form_success('Your settings have been saved.');
    }
}

if(!function_exists('tjdoh_handle_daily_form')){
    function tjdoh_handle_daily_form(){
        $week = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');

        foreach($week as $day){

            // Get form input
            $day_option = sanitize_text_field( $_POST[$day.'-options'] );
            $use_different = false;
            if($day_option === 'different-times'){$use_different = true;}

            if($use_different){
                $day_open_hour = sanitize_text_field( $_POST[$day.'-open-hour'] );
                $day_open_minute = sanitize_text_field( $_POST[$day.'-open-minute'] );
                $day_open_ampm = sanitize_text_field( $_POST[$day.'-open-ampm'] );
                $day_close_hour = sanitize_text_field( $_POST[$day.'-close-hour'] );
                $day_close_minute = sanitize_text_field( $_POST[$day.'-close-minute'] );
                $day_close_ampm = sanitize_text_field( $_POST[$day.'-close-ampm'] );

                // Check for invalid submissions
                if(($day_open_ampm !== 'am' && $day_open_ampm !== 'pm') ||
                ($day_close_ampm !== 'am' && $day_close_ampm !== 'pm')){
                    tjdoh_form_err('Invalid AM/PM Input on '.$day);
                    return;
                }
            }

            // Update settings
            update_option($day.'-options', $day_option);

            // Update the open/close times if custom times is selected
            if($use_different){
                update_option($day.'-open-hour', $day_open_hour);
                update_option($day.'-open-minute', $day_open_minute);
                update_option($day.'-open-ampm', $day_open_ampm);
                update_option($day.'-close-hour', $day_close_hour);
                update_option($day.'-close-minute', $day_close_minute);
                update_option($day.'-close-ampm', $day_close_ampm);
            }
        }

        tjdoh_form_success('Your settings have been saved.');
    }
}

// Functions

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
