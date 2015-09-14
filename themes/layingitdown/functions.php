<?php
/**
 * LayingItDown functions and definitions.  Based on Alpha.
 */

define('BASE_THEME_URI', '/wp-content/themes/layingitdown');
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
 * All pages have Laying It Down in the title
 */
function lid_wp_title( $title, $sep ) {
	return (strpos(strtolower($title), 'laying it down') === false) ? "Laying It Down $title" : $title;
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

function lid_branding() {


    echo '<div class="' . omega_apply_atomic( 'title_area_class', 'title-area') .'">';

    /* Get the site title.  If it's not empty, wrap it with the appropriate HTML. */
    if ( $title = get_bloginfo( 'name' ) ) {
        if ( $logo = get_theme_mod( 'custom_logo' ) ) {
            $title = sprintf( '<div itemscope itemtype="http://schema.org/Organization" class="site-title"><a itemprop="url" href="%1$s" title="%2$s" rel="home"><img itemprop="logo" alt="%3$s" src="%4$s"/></a></div>', home_url(), esc_attr( $title ), esc_attr( $title ), $logo );
        } else {
            if (is_home()) {
                $title = sprintf( '<h1 class="site-title" itemprop="headline"><a href="%1$s" title="%2$s" rel="home">%3$s</a></h1>', home_url(), esc_attr( $title ), $title );
            } else {
                $title = sprintf( '<h2 class="site-title" itemprop="headline"><a href="%1$s" title="%2$s" rel="home">%3$s</a></h2>', home_url(), esc_attr( $title ), $title );
            }
        }
    }

    /* Display the site title and apply filters for developers to overwrite. */
    echo omega_apply_atomic( 'site_title', $title );

    /* Get the site description.  If it's not empty, wrap it with the appropriate HTML. */
    //if ( $desc = get_bloginfo( 'description' ) )
     //   $desc = sprintf( '<h3 class="site-description"><span>%1$s</span></h3>', $desc );

    echo '<h3 class="site-description">';


    // Phone number
    echo '<span id="header__phone">Contact:&nbsp;<a itemprop="telephone" href="tel:+1-704-289-7920">(704) 289-7920</a></span>';

    // Houzz logo
    $houzz_uri = BASE_THEME_URI . '/houzzlogo.png';
    echo '<span id="header__houzz_logo"><a href=http://www.houzz.com/pro/layingitdown/laying-it-down-inc" target="_blank" title="Find us on Houzz">'
        ."<img src=\"$houzz_uri\"></a></span>";

    // Facebook
    echo '<span id="header__fb_logo"><a href="https://www.facebook.com/pages/Laying-It-Down/150003541718076" target="_blank" title="Find us on Facebook"><i class="fa fa-facebook-square fa-2x"></i></a></span>';

    echo '</h3>';

    /* Display the site description and apply filters for developers to overwrite. */
    //echo omega_apply_atomic( 'site_description', $desc );

    echo '</div>';
}

/**
 * Enqueue scripts and styles
 */
function lid_scripts() {
    wp_enqueue_style('font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
}



function lid_help( $wp_admin_bar ) {
    $args = array(
        'id'    => 'lid_help',
        'title' => 'User Guide',
        'href'  => BASE_THEME_URI . '/guide/',
        'meta'  => array( 'class' => 'my-toolbar-page' )
    );
    $wp_admin_bar->add_node( $args );
}

function lid_enqueue_category_styles() {
    if (!is_page() && !is_single()) {
        wp_enqueue_style( 'g11-posts-category-styles', BASE_THEME_URI . '/style-category.css');
    }
}
function lid_archive_header() {
    if (is_home()) {
        echo '<div class="archive_header">Select a project to see more photos</div>';
    }

}

function lid_theme_setup() {

    add_action( 'wp_enqueue_scripts', 'lid_scripts' );

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

    // Replace branding with out own
    remove_action( 'omega_header', 'omega_branding' );
    add_action( 'omega_header', 'lid_branding' );

    remove_theme_support( 'mobile-toggle' );

    //remove_theme_support( 'post-thumbnails' );
    //add_theme_support( 'post-thumbnails' );
    //add_theme_support( 'post-thumbnails' );
	add_filter( 'wp_title', 'lid_wp_title', 10, 2 );

    add_action( 'admin_bar_menu', 'lid_help', 999 );

    //remove_theme_support( 'post-thumbnails' );
    //add_theme_support( 'post-thumbnails' , array('g11_testimonial', 'g11_project', 'post'));
    add_action( 'loop_start', 'lid_enqueue_category_styles');

    add_action( 'omega_before_content', 'lid_archive_header' );
}

add_action( 'after_setup_theme', 'lid_theme_setup', 11 );




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






