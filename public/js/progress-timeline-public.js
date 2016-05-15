(function( $ ) {
	'use strict';
    
    $(document).ready(function() {
        
        $('[data-progress-timeline]').each(function() {
            
            var timeline_container = $(this);
            var timeline_id = timeline_container.data('progress-timeline');
            var load_more_button = timeline_container.find('[data-progress-timeline-load-more]');
            var category_checkboxes = timeline_container.find('[data-progress-timeline-checkbox]');
            var checkbox_check_all = timeline_container.find('[data-progress-timeline-check-all]');
            
            var getTimelineData = function( page ) {
                var filter_categories = [];
                
                timeline_container.find('[data-progress-timeline-checkbox]:checked').each(function() {
                    filter_categories.push( $(this).val() );
                });
                
                return {
                    timeline_id: timeline_id,
                    action: 'ptl_ajax_load_more',
                    nonce: ptlLoadMore.nonce,
                    page: page || 1,
                    category: filter_categories,
                };
            };
            
            var fetchTimelinePage = function( data, callback ) {
                
                $.post(ptlLoadMore.url, data, function(res) {
                    
                    if( res.success ) {
                        
                        // Update current page
                        timeline_container.data('ptl-page', data.page);
                        
                        callback(res.data);
                        
                    } else {
                        
                        console.log( 'Error fetching new posts', res );
                        
                    }
                    
                }).fail(function() {

                    // TODO: do something
                    console.log( 'jQuery request failed trying to fetching new posts ', xhr.responseText );

                });
                
            };
        
            load_more_button.click(function() {

                // var timeline_id = load_more_button.data('progress-timeline-load-more');
                // var timeline_container = $('[data-progress-timeline="' + timeline_id + '"]');

                var current_page = timeline_container.data('ptl-page');

                //console.log("filter", filter_categories);
                
                var data = getTimelineData( current_page + 1 );

                fetchTimelinePage(data, function( html ) {
                    
                    // Add new posts to the list
                    timeline_container.find('.progress-timeline-posts').append( html );

                    // Doesn't have any data
                    if( !html ) {
                        load_more_button.fadeOut();
                    }
                    
                });
                
            }); // end of [data-progress-timeline-load-more]
            
            category_checkboxes.on('change', function() {
                
                var data = getTimelineData( 1 );
                
                fetchTimelinePage(data, function( html ) {
                    
                    // Add new posts to the list
                    timeline_container.find('.progress-timeline-posts').html( html );
                    
                    // Show load more button
                    load_more_button.show();
                    
                })
                
            });
            
            checkbox_check_all.on('change', function() {
                category_checkboxes.attr( 'checked', $(this).is(':checked') ).trigger('change');
            });
            
        }); // end of timelines.each
        
    });

})( jQuery );
