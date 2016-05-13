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
$categories_by_id = array();
foreach($categories as $cat) {
    $categories_by_id[$cat->term_id] = $cat;
}
?>
<div class="ptl-container">

    <div class="ptl-cat-container">
        <ul class="ptl-cat-ul">
            <?php foreach($categories as $cat) { ?>
                <li>
                    <label>
                        <input type="checkbox" name="ptl-checkboxes" checked>
                        <?= $cat->cat_name; ?>
                    </label>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div class="ptl-tl-container">
        <ul>
            <li>
                <div class="ptl--header">
                    <h3 class="ptl--header-title">Hoje</h3>
                    <p>13 de Maio de 2016</p>
                </div>
            </li>
            <?php foreach($posts as $post):
                //setup_postdata( $post );
                $post_cats_idxs = wp_get_post_categories($post->ID);
                $post_cats = array();
                foreach($post_cats_idxs as $pcidx) {
                    $post_cats[] = $categories_by_id[$pcidx];
                }
            ?>
            <li>
                <div class="ptl--item">
                    <div class="ptl--item-content">
                        <h3 class="ptl--item-title">
                            <a href="<?= $post->guid; ?>">
                                <?=$post->post_title;?>
                            </a>
                        </h3>
                        <p>
                            <?= $post->post_exceprt ? $post->post_exceprt : $post->post_content; ?>
                        </p>
                        <p>
                            <ul class="ptl--cats">
                                
                                <?php /*
                                <pre style="text-align:left;">
                                    <?php echo json_encode($post_cats, JSON_PRETTY_PRINT); ?>
                                </pre>
                                */ ?>
                                
                                <?php foreach($post_cats as $post_cat): ?>
                                    <li>
                                        <a href="<?= get_term_link($post_cat); ?>" class="ptl--cat">
                                            <?= $post_cat->name ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                
                            </ul>
                            
                        </p>
                    </div>
                    <div class="ptl--item-footer">
                        <ul class="ptl--item-footer-ul">
                            <li>
                                <div class="ptl--item-action">
                                    <img src="http://placehold.it/20x20">
                                    2 horas
                                </div>
                            </li>
                            <li>
                                <div class="ptl--item-action">
                                    <img src="http://placehold.it/20x20">
                                    2 comentários
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <?php endforeach; wp_reset_postdata(); ?>
        </ul>
    </div>

</div>
