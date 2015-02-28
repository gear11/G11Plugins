<?php
/*
Plugin Name: G11 Carousel
Plugin URI: https://github.com/gear11/G11Plugins
Description: A simple, non-interactive carousel for images and other content.
Implements a [g11-carousel] shortcode for displaying contents in a carousel.
Version: 1.0.1
Author: Gear 11
Author URI: http://www.gear11.com
License: GPL 2
*/
const PLUGIN_DIR = 'g11-carousel';
wp_enqueue_script('jquery');
wp_enqueue_script('velocity', plugins_url(PLUGIN_DIR) . '/js/velocity.min.js');
wp_enqueue_script('g11-carousel', plugins_url(PLUGIN_DIR) . '/js/g11-carousel.js');
wp_enqueue_style('g11-carousel', plugins_url(PLUGIN_DIR) . '/css/g11-carousel.css');

// [g11_carousel] shortcode
function render_carousel_shortcode($attrs, $content) {
    $dataAttrs = isset($attrs['height']) ? ' data-height="'.$attrs['height'].'"' : '';
    $dataAttrs = isset($attrs['duration']) ? $dataAttrs . ' data-duration="'.$attrs['duration'].'"' : $dataAttrs;
    ob_start();
    ?><div class="g11-carousel" >
        <div class="g11-carousel-stage" <?php print($dataAttrs); ?> >
           <?php print($content); ?>
        </div>
    </div><?php
    return ob_get_clean();
}
add_shortcode( 'g11-carousel', 'render_carousel_shortcode');
