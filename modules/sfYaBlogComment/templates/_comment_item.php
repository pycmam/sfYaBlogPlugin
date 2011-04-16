<?php
/**
 * Комментарий
 *
 * @param BlogComment $comment
 */

use_helper('Text');
?>

<div class="blog-comment" id="comment-<?php echo $comment->getId(); ?>">
    <div class="comment-head">
        <span class="author"><?php echo $comment->getName(); ?></span>,
        <span class="date"><?php echo $comment->getDateTimeObject('created_at')->format('d.m.Y в H:i'); ?></span>
    </div>

    <?php echo simple_format_text($comment->getComment()); ?>
</div>