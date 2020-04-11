<div class="wrap">
    <h2>Dynamic Office Hours</h2>
    <form method="POST">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field( 'tjdoh_update', 'tjdoh_form' ); ?>
        <table class="form-table">
            <div class="tabs">
                <a class="active" href="?page=dynamic_office_hours">General Settings</a>
                <a href="?page=dynamic_office_hours_daily">Daily Settings</a>
            </div>
            <tbody>
                <tr>
                    <th><label>Typical Opening Time</label></th>
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
            <tbody>
                <tr>
                    <th><label>How to Use</label></th>
                    <td>
                        <p>This plugin uses your <a href="<?php echo admin_url('options-general.php#timezone_string'); ?>">WordPress Date/Time settings</a> to determine the starting day of the week, timezone, etc.</p>
                        <p>To display your office hours, simply add the following shortcode and style it as you wish: <code>[tjdoh-hours]</code></p>
                        <p>The current day of the week will be given a CSS class of <code>tjdoh-current-day</code></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>
</div>