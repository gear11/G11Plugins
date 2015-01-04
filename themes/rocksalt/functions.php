<?php
/**
 * ROCKSALT functions and definitions.  Based on Alpha.
 *
 * @package Rocksalt
 */
function rocksalt_default_footer_insert() {
    // Copyright only
    return '<p class="copyright">' . __( 'Copyright &#169; [the-year] [site-link].', 'omega' ) . '</p>';
}

function rocksalt_theme_setup() {
	// Custom background
	add_theme_support( 
		'custom-background',
		array( 'default-color' => '333333' )
	);
    // Replace omega footer insert with our own
    remove_filter( 'omega_footer_insert', 'omega_default_footer_insert' );
    add_filter( 'omega_footer_insert', 'rocksalt_default_footer_insert' );
}

add_action( 'after_setup_theme', 'rocksalt_theme_setup', 11 );

/**
 * Enqueue scripts and styles
 */
function rocksalt_scripts() {
	wp_enqueue_style('lato-font', 'http://fonts.googleapis.com/css?family=Lato:400,700');
}
add_action( 'wp_enqueue_scripts', 'rocksalt_scripts' );

