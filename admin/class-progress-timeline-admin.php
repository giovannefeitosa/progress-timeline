<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.giovanneafonso.net
 * @since      1.0.0
 *
 * @package    Progress_Timeline
 * @subpackage Progress_Timeline/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Progress_Timeline
 * @subpackage Progress_Timeline/admin
 * @author     Giovanne <giovanneafonso@gmail.com>
 */
class Progress_Timeline_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    /**
     * Display admin menu
     *
     * @since    1.0.0
     */
    public function display_settings_submenu() {

        add_submenu_page(
            'edit.php?post_type=timeline_post',
            __( 'Progress Timeline Settings', 'progress-timeline' ),
            __( 'Settings', 'progress-timeline' ),
            'manage_options',
            'progress-timeline-settings',
            array($this, 'show_admin_page')
            // '',
            // '3.0'
        );

    }
    
    /**
     * Show admin page HTML
     *
     * @since    1.0.0
     */
    public function show_admin_page() {

        include plugin_dir_path( __FILE__ ) . 'partials/progress-timeline-admin-display.php';

    }
    
    

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Progress_Timeline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Progress_Timeline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/progress-timeline-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Progress_Timeline_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Progress_Timeline_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/progress-timeline-admin.js', array( 'jquery' ), $this->version, false );

	}
    
    /**
     * Init action hook callback
     * Register custom post type for creating the timeline
     */
    public function action_admin_init() {
        
        $labels_post_type = array(
            //__( 'Posts from Timeline', 'progress-timeline' )
            'name'                  => _x( 'Timeline Posts', 'Post type general name', 'progress-timeline' ),
            'singular_name'         => _x( 'Timeline Post', 'Post type singular name', 'progress-timeline' ),
            'search_items'          => __( 'Search Timeline Posts', 'progress-timeline' ),
            'popular_items'         => __( 'Popular Timeline Posts', 'progress-timeline' ),
            'all_items'             => __( 'All Timeline Posts', 'progress-timeline' ),
            'edit_item'             => __( 'Edit Timeline Post', 'progress-timeline' ),
            'view_item'             => __( 'View Timeline Post', 'progress-timeline' ),
            'update_item'           => __( 'Update Timeline Post', 'progress-timeline' ),
            'add_new_item'          => __( 'Add New Timeline Post', 'progress-timeline' ),
            'menu_name'             => _x( 'Timeline Posts', 'Admin Menu text', 'progress-timeline' ),
            'name_admin_bar'        => _x( 'Timeline Post', 'Add New on Toolbar', 'progress-timeline' ),
            'add_new'               => __( 'Add Timeline Post', 'progress-timeline' ),
            'new_item'              => __( 'New Timeline Post', 'progress-timeline' ),
            'parent_item_colon'     => __( 'Parent Timeline Posts:', 'progress-timeline' ),
            'not_found'             => __( 'No Timeline Posts found.', 'progress-timeline' ),
            'not_found_in_trash'    => __( 'No Timeline Posts found in Trash.', 'progress-timeline' ),
            'featured_image'        => _x( 'Timeline Post Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'progress-timeline' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'progress-timeline' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'progress-timeline' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'progress-timeline' ),
            'archives'              => _x( 'Timeline Post archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'progress-timeline' ),
            'insert_into_item'      => _x( 'Insert into Timeline Post', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'progress-timeline' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this Timeline Post', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'progress-timeline' ),
            'filter_items_list'     => _x( 'Filter Timeline Posts list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'progress-timeline' ),
            'items_list_navigation' => _x( 'Timeline Posts list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'progress-timeline' ),
            'items_list'            => _x( 'Timeline Posts list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'progress-timeline' ),
        );
        
        // https://developer.wordpress.org/reference/functions/register_post_type/
        $args_post_type = array(
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'labels'             => $labels_post_type,
            'menu_position'      => 5,
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
            'has_archive'        => true,
            'capability_type' => 'post',
            'rewrite'            => array(
                'slug' => 'timeline-posts',
                'with_front' => true,
            ),
        );
        
        register_post_type( 'timeline_post', $args_post_type );
        
        
        $labels_taxonomy = array(
            'name'                  => _x( 'Timeline Categories', 'Post type general name', 'progress-timeline' ),
            'singular_name'         => _x( 'Timeline Category', 'Post type singular name', 'progress-timeline' ),
            'search_items'          => __( 'Search Timeline Categories', 'progress-timeline' ),
            'popular_items'         => __( 'Popular Timeline Categories', 'progress-timeline' ),
            'all_items'             => __( 'All Timeline Categories', 'progress-timeline' ),
            'edit_item'             => __( 'Edit Timeline Category', 'progress-timeline' ),
            'view_item'             => __( 'View Timeline Category', 'progress-timeline' ),
            'update_item'           => __( 'Update Timeline Category', 'progress-timeline' ),
            'add_new_item'          => __( 'Add New Timeline Category', 'progress-timeline' ),
            'menu_name'             => _x( 'Categories', 'Admin Menu text', 'progress-timeline' ),
            'name_admin_bar'        => _x( 'Timeline Category', 'Add New on Toolbar', 'progress-timeline' ),
            'add_new'               => __( 'Add New PTL Category', 'progress-timeline' ),
            'new_item'              => __( 'New Timeline Category', 'progress-timeline' ),
        );
        
        $args_taxonomy = array(
            'labels' => $labels_taxonomy,
            'hierarchical' => true,
            'description' => __( 'Categories of Progress Timeline\'s posts', 'progress-timeline' ),
        );
        
        register_taxonomy( 'timeline_categories', 'timeline_post', $args_taxonomy );
        
        flush_rewrite_rules();
        
    }

}
