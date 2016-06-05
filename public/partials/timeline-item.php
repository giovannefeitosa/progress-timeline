<?php
/**
 * Partial for showing a post in timeline
 * This template must be used in PHP and JavaScript
 * for showing posts with infinite scroll
 *
 * Variables needed:
 * @var $post  The post to show
 *               https://codex.wordpress.org/Function_Reference/$post
 */
?>
<div class="ptl--item">
    <div class="ptl--item-content">
        <h3 class="ptl--item-title">
            <a href="<?= $post->guid; ?>">
                <?=$post->post_title;?>
            </a>
        </h3>
        <p>
            <?= get_the_excerpt(); ?>
        </p>
        <p>
            <ul class="ptl--cats">

                <?php /* * / ?>
                <pre style="text-align:left;">
                    <?php echo json_encode($post->categories, JSON_PRETTY_PRINT); ?>
                </pre>
                <?php /* */ ?>

                <?php foreach($post->categories as $post_cat): ?>
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
                    <span class="pt-icon-clock"></span>
                    <?= Progress_Timeline_Helpers::post_time_ago( $post ); ?>
                </div>
            </li>
            <?php if( Progress_Timeline_Helpers::get_option('show_comments').'' === '1' ): ?>
            <li>
                <div class="ptl--item-action">
                    <span class="pt-icon-bubble2"></span>
                    <?php comments_number(); ?>
                </div>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
