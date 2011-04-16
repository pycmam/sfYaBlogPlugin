<?php

class BasesfYaBlogCommentComponents extends sfComponents
{
    /**
     * Форма добавления комментария
     *
     * @var BlogPost $post
     */
    public function executeForm()
    {
        $comment = new BlogComment;
        $comment->setUser($this->getUser()->getProfile());

        $this->form = new BlogCommentForm($comment);
    }
}