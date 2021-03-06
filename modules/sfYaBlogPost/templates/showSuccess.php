<?php
/**
 * Просмотр поста
 *
 * @param BlogPost $post
 */

slot('page_header', $post->getTitle());
?>

<div class="blog-post-content">
    <?php echo $post->getShort(ESC_RAW); ?>
    <?php echo $post->getContent(ESC_RAW); ?>
</div>

<?php include_partial('sfYaBlogComment/comments', array('post' => $post)); ?>

<p><?php echo link_to('Другие записи блога', 'sfYaBlogPost'); ?></p>