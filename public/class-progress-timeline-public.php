<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.giovanneafonso.net
 * @since      1.0.0
 *
 * @package    Progress_Timeline
 * @subpackage Progress_Timeline/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Progress_Timeline
 * @subpackage Progress_Timeline/public
 * @author     Giovanne <giovanneafonso@gmail.com>
 */
class Progress_Timeline_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/progress-timeline-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/progress-timeline-public.js', array( 'jquery' ), $this->version, false );

	}
    
    /**
     * Generate shortcode html code
     *
     * @since    1.0.0
     * @param    array     $atts    Attributes passed through the shortcode
     * @return   string             The HTML code
     */
    public function progress_timeline_shortcode( $atts ) {
        
        // https://developer.wordpress.org/reference/functions/get_categories/
        $categories = get_categories(array(
            'hide_empty' => 0,
            'orderby' => 'name',
        ));
        
        // https://developer.wordpress.org/reference/functions/get_posts/
        // https://codex.wordpress.org/Template_Tags/get_posts
        $posts = get_posts(array(
            'posts_per_page' => 5,
        ));
        
        ob_start();
        include plugin_dir_path( __FILE__ ) . 'partials/progress-timeline-public-display.php';
        return ob_get_clean();
        
    }

}
