<?php
/**
 * LayingItDown functions and definitions.  Based on Alpha.
 */

/**
 * Hide the title if we're rendering the home page
 */
function lid_the_title($title) {
	// Hide the title if we're rendering the home page
    $frontPage = get_option('page_on_front');
	$renderingHomePage = in_the_loop() && get_the_ID() == $frontPage;
	return $renderingHomePage ? null : $title;
}

/**
 * Instead of default footer with theme credits, just simple copyright.
 *
 * @return string
 */
function lid_footer_insert( ) {

    /* If there is a child theme active, use [child-link] shortcode to the $footer_insert. */
    return '<p class="copyright">' . __( 'Copyright &#169; ', 'omega' ) . date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '</p>' ;

}

function lid_theme_setup() {
	// Custom background
	add_theme_support(
		'custom-background',
		array( 'default-color' => '333333' )
	);
	// Hide title on home page
	add_filter( 'the_title', 'lid_the_title');

	// Replace omega footer insert with our own
	remove_filter( 'omega_footer_insert', 'omega_default_footer_insert' );
	add_filter( 'omega_footer_insert', 'lid_footer_insert' );
	//add_filter( 'get_the_excerpt', 'lid_excerpt' );

    remove_action( 'omega_before_header', 'omega_get_primary_menu' );
    add_action( 'omega_after_header', 'omega_get_primary_menu' );

}

add_action( 'after_setup_theme', 'lid_theme_setup', 11 );

/**
 * All pages have Laying It Down in the title
 */
function lid_wp_title( $title, $sep ) {
	return (strpos(strtolower($title), 'laying it down') === false) ? "Laying It Down $title" : $title;
}
add_filter( 'wp_title', 'lid_wp_title', 10, 2 );

/**
 * All pages have a favicon

function lid_favicon() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">' . "\n";
}
add_action('wp_head', 'lid_favicon');
 */
/**
 * Enqueue scripts and styles

function rocksalt_scripts() {
	wp_enqueue_style('lato-font', 'http://fonts.googleapis.com/css?family=Lato:400,700');
	wp_enqueue_style('font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
}
add_action( 'wp_enqueue_scripts', 'rocksalt_scripts' );
 *  */






