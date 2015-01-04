<?php
/*
Plugin Name: G11 Is Mobile?
Plugin URI: https://github.com/gear11/G11Plugins/g11-is-mobile
Description: Shortcodes [g11-is-mobile] and [g11-is-not-mobile] for detecting mobile devices
             based on User Agent
Version: 1.0.1
Author: Gear 11
Author URI: http://www.gear11.com
License: GPL 2
*/
define('PLUGIN_NAME', 'g11-is-mobile');

// Get the User Agent and check it for known mobile contents
function is_mobile() {
    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (strstr($ua,'iphone') ||
        strstr($ua,'ipad') ||
        strstr($ua,'android')
    ) {
        return true;
    }

    return false;
}

// [render_if_mobile] shortcode
function render_if_mobile($_, $content) {
    return is_mobile() ? $content : '';
}
add_shortcode( 'g11-is-mobile', 'render_if_mobile');

// [render_if_not_mobile] shortcode
function render_if_not_mobile($_, $content) {
    return !is_mobile() ? $content : '';
}
add_shortcode( 'g11-is-not-mobile', 'render_if_not_mobile');
