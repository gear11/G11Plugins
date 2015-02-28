<?php
/*
Plugin Name: G11 OpenTable Widget
Plugin URI: https://github.com/gear11/G11Plugins
Description: Shortcodes [g11-open-table] for inserting OpenTable widgets
Version: 1.0.1
Author: Gear 11
Author URI: http://www.gear11.com
License: GPL 2
*/

// [g11-open-table] shortcode
function render_open_table($atts ) {
    $a = shortcode_atts( array(
        'style' => 'widget',
        'rid' => false,
    ), $atts );
    $ot_rid = $a['rid'];
    $ot_style = $a['style'];

    // Inject recommended GA snippet
    if (!$ot_rid) {
        return "<!-- g11-open-table: Missing required attribute 'rid'-->";
    } else if ($ot_style == 'widget') {

        include_once("open-table-widget.php");
        return g11_open_table_widget($ot_rid);

    } else if ($ot_style == 'button') {

        include_once("open-table-button.php");
        return g11_open_table_button($ot_rid);

    } else if ($ot_style == 'link') {

        include_once("open-table-link.php");
        return g11_open_table_link($ot_rid);

    } else {
        return "<!-- g11-open-table: Unrecognized style '$ot_style'' -->";
    }

    // Can include link if we want...
    // Replace here

}
add_shortcode( 'g11-open-table', 'render_open_table');
