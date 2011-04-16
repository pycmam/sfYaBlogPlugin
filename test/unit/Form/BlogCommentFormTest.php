<?php
namespace Test\sfYaBlogPlugin\Unit\Form;

require_once dirname(__FILE__).'/../../bootstrap/all.php';

use BlogCommentForm, BlogComment;


class BlogPostFormTest extends \myFormTestCase
{
    protected $app = 'admin';


    /**
     * Создать форму
     */
    public function makeForm()
    {
        $post = $this->helper->makeBlogPost();
        $user = $this->helper->makeUser();
        $comment = new BlogComment;
        $comment->setUser($user);
        $comment->setPost($post);

        return new BlogCommentForm($comment);
    }


    /**
     * Получить массив доступных полей формы
     */
    protected function getFields()
    {
        return array(
            'name' => array(
                'required'    => true,
                'trim'        => true,
                'max_length'  => 255,
                'instanceof'  => 'sfMainPlugin\Validator\sfValidatorString',
            ),
            'comment' => array(
                'required'    => true,
                'trim'        => true,
                'max_length'  => 2000,
                'instanceof'  => 'sfMainPlugin\Validator\sfValidatorString',
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
            'name' => 'Имя',
            'comment' => 'Текст комментария',
        );
    }

}
