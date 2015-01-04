<!-- BEGIN g11-google-analytics/settings.php -->
<div id="g11-google-analytics-settings" class="wrap">
    <h2>G11 Google Analytics Settings</h2>
    <div id="poststuff">
        <div class="postbox">
            <form id="g11_ga_settings" method="post" action="options.php" class="clearfix">
                <?php settings_fields('g11_ga_settings'); ?>
                <div class="inside">
                    <table class="form-table">
                        <tr>
                            <td colspan="2">
                                <p>
                                    Please provide your Google Analytics tracking code. This is the tracking
                                    code that Google generated for the Web property you are tracking.  If you
                                    don't have the code, visit the Google Analytics dashboard to find it.
                                </p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row" style="text-align: right">
                                <label for="g11_ga_tracking_code">Google Analytics<br>Tracking Code:</label>
                            </th>
                            <td>
                                <input type="text" id="g11_ga_tracking_code" name="g11_ga_tracking_code" value="<?php echo get_option('g11_ga_tracking_code'); ?>" >
                            </td>
                        </tr>

                    </table>

                    <div>
                        <p>
                            <?php submit_button('Save Changes', 'primary', 'do_submit', false); ?>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END g11-google-analytics/settings.php -->