<?php

/**
 * PluginBlogComment form.
 */
abstract class PluginBlogCommentForm extends BaseBlogCommentForm
{
    public function setup()
    {
        $this->setWidgets(array(
            'name'    => new sfWidgetFormInput(),
            'comment' => new sfWidgetFormTextarea(),
        ));

        $this->setValidators(array(
            'name'    => new sfMainPlugin\Validator\sfValidatorString(array('max_length' => 255)),
            'comment' => new sfMainPlugin\Validator\sfValidatorString(array('max_length' => 2000)),
        ));

        $this->widgetSchema->setNameFormat('blog_comment[%s]');
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }


    /**
     * Подставляем имя текущего пользователя
     */
    protected function updateDefaultsFromObject()
    {
        parent::updateDefaultsFromObject();
        $this->setDefault('name', $this->object->getUser()->getFirstName());
    }
}
