<?php

class Progress_Timeline_Helpers {
    
    public static function post_time_ago($post) {

        $date = get_post_time('U', true, $post);

        // Array of time period chunks
        $chunks = array(
            array( 60 * 60 * 24 * 365 , __( 'year', 'progress-timeline' ), __( 'years', 'progress-timeline' ) ),
            array( 60 * 60 * 24 * 30 , __( 'month', 'progress-timeline' ), __( 'months', 'progress-timeline' ) ),
            array( 60 * 60 * 24 * 7, __( 'week', 'progress-timeline' ), __( 'weeks', 'progress-timeline' ) ),
            array( 60 * 60 * 24 , __( 'day', 'progress-timeline' ), __( 'days', 'progress-timeline' ) ),
            array( 60 * 60 , __( 'hour', 'progress-timeline' ), __( 'hours', 'progress-timeline' ) ),
            array( 60 , __( 'minute', 'progress-timeline' ), __( 'minutes', 'progress-timeline' ) ),
            array( 1, __( 'second', 'progress-timeline' ), __( 'seconds', 'progress-timeline' ) )
        );

        if ( !is_numeric( $date ) ) {
            $time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
            $date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
            $date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
        }

        $current_time = current_time( 'mysql', $gmt = 1 );
        $newer_date = strtotime( $current_time );

        // Difference in seconds
        $since = $newer_date - $date;

        // Something went wrong with date calculation and we ended up with a negative date.
        if ( 0 > $since )
            return __( 'sometime', 'progress-timeline' );

        /**
         * We only want to output one chunks of time here, eg:
         * x years
         * xx months
         * so there's only one bit of calculation below:
         */

        //Step one: the first chunk
        for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];

            // Finding the biggest chunk (if the chunk fits, break)
            if ( ( $count = floor($since / $seconds) ) != 0 )
                break;
        }

        // Set output var
        $output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];


        if ( !(int)trim($output) ){
            $output = '0 ' . __( 'seconds', 'progress-timeline' );
        }

        $output .= __(' ago', 'progress-timeline');

        return $output;
    }
    
}
