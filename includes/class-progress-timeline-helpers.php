<?php

class Progress_Timeline_Helpers {
    
    private static $options;
    
    private static function getOptions() {
        
        if( !self::$options ) {
            self::$options = get_option( 'pgtimeline' );
        }
        return self::$options;
        
    }
    
    public static function get_option( $option, $default = null) {
        
        $options = self::getOptions();
        return isset( $options[$option] ) ? $options[$option] : $default;
        
    }
    
    public static function post_time_ago( $post ) {

        $post_u_gmt = mysql2date( 'U', $post->post_date_gmt, false );
        $post_u     = mysql2date( 'U', $post->post_date, false );
        
        if( $post_u > strtotime( 'yesterday' ) ) {
            return human_time_diff( $post_u_gmt );
        }
        
        return human_time_diff(
            $post_u,
            strtotime( 'tomorrow' )
        );
        
    }
    
}
