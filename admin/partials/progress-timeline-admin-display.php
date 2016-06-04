<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.giovanneafonso.net
 * @since      1.0.0
 *
 * @package    Progress_Timeline
 * @subpackage Progress_Timeline/admin/partials
 */
?>
<div class="ptl-admin-wrap">
    <h1>Progress Timeline</h1>
    
    <hr>
    
    <form method="post" action="options.php">
        <?php
            settings_fields( 'pgtimeline_options' );
            do_settings_sections( 'progress-timeline-settings-page' );
        ?>
        
        <p>
            <input type="submit" class="button-primary" value="<?= __('Save changes', 'progress-timeline') ?>">
        </p>
    </form>
    
</div>
