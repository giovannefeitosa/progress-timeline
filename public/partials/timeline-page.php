<?php foreach($posts as $post): ?>
<li>
    <?php include __DIR__ . '/timeline-item.php'; ?>
</li>
<?php endforeach; wp_reset_postdata(); ?>
