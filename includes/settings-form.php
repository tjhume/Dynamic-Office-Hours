<div class="wrap">
    <h2>Dynamic Office Hours</h2>
    <form method="POST">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field( 'tjdoh_update', 'tjdoh_form' ); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label>Typical Starting Time</label></th>
                    <td>
                        <select name="typical-open-hour" id="typical-open-hour">
                            <?php echo tjdoh_get_hours('typical-open-hour'); ?>
                        </select>
                        :
                        <select name="typical-open-minute" id="typical-open-minute">
                            <?php echo tjdoh_get_minutes('typical-open-minute'); ?>
                        </select>
                        <select name="typical-open-ampm" id="typical-open-ampm">
                            <?php echo tjdoh_get_ampm('typical-open-ampm'); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>Typical Closing Time</label></th>
                    <td>
                        <select name="typical-close-hour" id="typical-close-hour">
                            <?php echo tjdoh_get_hours('typical-close-hour'); ?>
                        </select>
                        :
                        <select name="typical-close-minute" id="typical-close-minute">
                            <?php echo tjdoh_get_minutes('typical-close-minute'); ?>
                        </select>
                        <select name="typical-close-ampm" id="typical-close-ampm">
                            <?php echo tjdoh_get_ampm('typical-close-ampm'); ?>
                        </select>
                    </td>
                </tr>
            </tbody>
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
        echo '
            <tbody>
                <tr>
                    <th><label>'.$week[$i].' Start Time</label></th>
                    <td>
                        <select name="'.$week[$i].'-start-hour" id="'.$week[$i].'-start-hour">
                            '.tjdoh_get_hours().'
                        </select>
                        :
                        <select name="'.$week[$i].'-start-minute" id="'.$week[$i].'-start-minute">
                            '.tjdoh_get_minutes().'
                        </select>
                        <select name="'.$week[$i].'-start-ampm" id="'.$week[$i].'-start-ampm">
                            <option value="am">AM</option>
                            <option value="am">PM</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>'.$week[$i].' End Time</label></th>
                    <td>
                        <select name="'.$week[$i].'-end-hour" id="'.$week[$i].'-end-hour">
                            '.tjdoh_get_hours().'
                        </select>
                        :
                        <select name="'.$week[$i].'-end-minute" id="'.$week[$i].'-end-minute">
                            '.tjdoh_get_minutes().'
                        </select>
                        <select name="'.$week[$i].'-end-ampm" id="'.$week[$i].'-end-ampm">
                            <option value="am">AM</option>
                            <option value="am">PM</option>
                        </select>
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
        $hour = sprintf("%02d", $hour);
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