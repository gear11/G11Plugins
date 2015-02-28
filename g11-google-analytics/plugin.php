<?php
/*
Plugin Name: G11 Google Analytics
Plugin URI: https://github.com/gear11/G11Plugins
Description: Inserts the GA analytics tracking script on each page, using Google's recommended snippet.
Version: 1.0.1
Author: Gear 11
Author URI: http://www.gear11.com
License: GPL 2
*/

const G11_GA_SETTINGS = "g11_ga_settings";
const G11_GA_TRACKING_CODE = "g11_ga_tracking_code";

// After the head, inject the tracking script
function print_ga_tracking_script() {
    $ga_tracking_code = get_option(G11_GA_TRACKING_CODE, "GA TRACKING CODE NOT SET.  SEE G11 GA PLUGIN SETTINGS");
    ob_start();
    // Inject recommended GA snippet
    include_once("analyticstracking.php");
    $out = ob_get_clean();
    // Sub in our tracking code
    echo str_replace('GA_TRACKING_CODE', $ga_tracking_code, $out);
}
add_action('wp_head', 'print_ga_tracking_script');

if(is_admin()){
    // Add the tracking code as our only option, and register it as a setting
    function g11_google_analytics_admin_register_settings() {
        add_option( G11_GA_TRACKING_CODE, 'UA-XXXXXXXX-N');
        register_setting( G11_GA_SETTINGS, G11_GA_TRACKING_CODE);
    }
    add_action('admin_init', 'g11_google_analytics_admin_register_settings');

    // The function to render the settings page
    function g11_google_analytics_render_settings_page() {
        include_once(plugin_dir_path(__FILE__) . 'settings.php');
    }

    // Register the settings page so we can display it
    function g11_google_analytics_admin_register_settings_page() {
        add_options_page('Google Analytics Settings',
            'G11 Google Analytics', 'manage_options',
            'g11-google-analytics', 'g11_google_analytics_render_settings_page');
    }
    add_action('admin_menu', 'g11_google_analytics_admin_register_settings_page');

    // Add the Settings link to the plugin links
    function g11_google_analytics_settings_link($links) {
        $settings_link = '<a href="options-general.php?page=g11-google-analytics">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
    add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'g11_google_analytics_settings_link' );
}
