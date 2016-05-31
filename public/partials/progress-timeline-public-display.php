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

$last_post_date = isset($last_post_date) ? $last_post_date : '';

?>
<div class="ptl-container" data-progress-timeline="<?= $timeline_id; ?>" data-ptl-page="1" data-ptl-last-date="<?= $last_post_date ?>">

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
                        <input type="checkbox" value="<?= $cat->slug ?>" checked data-progress-timeline-checkbox>
                        <?= $cat->cat_name; ?>
                    </label>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div class="ptl-tl-container">
            
        <?php include __DIR__ . '/timeline-page.php'; ?>
        
        <button data-progress-timeline-load-more>Load More...</button>
    </div>
    
</div>
