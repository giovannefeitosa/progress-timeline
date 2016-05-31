<?php

$ptl_ul_class = 'progress-timeline-posts';
$ptl_columns = 2;

echo '<ul class="' . $ptl_ul_class . '">';

$jump_one = isset($jump_one) && $jump_one;

$last_header = null;

foreach ($posts as $post) :
    
    setup_postdata($post);
    
    $post_date = explode(' ', $post->post_date)[0];

    if ($post_date != $last_header) {
        
        if ($jump_one) {
            
            $jump_one = false;
            
        } else {
            
            if ($post_date === date('Y-m-d')) {
                
                $title = __('Today', 'progress-timeline');
                
            } elseif ($post_date === date("Y-m-d", time() - 60 * 60 * 24)) {
                
                $title = __('Yesterday', 'progress-timeline');
                
            } else {
                
                $title = Progress_Timeline_Helpers::post_time_ago($post);
                
            }
            
            $subtitle = get_the_date(get_option('date_format'), $post);
            
            echo '</ul>';
            
            include __DIR__ . '/timeline-title.php';
            
            echo '<ul class="' . $ptl_ul_class . '">';
            
        }
        
        $last_header = $post_date;
        
    }
    
    ?>
    
    <li>
        <?php /* */ include __DIR__ . '/timeline-item.php'; /* */ ?>
        <?php /* * / get_template_part('content', $post->post_type); /* */ ?>
    </li>
    
<?php
endforeach;
wp_reset_postdata();
?>
</ul>
