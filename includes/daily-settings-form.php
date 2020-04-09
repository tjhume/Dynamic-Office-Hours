<div class="wrap">
    <h2>Dynamic Office Hours</h2>
    <form method="POST">
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