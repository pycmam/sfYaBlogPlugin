<?php
namespace Test\sfYaBlogPlugin\Unit\Form;

require_once dirname(__FILE__).'/../../bootstrap/all.php';

use BlogPostForm, BlogPost;


class BlogPostFormTest extends \myFormTestCase
{
    protected $app = 'admin';


    /**
     * Создать форму
     */
    public function makeForm(BlogPost $post = null)
    {
        if (!$post) {
            $post = new BlogPost;
        }
        return new BlogPostForm($post);
    }


    /**
     * Получить массив доступных полей формы
     */
    protected function getFields()
    {
        return array(
            'id' => null,
            'title' => array(
                'required'    => true,
                'trim'        => true,
                'max_length'  => 255,
                'instanceof'  => 'sfMainPlugin\Validator\sfValidatorString',
            ),
            'short' => array(
                'required'    => true,
                'trim'        => true,
                'instanceof'  => 'sfMainPlugin\Validator\sfValidatorString',
            ),
            'content' => array(
                'required'    => false,
                'trim'        => true,
                'instanceof'  => 'sfMainPlugin\Validator\sfValidatorString',
            ),
            'is_published' => array(
                'required'    => true,
            ),
            'slug' => array(
                'required'    => true,
                'trim'        => true,
                'max_length'  => array(str_pad('', 50, 'z') => true, str_pad('', 51, 'z') => false),
                'instanceof'  => 'sfMainPlugin\Validator\sfValidatorSlug',
            ),
            'meta_title' => array(
                'required'    => false,
                'trim'        => true,
                'max_length'  => 255,
            ),
            'meta_keywords' => array(
                'required'    => false,
                'trim'        => true,
                'max_length'  => 1000,
            ),
            'meta_description' => array(
                'required'    => false,
                'trim'        => true,
                'max_length'  => 2000,
            ),
            '_csrf_token' => array(
                'required'    => true,
            ),
        );
    }


    /**
     * Получить массив валидных данных
     */
    protected function getValidData()
    {
        return array(
            'id' => null,
            'title' => 'Заголовок поста',
            'short' => '<p>Краткий текст</p>',
            'content' => '<p>Полный текст</p>',
            'is_published' => 1,
            'slug' => 'blog-post',
            'meta_title' => 'Заголовок страницы',
            'meta_keywords' => 'Ключевые, слова',
            'meta_description' => 'Описание страницы',
        );
    }


    /**
     * План тестирования ошибок валидации
     */
    protected function getValidationTestingPlan()
    {
        $post = $this->helper->makeBlogPost();
        $validInput = $this->getValidInput();

        return array(
            // Уникальность slug
            'Unique slug' => new \sfPHPUnitFormValidationItem(
                array_merge($validInput, array(
                    'slug' => $post->getSlug(),
                )),
                array(
                    'slug' => 'invalid',
                )),
        );
    }


    /**
     * Update
     */
    public function testUpdate()
    {
        $post = $this->helper->makeBlogPost();
        $form = $this->makeForm($post);

        $input = $this->getValidInput();
        $input['slug'] = $post->getSlug();

        $form->bind($input, array());
        $this->assertFormIsValid($form);
    }

}
