(function( $ ) {
	'use strict';
    
    $(document).ready(function() {
        
        $('[data-progress-timeline-load-more]').click(function() {
            
            var this_button = $(this);
            
            var timeline_id = this_button.data('progress-timeline-load-more');
            var timeline_container = $('[data-progress-timeline="' + timeline_id + '"]');
            
            var current_page = timeline_container.data('ptl-page');
            
            var data = {
                action: 'ptl_ajax_load_more',
                nonce: ptlLoadMore.nonce,
                page: current_page + 1,
                //timeline_id: timeline_id
            };

            $.post(ptlLoadMore.url, data, function(res) {
                if( res.success ) {
                    
                    // Update current page
                    timeline_container.data('ptl-page', data.page);
                    // Add new posts to the list
                    timeline_container.find('.progress-timeline-posts').append( res.data );
                    
                    // Doesn't have any data
                    if(!res.data) {
                        this_button.fadeOut();
                    }
                    
                } else {
                    
                    console.log('Error fetching new posts', res);
                    
                }

            }).fail(function() {

                // TODO: do something
                console.log(xhr.responseText);

            });
            
        });
        
    });

})( jQuery );
