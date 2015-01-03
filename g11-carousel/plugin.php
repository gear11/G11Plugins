<?php
/*
Plugin Name: g11-carousel
Plugin URI: https://github.com/gear11/G11Plugins/g11-carousel
Description: A simple, non-interactive carousel for images and other content
Version: 1.0
Author: Gear 11
Author URI: http://www.gear11.com
License: GPL 3
*/
define('PLUGIN_NAME', 'g11-carousel');

wp_enqueue_script('jquery');
wp_enqueue_script('g11-carousel', plugins_url(PLUGIN_NAME) . '/js/g11-carousel.js');
wp_enqueue_style('g11-carousel', plugins_url(PLUGIN_NAME) . '/css/g11-carousel.css');

function render_carousel_shortcode($attrs, $content) {
    $dataAttrs = isset($attrs['height']) ? ' data-height="'.$attrs['height'].'"' : '';
    $dataAttrs = isset($attrs['duration']) ? $dataAttrs . ' data-duration="'.$attrs['duration'].'"' : $dataAttrs;
    ?>
    <div class="g11-carousel" >
        <div class="g11-carousel-stage" <?php print($dataAttrs); ?> >
           <?php print($content); ?>
        </div>
    </div>
<?php
}

add_shortcode( 'g11-carousel', 'render_carousel_shortcode');
