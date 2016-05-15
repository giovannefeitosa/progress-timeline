<?php

$jump_one = isset($jump_one) && $jump_one;

$last_header = null;

foreach($posts as $post):
    
    //var_dump($post);die();
    $post_date = explode(' ', $post->post_date_gmt)[0];

    if($post_date != $last_header) {
        
        if($jump_one) {
            
            $jump_one = false;
            
        } else {
            
            $last_header = $post_date;
            
            if( $post_date === date('Y-m-d') ) {
                
                $title = __( 'Today', 'progress-timeline' );
                
            } elseif( $post_date === date("Y-m-d", time() - 60 * 60 * 24) ) {
                
                $title = __( 'Yesterday', 'progress-timeline' );
                
            } else {
                
                $title = Progress_Timeline_Helpers::post_time_ago($post);
                
            }
            
            $subtitle = get_the_date( get_option('date_format'), $post );
            
            include __DIR__ . '/timeline-title.php';
            
        }
        
    }
    
    ?>
    
    <li>
        <?php include __DIR__ . '/timeline-item.php'; ?>
    </li>
    
<?php endforeach; wp_reset_postdata(); ?>
