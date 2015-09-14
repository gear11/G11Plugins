<?php

/**
 * Implements the plugin
 */
class G11PostsPlugin {

    /**
     * @var string
     */
    public $version = '0.0.1';

    public static function init() {
        new static();
    }

    public function __construct() {
        $this->define_constants();
        $this->setup_actions();
        $this->setup_filters();
        $this->enqueue_styles();
        $this->override_post_type_name();
    }

    /**
     * Define constants
     */
    private function define_constants() {
        define( 'G11_POSTS_BASE_URL',   trailingslashit( plugins_url( 'g11-posts' ) ) );
        define( 'G11_POSTS_ASSETS_URL', trailingslashit( G11_POSTS_BASE_URL . 'assets' ) );
    }

    /**
     * Add action hooks
     */
    private function setup_actions() {
        add_action( 'after_setup_theme', array($this, 'custom_theme_setup'));
        add_action( 'init', array( $this, 'register_post_types' ) );
        add_action( 'init', array( $this, 'customize_post_type' ) );
        add_action( 'admin_init', array( $this, 'admin_init') );
        add_action( 'save_post', array($this, 'save_post_details'));
        add_action( 'manage_posts_custom_column' , array($this, 'manage_posts_custom_column'), 10, 2 );
    }

    /**
     * Add filters
     */
    private function setup_filters() {

        add_filter( 'the_content', array($this, 'the_content' ) );
        remove_filter('get_the_excerpt', 'wp_trim_excerpt');
        add_filter( 'get_the_excerpt', array($this, 'get_the_excerpt' ) );
        add_filter( 'the_title', array($this, 'the_title' ), 10, 2 );
        add_filter('manage_g11_testimonial_posts_columns' , array($this, 'add_testimonial_columns'));
    }

    /**
     * Enqueue styles
     */
    private function enqueue_styles() {
        wp_enqueue_style( 'g11-posts-styles', G11_POSTS_ASSETS_URL . '/style.css');
    }

    public function custom_theme_setup() {
        //add_theme_support('post-thumbnails');
        //remove_theme_support( 'post-thumbnails' );
        //add_theme_support( 'post-thumbnails', array('g11_project') );
        //remove_theme_support('tags');

    }

    public function override_post_type_name() {
        add_action( 'init', array($this, 'change_post_type_labels' ));
        add_action( 'admin_menu', array($this, 'change_post_menu_text'));
    }

    public function customize_post_type() {
        remove_post_type_support(  'post', 'revisions' ) ;
        remove_post_type_support(  'post', 'trackbacks' ) ;
        remove_post_type_support(  'post', 'comments' ) ;
        remove_post_type_support(  'post', 'custom-fields' ) ;
        remove_post_type_support(  'post', 'excerpt' ) ;
        remove_post_type_support(  'post', 'author' ) ;
        register_taxonomy('post_tag', array());
    }

// http://www.paulund.co.uk/change-posts-text-in-admin-menu
    function change_post_type_labels() {
        global $wp_post_types;

        $singular = "Project";
        $plural   = "Projects";

        $post_type = &$wp_post_types['post'];

        $post_type->menu_icon = 'dashicons-hammer';
        // Get the post labels
        $postLabels = &$post_type->labels;
        $postLabels->name          = __($plural);
        $postLabels->singular_name = __($singular);
        $postLabels->add_new_item  = __("Add New $singular");
        $postLabels->edit_item     = __("Edit $singular");
        $postLabels->new_item      = __("New $singular");
        $postLabels->view_item     = __("View $singular");
    }

    function change_post_menu_text() {

        global $menu;
        global $submenu;

        $singular = "Project";
        $plural   = "Projects";


        // Change menu item
        $menu[5][0] = $plural;

        // Change post submenu
        $submenu['edit.php'][5][0] = $plural;
        $submenu['edit.php'][10][0] = "Add New $singular";
        //$submenu['edit.php'][16][0] = 'Articles Tags';
    }



    /**
     * Register testimonial post type
     */
    public function register_post_types() {
/*
        register_post_type( 'g11_project',
            array(
                'labels' => array(
                    'name'          => __( 'Projects' ),
                    'singular_name' => __( 'Project' ),
                    'add_new_item'  => __('Add New Project'),
                    'edit_item'     => __('Edit Project'),
                    'new_item'      => __('New Project'),
                    'view_item'     => __('View Project'),
                ),
                'public' => true,
                'has_archive' => true,
                'hierarchical' => true,
                'show_ui' => true,
                'rewrite' => array('slug' => 'projects'),
                'menu_icon'   => 'dashicons-hammer',
                'menu_position' => 0, // Above posts
                'capability_type' => 'post',
                'taxonomies' => array('tag', 'category'),
                'supports' => array( 'title', 'editor', 'thumbnail ')
            )
        );

        add_post_type_support(  'g11_project', array( 'thumbnail ' )) ;
*/

        register_post_type( 'g11_testimonial',
            array(
                'labels' => array(
                    'name'          => __( 'Testimonials' ),
                    'singular_name' => __( 'Testimonial' ),
                    'add_new_item'  => __('Add New Testimonial'),
                    'edit_item'     => __('Edit Testimonial'),
                    'new_item'      => __('New Testimonial'),
                    'view_item'     => __('View Testimonial'),
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'testimonials'),
                'menu_icon'   => 'dashicons-smiley',
                'menu_position' => 2, // Above posts
            )
        );

    }

    /**
     * Called during admin_init action to set up custom fields.
     */
    public function admin_init(){
        // Create our custom fields as Advanced Metabaoxes
        add_meta_box('customer', 'Customer', array($this, 'admin_customer'), 'g11_testimonial', 'advanced', 'high');
        add_meta_box('customer_quote', 'Customer Quote', array($this, 'admin_customer_quote'), 'g11_testimonial', 'advanced', 'high');

        // Move these Advanced Metaboxes above the default editor
        add_action('edit_form_after_title', function() {
            global $post, $wp_meta_boxes;
            do_meta_boxes(get_current_screen(), 'advanced', $post);
            unset($wp_meta_boxes[get_post_type($post)]['advanced']);
        });
    }

    public function admin_customer() {
        // If this isn't a 'testimonial' post, ignore it.
        if (!($post = $this->get_testimonial())) {
            return;
        }
        $custom = get_post_custom($post->ID);
        $customer_name = $custom['customer_name'][0];
        $customer_loc = $custom['customer_loc'][0];
        ?><label for="g11_customer_name">Customer Name</label>
          <input id="g11_customer_name" name="customer_name" value="<?php echo $customer_name ?>" />
          &nbsp;
          <label for="g11_customer_loc">Location</label>
          <input id="g11_customer_loc" name="customer_loc" value="<?php echo $customer_loc ?>" />
        <?php
    }

    public function admin_customer_quote() {
        // If this isn't a 'testimonial' post, ignore it.
        if (!($post = $this->get_testimonial())) {
            return;
        }

        $custom = get_post_custom($post->ID);
        $customer_quote = $custom['customer_quote'][0];
        ?>Full customer quote goes here. Additional info (photos, etc.) goes in the editor below and creates a <b>Read More</b> link<br/>
        <textarea id="g11_customer_quote" name="customer_quote"><?php echo $customer_quote ?></textarea>
    <?php
    }

    /**
     * Returns the indiciated testimonial, or NULL if the given ID does not refer to a testimonial.
     *
     * @param null $id
     * @return array|bool|null|WP_Post
     */
    private function get_testimonial($id = null) {
        global $post;
        $post_or_id = $id ?: $post;
        if ('g11_testimonial' == get_post_type($post_or_id)) {
            return $id ? get_post($id) : $post;
        }
        return false;
    }

    /**
     * Called during the save_post action to save the post if it is a testimonial.
     */
    public function save_post_details(){
        // If this isn't a 'testimonial' post, ignore it.
        if (!($post = $this->get_testimonial())) {
            return;
        }
        update_post_meta($post->ID, 'customer_name',  $_POST['customer_name']);
        update_post_meta($post->ID, 'customer_loc',   $_POST['customer_loc']);
        update_post_meta($post->ID, 'customer_quote', $_POST['customer_quote']);
    }

    /**
     * Adds custom columns to the 'all items' view in admin.
     *
     * @param $columns
     * @return array
     */
    public function add_testimonial_columns($columns) {
        unset($columns['date']);
        return array_merge($columns,
            array(
                'customer_name' => __('Customer Name'),
                'customer_loc'  =>__( 'Location'),
                'date'          =>__( 'Date'),
                ));
    }

    /**
     * Populates custom columns in the 'all items' view in admin
     *
     * @param $column
     * @param $post_id
     */
    public function manage_posts_custom_column($column, $post_id ) {
        switch ( $column ) {
            case 'customer_name':
            case 'customer_loc':
                $value = get_post_meta( $post_id, $column, true);
                if ( is_string( $value ) ) {
                    echo $value;
                }
                break;
        }
    }

    /**
     * Filter for the_content.
     * Produces customized content for testimonials.
     *
     * @param $content
     * @return string
     */
    public function the_content($content) {
        // If this isn't a 'testimonial' post, ignore it.
        if (!($post = $this->get_testimonial())) {
            return $content;
        }
        return $this->get_the_excerpt(false) . '<br/>'. $content;
    }

    /**
     * Filter for the_title.
     * Puts the testimonial title in quotes.
     *
     * @param $title
     * @param null $id
     * @return string
     */
    public function the_title($title, $id = null) {
        // If this isn't a 'testimonial' post, ignore it.
        if ($id && $this->get_testimonial($id)) {
            return '"' . $title . '"';
        }
        return $title;
    }

    /**
     * Filter for get_the_excerpt.
     * Replaces the default behavior for testimonials by displaying all metadata.
     *
     * @param bool $with_read_more
     * @return string
     */
    public function get_the_excerpt($with_read_more = false) {
        // If this isn't a 'testimonial' post, ignore it.
        if (!($post = $this->get_testimonial())) {
            // This is the base WP functionality
            return wp_trim_excerpt();
        }

        $custom = get_post_custom($post->ID);
        $customer_name  = $custom['customer_name'][0];
        $customer_loc   = $custom['customer_loc'][0];
        $customer_quote = $custom['customer_quote'][0];

        $text = get_the_content();
        if ($with_read_more && $text) {
            $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
            $read_more = wp_trim_words( $text, 0, $excerpt_more);
        } else {
            $read_more = '';
        }

        $excerpt = "<p><span class='g11_customer_quote'>$customer_quote</span>$read_more</p><p>&mdash;&nbsp;<span class='g11_customer_name'>$customer_name</span>&nbsp;<span class='g11_customer_loc'>($customer_loc)</span></p>";
        return $excerpt;
    }
}