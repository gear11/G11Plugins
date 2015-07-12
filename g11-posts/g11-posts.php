<?php
/*
 * Gear 11 Custom Posts.  Adds useful Custom Post types to WordPress.
 *
 * Plugin Name: G11 Posts
 * Plugin URI:  https://www.gear11.com
 * Description: Adds useful Custom Post types to WordPress.
 * Version:     0.0.1
 * Author:      Gear 11
 * Author URI:  https://www.gear11.com
 * License:     GPL-2.0+
 * Copyright:   2015 Gear 11
 *
 * Text Domain: g11_posts
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // disable direct access
}

if ( ! class_exists( 'G11Posts' ) ) {

    require_once('lib/G11PostsPlugin.php');

}

add_action( 'plugins_loaded', array( 'G11PostsPlugin', 'init' ), 10 );