<?php
namespace Test\sfYaBlogPlugin\Functional\sfYaBlogPost;

require_once dirname(__FILE__).'/../../bootstrap/all.php';

/**
 * sfYaBlogPost
 */
class ActionsTest extends \myFunctionalTestCase
{

    /**
     * SetUp
     */
    protected function _start()
    {
        $this->authenticateUser();
    }


    /**
     * Показать список
     */
    public function testList()
    {
        $this->browser
            ->getAndCheck('sfYaBlogPost', 'index', $this->generateUrl('sfYaBlogPost'), 200)
            ->with('response')->checkElement('.blog-post', 0);

        $p1 = $this->helper->makeBlogPost();
        $p2 = $this->helper->makeBlogPost();

        $this->browser
            ->getAndCheck('sfYaBlogPost', 'index', $this->generateUrl('sfYaBlogPost'), 200)
            ->with('response')->begin()
                ->isValid(true)
                ->checkElement('.blog-post', 2)
                ->checkElement('#post-'.$p1->getId(), 1)
                ->checkElement('#post-'.$p2->getId(), 1)
            ->end();
    }


    /**
     * Показать пост
     */
    public function testShow()
    {
        $post = $this->helper->makeBlogPost();

        $this->browser
            ->getAndCheck('sfYaBlogPost', 'show', $this->generateUrl('sfYaBlogPost_show', $post), 200)
            ->with('response')->begin()
                ->isValid(true)
                ->matches('/meta http-equiv="Title" content="'. $post->getMetaTitle() .'"/')
                ->matches('/meta http-equiv="Keywords" content="'. $post->getMetaKeywords() .'"/')
                ->matches('/meta http-equiv="Description" content="'. $post->getMetaDescription() .'"/')
            ->end();
    }
}
