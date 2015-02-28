<?php
/**
 * ROCKSALT functions and definitions.  Based on Alpha.
 *
 * @package Rocksalt
 */

/**
 * Hide the title if we're rendering the home page
 */
function rocksalt_the_title($title) {
	// Hide the title if we're rendering the home page
	$renderingHomePage = in_the_loop() && get_the_ID() == get_option('page_on_front');
	return $renderingHomePage ? null : $title;
}
function rocksalt_footer_insert() {
	// Copyright only
	return '<p class="copyright">' . __( 'Copyright &#169; [the-year] [site-link].', 'omega' ) . '</p>';
}

$frontPage = get_option('page_on_front');

function rocksalt_theme_setup() {
	// Custom background
	add_theme_support(
		'custom-background',
		array( 'default-color' => '333333' )
	);
	// Hide title on home page
	add_filter( 'the_title', 'rocksalt_the_title');

	// Replace omega footer insert with our own
	remove_filter( 'omega_footer_insert', 'omega_default_footer_insert' );
	add_filter( 'omega_footer_insert', 'rocksalt_footer_insert' );

}

add_action( 'after_setup_theme', 'rocksalt_theme_setup', 11 );

/**
 * All pages have ROCKSALT in the title
 */
function rocksalt_wp_title( $title, $sep ) {
	return (strpos(strtolower($title), 'rocksalt') === false) ? "ROCKSALT $title" : $title;
}
add_filter( 'wp_title', 'rocksalt_wp_title', 10, 2 );

/**
 * All pages have a favicon
 */
function rocksalt_favicon() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">' . "\n";
}
add_action('wp_head', 'rocksalt_favicon');

/**
 * Enqueue scripts and styles
 */
function rocksalt_scripts() {
	wp_enqueue_style('lato-font', 'http://fonts.googleapis.com/css?family=Lato:400,700');
	wp_enqueue_style('font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
}
add_action( 'wp_enqueue_scripts', 'rocksalt_scripts' );




