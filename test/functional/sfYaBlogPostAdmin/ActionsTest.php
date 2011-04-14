<?php
namespace Test\sfYaBlogPlugin\Functional\sfYaBlogPostAdmin;

require_once dirname(__FILE__).'/../../bootstrap/all.php';

use BlogPost, BlogPostForm;

/**
 * sfYaBlogPostAdmin
 */
class ActionsTest extends \myFunctionalTestCase
{
    protected $app = 'admin';


    /**
     * Показать список
     */
    public function testShowList()
    {
        $this->authenticateAdmin();

        $this->browser
            ->getAndCheck('sfYaBlogPostAdmin', 'index', $this->generateUrl('sfYaBlogPostAdmin'), 200)
            ->with('response')->checkElement('.sf_admin_list tbody tr', 0);

        $post = $this->helper->makeBlogPost();

        $this->browser
            ->getAndCheck('sfYaBlogPostAdmin', 'index', $this->generateUrl('sfYaBlogPostAdmin'), 200)
            ->with('response')->begin()
                ->checkElement('.sf_admin_list tbody tr', 1)
                ->checkElement('.sf_admin_list .sf_admin_list_td_title', '/'.$post->getTitle().'/')
            ->end();
    }


    /**
     * Добавить пост
     */
    public function testCreate()
    {
        $admin = $this->authenticateAdmin();

        $this->browser
            ->getAndCheck('sfYaBlogPostAdmin', 'new', $this->generateUrl('sfYaBlogPostAdmin_new'), 200)
                ->with('response')->checkForm(new BlogPostForm)
            ->click('Сохранить', array('blog_post' => $submitData = array(
                'title' => 'Заголовок поста',
                'short' => '<p>Краткий текст</p>',
                'content' => '<p>Полный текст</p>',
                'is_published' => 1,
                'slug' => 'blog-post',
                'meta_title' => 'Заголовок страницы',
                'meta_keywords' => 'Ключевые, слова',
                'meta_description' => 'Описание страницы',
            )))
            ->with('response')->isStatusCode(302)
            ->with('form')->hasErrors(false);

        $this->browser
            ->with('model')->check('BlogPost', $submitData, 1, $found);

        $this->assertModels($admin, $found[0]->getUser());
    }


    /**
     * Редактировать
     */
    public function testUpdate()
    {
        $post = $this->helper->makeBlogPost($oldData = array(
            'slug'=> 'blog-post',
        ));

        $this->browser
            ->getAndCheck('sfYaBlogPostAdmin', 'edit', $this->generateUrl('sfYaBlogPostAdmin_edit', $post), 200)
                ->with('response')->checkForm(new BlogPostForm($post))
            ->click('Сохранить', array('blog_post' => $newData = array(
                'title' => 'Новый Заголовок поста',
                'short' => '<p>Новый Краткий текст</p>',
                'content' => '<p>Новый Полный текст</p>',
                'is_published' => false,
                'meta_title' => 'Новый Заголовок страницы',
                'meta_keywords' => 'Новые, Ключевые, слова',
                'meta_description' => 'Новое Описание страницы',
            )))
            ->with('response')->isStatusCode(302)
            ->with('form')->hasErrors(false);

        $this->browser
            ->with('model')->check('BlogPost', array_merge($oldData, $newData), 1);
    }


   /**
     * Удалить
     */
    public function testDelete()
    {
        $post = $this->helper->makeBlogPost();

        $this->browser
            ->call($this->generateUrl('sfYaBlogPostAdmin_delete', array(
                'id' => $post->getId(),
            )), 'delete', array('_with_csrf' => 1))
            ->with('response')->isStatusCode(302)
            ->with('model')->check('BlogPost', array('id' => $post->getId()), 0);
    }
}
