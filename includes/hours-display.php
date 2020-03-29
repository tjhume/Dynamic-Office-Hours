<div class="tjdoh-hours-wrap">
    <div class="tjdoh-hours">
        <ul>
            <?php
                $week = get_days();
                for($i = 0; $i < count($week); $i++){ ?>
                    
                    <li><?php echo $week[$i] ?></li>

                <?php }
            ?>
        </ul>
    </div>
</div>

<?php

//Functions

function get_days(){
    $start_day = get_option('start_of_week');
    $week = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    for($i = $start_day; $i > 0; $i--){
        $shift_day = $week[0];
        array_shift($week);
        array_push($week, $shift_day);
    }
    return $week;
}
