<div class="wrap">
    <h2>Dynamic Office Hours</h2>
    <form class="tjdoh-form" method="POST">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field( 'tjdoh_update', 'tjdoh_form' ); ?>
        <table class="form-table">
            <div class="tabs">
                <a href="?page=dynamic_office_hours">General Settings</a>
                <a class="active" href="?page=dynamic_office_hours_daily">Daily Settings</a>
            </div>
            <?php tjdoh_the_days(); ?>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>
</div>

<?php

// Functions

function tjdoh_the_days(){
    $start_day = get_option('start_of_week');
    $week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    for($i = $start_day; $i > 0; $i--){
        $shift_day = $week[0];
        array_shift($week);
        array_push($week, $shift_day);
    }
    
    for($i = 0; $i < count($week); $i++){
        $name = $week[$i];
        $week[$i] = strtolower($week[$i]);
        $disabled_str = '';
        $chk_typical = '';
        $chk_different = '';
        $chk_closed = '';
        $option = get_option($week[$i].'-options');
        if($option == null || $option === 'typical-times'){
            $disabled_str = ' disabled';
            $chk_typical = ' checked';
        }
        else if($option === 'different-times'){
            $chk_different = ' checked';
        }
        else{
            $chk_closed = ' checked';
        }

        echo '
            <tbody>
                <tr>
                    <th><label>'.$name.' Options</label></th>
                    <td>
                        <fieldset class="radios">
                            <label for="'.$week[$i].'-typical-times"><input class="typical-times" value="typical-times" type="radio" id="'.$week[$i].'-typical-times" name="'.$week[$i].'-options"'.$chk_typical.'>Use typical times</label><br>
                            <label for="'.$week[$i].'-closed"><input class="closed" value="closed" type="radio" id="'.$week[$i].'-closed" name="'.$week[$i].'-options"'.$chk_closed.'>Closed</label><br>
                            <label for="'.$week[$i].'-different-times"><input class="different-times" value="different-times" type="radio" id="'.$week[$i].'-different-times" name="'.$week[$i].'-options"'.$chk_different.'>Use different times</label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th><label>'.$name.' Open Time</label></th>
                    <td>
                        <select name="'.$week[$i].'-open-hour" id="'.$week[$i].'-open-hour"'.$disabled_str.'>
                            '.tjdoh_get_hours($week[$i].'-open-hour').'
                        </select>
                        :
                        <select name="'.$week[$i].'-open-minute" id="'.$week[$i].'-open-minute"'.$disabled_str.'>
                            '.tjdoh_get_minutes($week[$i].'-open-minute').'
                        </select>
                        <select name="'.$week[$i].'-open-ampm" id="'.$week[$i].'-open-ampm"'.$disabled_str.'>'.tjdoh_get_ampm($week[$i].'-open-ampm').'</select>
                    </td>
                </tr>
                <tr>
                    <th><label>'.$name.' Close Time</label></th>
                    <td>
                        <select name="'.$week[$i].'-close-hour" id="'.$week[$i].'-close-hour"'.$disabled_str.'>
                            '.tjdoh_get_hours($week[$i].'-close-hour').'
                        </select>
                        :
                        <select name="'.$week[$i].'-close-minute" id="'.$week[$i].'-close-minute"'.$disabled_str.'>
                            '.tjdoh_get_minutes($week[$i].'-close-minute').'
                        </select>
                        <select name="'.$week[$i].'-close-ampm" id="'.$week[$i].'-close-ampm"'.$disabled_str.'>'.tjdoh_get_ampm($week[$i].'-close-ampm').'</select>
                    </td>
                </tr>
            </tbody>
        ';
    }
}