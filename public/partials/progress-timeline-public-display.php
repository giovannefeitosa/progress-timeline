<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.giovanneafonso.net
 * @since      1.0.0
 *
 * @package    Progress_Timeline
 * @subpackage Progress_Timeline/public/partials
 */
?>
<div class="ptl-container" data-progress-timeline="<?= $timeline_id; ?>" data-ptl-page="1">

    <div class="ptl-cat-container">
        <ul class="ptl-cat-ul">
            <li>
                <label>
                    <input type="checkbox" checked data-progress-timeline-check-all>
                    <?= __( 'Select All', 'progress-timeline' ); ?>
                </label>
            </li>
            
            <?php foreach($filtered_categories as $cat) { ?>
                <li>
                    <label>
                        <input type="checkbox" value="<?= $cat->cat_ID ?>" checked data-progress-timeline-checkbox>
                        <?= $cat->cat_name; ?>
                    </label>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div class="ptl-tl-container">
        <ul class="progress-timeline-posts">
            
            <?php include __DIR__ . '/timeline-page.php'; ?>
            
        </ul>
        
        <button data-progress-timeline-load-more>Load More...</button>
    </div>
    
</div>
