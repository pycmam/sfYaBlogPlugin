<?php
/**
 * Посты блога
 *
 * @param Doctrine_Collection $posts
 */
?>

<?php foreach ($posts as $post): ?>
<div class="blog-post" id="post-<?php echo $post->getId(); ?>">
    <h3><?php echo link_to($post->getTitle(), 'sfYaBlogPost_show', $post); ?></h3>
    <div class="blog-post-content">
        <?php echo $post->getShort(ESC_RAW); ?>

        <?php if ($post->getContent()): ?>
            <?php echo link_to('Читать далее...', 'sfYaBlogPost_show', $post); ?>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>