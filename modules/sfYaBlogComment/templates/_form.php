<?php
/**
 * Форма добавления комментария
 *
 * @param BlogCommentForm $form
 * @param BlogPost $form
 */
use_helper('JavascriptBase');

echo javascript_tag("
$(function(){
    $('#blog_comment_form').submit(function(){
        $.ajax({
           url: $(this).attr('action'),
           type: 'POST',
           data: $(this).serializeArray(),
           dataType: 'json',
           success: function(data) {
               var comments = $('#blog_post_comments');
               if ($('.blog-comment', comments).size() > 0) {
                   comments.append(data.comment);
               } else {
                   comments.html(data.comment);
               }
               $('#comment_form_container').html(data.form);
           },
           error: function(xhr){
               $('#comment_form_container').html(xhr.responseText);
           }
        });
        return false;
    });
});
");
?>

<legend>Добавить комментарий</legend>

<?php if ($sf_user->hasFlash('blog_comment_success')): ?>
    <div>Комментарий успешно добавлен.</div>
<?php endif; ?>

<form class="list" id="blog_comment_form" action="<?php echo url_for('sfYaBlogComment_create', $post); ?>" method="post">
    <ol>
        <?php echo $form; ?>
    </ol>
    <div class="buttons">
        <input type="submit" value="Отправить" id="comment_submit" />
    </div>
</form>