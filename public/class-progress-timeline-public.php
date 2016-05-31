<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://www.giovanneafonso.net
 * @since      1.0.0
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
     * The timeline object
     * 
     * @since   1.0.0
     * @access  privte
     * @var     Progress_Timeline_Object  $timeline  The timeline Object
     */
    private $timeline;

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
        $this->timeline = new Progress_Timeline_Object();

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
        
        // Except the wp_enqueue_script, the script is based on this
        // http://www.billerickson.net/infinite-scroll-in-wordpress/
        //global $wp_query;
        
        $args = array(
            'nonce' => wp_create_nonce( 'ptl-load-more-nonce' ),
            'url'   => admin_url( 'admin-ajax.php' ),
        );
        
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/progress-timeline-public.js', array( 'jquery' ), $this->version, false );
        
        wp_localize_script( $this->plugin_name, 'ptlLoadMore', $args );
        
	}
    
    /**
     * Get the Timeline Object instance
     *
     * @since  1.0.0
     * @return Progress_Timeline_Object
     */
    public function get_timeline( $args ) {
        
        return new Progress_Timeline_Object( $args );
        
    }
    
    /**
     * Generate shortcode html code
     *
     * @since    1.0.0
     * @param    array     $args    Attributes passed through the shortcode
     * @return   string             The HTML code
     */
    public function progress_timeline_shortcode( $args ) {
        
        $defaults = array(
            'category' => null,
        );
        
        $args = wp_parse_args( $args, $defaults );
        
        return $this->get_timeline( $args )->get_full_html();
        
    }
    
    /**
     * AJAX Load More posts from timeline
     */
    public function ptl_ajax_load_more() {
        
        check_ajax_referer( 'ptl-load-more-nonce', 'nonce' );
        
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        
        $last_date = isset($_POST['last_date']) ? $_POST['last_date'] : null;
        
        $category = isset($_POST['category']) ? $_POST['category'] : null;
        
        $args = array(
            'timeline_categories' => $category,
        );
        
        ini_set('display_errors', E_ALL);
        error_reporting(-1);
        
        $timeline = $this->get_timeline( $args );
        $timeline->set_last_date( $last_date );
        $data = array(
            'success' => true,
            'data' => $timeline->get_page_html( $page ),
            'last_date' => $timeline->get_last_date(),
        );
        
        
        wp_send_json( $data );
        
    }
    
    /**
     * Show link "back to timeline" in single timeline post's page
     */
    public function progress_timeline_content_filter( $content ) {
        global $post;
        
        if($post->post_type === 'timeline_post') {
            
            $pt_url = get_post_type_archive_link( 'timeline_post' );
            
            $pt_link = '<div class="ptl-back-link">'
                        . '<a href="' . $pt_url . '" title="Voltar para a Timeline">'
                        . 'Voltar para a Timeline'
                        . '</a>'
                        . '</div>';
            
            $content = $pt_link . $content;
            
        }
        
        return $content;
        
    }

    /**
     * Parse excerpt from timeline posts
     */
    public function progress_timeline_excerpt_filter( $text ) {
        //global $post;
        
        $raw_excerpt = $text;
        if ('' == $text) {
            $text = get_the_content('');
            
            $text = strip_shortcodes($text);
            
            $text = apply_filters('the_content', $text);
            $text = str_replace(']]>', ']]>', $text);
            /*
             * Hi, future...
             *
             * Maybe I should not allow iframes... but I want the videos
             * to show in the excerpt too, maybe I will remove <iframe> from
             * here and add post custom field to add video right after the post content
             */
            $text = strip_tags($text, '<a><iframe><p><br><strong><ul><li>');
            $excerpt_length = apply_filters('excerpt_length', 55);
            $excerpt_length = 155;

            $excerpt_more = apply_filters('excerpt_more', ' '.'[...]');
            $words = preg_split('/(<a.*?a>)|\n|\r|\t|\s/', $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            if (count($words) > $excerpt_length) {
                array_pop($words);
                $text = implode(' ', $words);
                $text = $text.$excerpt_more;
            } else {
                $text = implode(' ', $words);
            }
        }
        
        return apply_filters('progress_timeline_excerpt_filter', $text, $raw_excerpt);
        
        // return $content;
        
    }

}
