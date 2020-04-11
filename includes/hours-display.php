<div class="tjdoh-hours-wrap">
    <div class="tjdoh-hours">
        <ul>
            <?php
                $week = tjdoh_get_days();
                $hours = tjdoh_get_office_hours($week);
                $day = date('l', current_time('timestamp'));
                for($i = 0; $i < count($week); $i++){ ?>
                    
                    <li <?php if($day === $week[$i]){echo 'class = "current-day"';} ?>><?php echo $week[$i] . ' ' . $hours[$i]; ?></li>

                <?php }
            ?>
        </ul>
    </div>
</div>

<?php

//Functions

function tjdoh_get_days(){
    $start_day = get_option('start_of_week');
    $week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    for($i = $start_day; $i > 0; $i--){
        $shift_day = $week[0];
        array_shift($week);
        array_push($week, $shift_day);
    }
    return $week;
}

function tjdoh_get_office_hours($days){
    $hours = array();
    $typ_start = get_option('typical-open-hour') . ':' . get_option('typical-open-minute') . ' ' . strtoupper(get_option('typical-open-ampm'));
    $typ_close = get_option('typical-close-hour') . ':' . get_option('typical-close-minute') . ' ' . strtoupper(get_option('typical-close-ampm'));
    $typ_hours = $typ_start . ' - ' . $typ_close;
    for($i = 0; $i < count($days); $i++){
        $day = strtolower($days[$i]);
        $option = get_option($day.'-options');
        if($option === 'closed'){
            array_push($hours, 'Closed');
        }
        else if($option === 'different-times'){
            $diff_start = get_option($day.'-open-hour') . ':' . get_option($day.'-open-minute') . ' ' . strtoupper(get_option($day.'-open-ampm'));
            $diff_close = get_option($day.'-close-hour') . ':' . get_option($day.'-close-minute') . ' ' . strtoupper(get_option($day.'-close-ampm'));
            $diff_hours = $diff_start . ' - ' . $diff_close;
            array_push($hours, $diff_hours);
        }
        else{
            array_push($hours, $typ_hours);
        }
    }
    return $hours;
}
