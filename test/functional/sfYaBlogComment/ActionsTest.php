<?php
namespace Test\sfYaBlogPlugin\Functional\sfYaBlogComment;

require_once dirname(__FILE__).'/../../bootstrap/all.php';

/**
 * sfYaBlogComment
 */
class ActionsTest extends \myFunctionalTestCase
{
    /**
     * Показать список комментариев
     */
    public function testCommentsList()
    {
        $user = $this->authenticateUser();
        $post = $this->helper->makeBlogPost();

        $this->browser
            ->getAndCheck('sfYaBlogPost', 'show', $this->generateUrl('sfYaBlogPost_show', $post), 200)
            ->with('response')->checkElement('#blog_post_comments .blog-comment', 0);

        $c1 = $this->helper->makeBlogComment($post, $user);
        $c2 = $this->helper->makeBlogComment($post, $user);
        $post->refreshRelated('Comments');

        $this->browser
            ->getAndCheck('sfYaBlogPost', 'show', $this->generateUrl('sfYaBlogPost_show', $post), 200)
            ->with('response')->begin()
                ->isValid(true)
                ->checkElement('#blog_post_comments .blog-comment', 2)
                ->checkElement('#comment-'.$c1->getId(), 1)
                ->checkElement('#comment-'.$c2->getId(), 1)
            ->end();
    }


    /**
     * Показать форму комментирования
     */
    public function testShowForm()
    {
        $this->authenticateUser();
        $post = $this->helper->makeBlogPost();

        $this->browser
            ->getAndCheck('sfYaBlogPost', 'show', $this->generateUrl('sfYaBlogPost_show', $post), 200)
            ->with('response')->begin()
                ->isValid(true)
                ->checkForm(new \BlogCommentForm)
            ->end();
    }


    /**
     * Добавить комментарий
     */
    public function testSubmitForm()
    {
        $user = $this->authenticateUser();
        $post = $this->helper->makeBlogPost();

        // ajax
        $this->browser
            ->getAndCheck('sfYaBlogPost', 'show', $this->generateUrl('sfYaBlogPost_show', $post), 200)
            ->setAjaxHeader()
            ->click('#comment_submit', array(
                'blog_comment' => $submitData = array(
                    'name' => 'Имя автора',
                    'comment' => 'Текст комментария',
                ),
            ))
            ->with('form')->hasErrors(false)
            ->with('model')->check('BlogComment', array_merge($submitData, array(
                'user_id' => $user->getId(),
                'post_id' => $post->getId(),
            )), 1);

        $response = json_decode($this->browser->getResponse()->getContent(), true);
        $this->assertTrue(isset($response['form']));
        $this->assertTrue(isset($response['comment']));

        // not ajax
        $this->browser
            ->getAndCheck('sfYaBlogPost', 'show', $this->generateUrl('sfYaBlogPost_show', $post), 200)
            ->click('#comment_submit', array(
                'blog_comment' => $submitData = array(
                    'name' => 'Имя автора 2',
                    'comment' => 'Текст комментария 2',
                ),
            ))
            ->with('user')->isFlash('blog_comment_success', true)
            ->with('form')->hasErrors(false)
            ->with('response')->checkRedirect(302, $this->generateUrl('sfYaBlogPost_show', $post))
            ->with('model')->check('BlogComment', array_merge($submitData, array(
                'user_id' => $user->getId(),
                'post_id' => $post->getId(),
            )), 1);
    }
}
