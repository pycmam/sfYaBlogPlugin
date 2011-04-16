<?php
/**
 * Комментарии
 *
 * @param BlogPost $post
 */

$comments = $post->getComments();
?>

<?php if ($sf_user->isAuthenticated()): ?>
    <fieldset id="comment_form_container">
        <?php include_component('sfYaBlogComment', 'form', array('post' => $post)); ?>
    </fieldset>
<?php else: ?>
    <p>Только зарегистрированные пользователи могут оставлять комментарии.</p>
<?php endif; ?>

<h2 id="comments">Комментарии:</h2>

<div id="blog_post_comments">
<?php if (count($comments)): ?>
    <?php foreach ($comments as $comment): ?>
        <?php include_partial('sfYaBlogComment/comment_item', array('comment' => $comment)); ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>Комментариев нет.</p>
<?php endif; ?>
</div>