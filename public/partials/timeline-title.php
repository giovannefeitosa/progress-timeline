<?php
/**
 * Partial for showing a post in timeline
 * This template must be used in PHP and JavaScript
 * for showing posts with infinite scroll
 *
 * Variables needed:
 * @var string $title     The title
 * @var string $subtitle  The subtitle
 *
 * I know this is wierd, but I don't care.
 *   If you are reading this...   :)
 *     I hope you have a nice day
 *       Thank you for reading
 */
?>
<div class="ptl--header">
    <h3 class="ptl--header-title"><?= $title; ?></h3>
    <p><?= $subtitle; ?></p>
</div>
