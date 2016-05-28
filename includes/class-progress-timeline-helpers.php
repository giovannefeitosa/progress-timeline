<?php

class Progress_Timeline_Helpers {
    
    public static function post_time_ago($post) {

        return human_time_diff(get_post_time('U', true, $post));
        
    }
    
}
