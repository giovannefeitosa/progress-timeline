<?php

/**
 * The timeline object
 *
 * Handles the categories and posts of a Progress Timeline
 *
 * @link       http://www.giovanneafonso.net
 * @since      1.0.0
 *
 * @package    Progress_Timeline
 * @subpackage Progress_Timeline/public
 * @author     Giovanne <giovanneafonso@gmail.com>
 */
class Progress_Timeline_Object {
    
    /**
     * All categories shown on this progress timeline
     *
     * @since   1.0.0
	 * @access  private
	 * @var     array    $categories  The list of categories
     */
    private $categories;
    
    /**
     * List of attributes passed to the plugin
     *
     * @since   1.0.0
     * @access  private
     * @var     array    $args  The list of attributes
     */
    private $args;
    
    /**
     * ID from timeline
     * This property was created to handle multiple timelines on the same page
     *
     * TODO: Add support for multiple timelines (Still doesn't exists)
     *
     * @since   1.0.0
     * @access  private
     * @var     array    $id  The id of current Timeline
     */
    private $id;
    
    /**
	 * Initialize the class and set its properties.
	 *
	 * @since  1.0.0
	 * @param  string  $atts  The attributes to create the Timeline
	 */
    public function __construct( $args = null ) {
        
        $defaults = array(
            'cats' => null,
        );
        
        $args = wp_parse_args( $args, $defaults );
        
        $this->id         = uniqid();
        $this->args       = $args;
        $this->categories = $this->fetch_categories();
        
    }
    
    /**
     * Get the categories to show in the Timeline
     *   https://developer.wordpress.org/reference/functions/get_categories/
     *
     * @since  1.0.0
     * @return array  List of categories to show
     */
    private function fetch_categories() {
        
        $defaults = array(
            'hide_empty' => 0,
            'orderby' => 'name',
            // 'include' => array(1,2),
        );
        
        $r = wp_parse_args( $this->args['cats'], $defaults );
        
        return get_categories( $r );
        
    }
    
    /**
     * Get a category from the list of categories by ID
     *
     * @since   1.0.0
     * @param   int     $id  Id of the category
     * @return  Object       Category
     */
    private function get_category_by_id($id) {
        
        foreach($this->categories as $category) {
            if($category->term_id === $id) {
                return $category;
            }
        }
        
        return null;
        
    }
    
    /**
     * Get the posts to show in the Timeline
     *   https://developer.wordpress.org/reference/functions/get_posts/
     *
     * @since  1.0.0
     * @param  int    $page  Page to show
     * @param  array  $args  Extra arguments, if needed
     * @return array         List of posts to show
     */
    public function fetch_posts($page = 1, $args = null) {
        
        $posts_per_page = 5;
        $offset = 0;
        
        if($page > 1) {
            $offset = ($page-1) * $posts_per_page;
        }
        
        $defaults = array(
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
        );
        
        $r = wp_parse_args( $args, $defaults );
        
        $posts = get_posts($r);
        
        // Append categories to each post
        foreach($posts as &$post) {
            $post->categories = array();
            
            $cat_ids = wp_get_post_categories($post->ID);
            
            foreach($cat_ids as $cat_id) {
                $post->categories[] = $this->get_category_by_id($cat_id);
            }
        }
        
        return $posts;
        
    }
    
    /**
     * Generate and returns the FULL HTML code to show the timeline
     *
     * @since   1.0.0
     * @return  string         The HTML code
     */
    public function getFullHTML() {
        
        $categories  = $this->categories;
        $posts       = $this->fetch_posts(1);
        $timeline_id = $this->id;
        
        ob_start();
        
        include plugin_dir_path( __FILE__ ) . 'partials/progress-timeline-public-display.php';
        
        return ob_get_clean();
        
    }
    
    /**
     * Generate and returns the HTML from a page to append in a <ul> tag
     *
     * @since   1.0.0
     * @param   int     $page  The page to show HTML
     * @return  string         The HTML code
     */
    public function getPageHTML($page = 1) {
        
        $categories  = $this->categories;
        $posts       = $this->fetch_posts($page);
        $timeline_id = $this->id;
        ob_start();
        
        include plugin_dir_path( __FILE__ ) . 'partials/timeline-page.php';
        
        return ob_get_clean();
        
    }
    
}
