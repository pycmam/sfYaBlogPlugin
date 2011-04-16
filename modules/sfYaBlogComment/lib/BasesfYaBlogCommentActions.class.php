<?php

class BasesfYaBlogCommentActions extends sfActions
{
    /**
     * Добавление комментария
     */
    public function executeCreate(sfWebRequest $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        $post = $this->getRoute()->getObject();
        $form = $this->getForm($post);

        $form->bind($request->getParameter($form->getName()));
        if ($form->isValid()) {
            $comment = $form->save();
            $this->dispatcher->notify(new sfEvent($comment, 'sfYaBlog.comment_success'));
            $this->getUser()->setFlash('blog_comment_success', true, !$isAjax);
            $this->setVar('form', $form); // тестам

            if ($isAjax) {
                $response = array(
                    'comment' => $this->getPartial('comment_item', array(
                        'comment' => $comment,
                    )),
                    'form' => $this->getPartial('form', array(
                        'form' => $this->getForm($post),
                        'post' => $post,
                    )),
                );
                return $this->renderText(json_encode($response));
            }
        } else {
            $this->getResponse()->setStatusCode(400);
        }

        if ($isAjax) {
            return $this->renderPartial('form', array(
                'form' => $form,
                'post' => $post,
            ));
        }

        $this->redirect('sfYaBlogPost_show', $post);
    }


    /**
     * Создать форму
     *
     * @param BlogPost $post
     * @return BlogPostForm
     */
    protected function getForm(BlogPost $post)
    {
        $comment = new BlogComment;
        $comment->setPost($post);
        $comment->setUser($this->getUser()->getProfile());

        return new BlogCommentForm($comment);
    }
}