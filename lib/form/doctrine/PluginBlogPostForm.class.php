<?php

/**
 * PluginBlogPost form.
 */
abstract class PluginBlogPostForm extends BaseBlogPostForm
{
    public function setup()
    {
        $tinyMCEConfig = sfConfig::get('app_sf_ya_blog_plugin_tiny_mce_config');

        $this->setWidgets(array(
            'id'               => new sfWidgetFormInputHidden(),
            'title'            => new sfWidgetFormInput(),
            'is_published'     => new sfWidgetFormInputCheckbox(),
            'short'            => new sfWidgetFormTextareaTinyMCE($tinyMCEConfig),
            'content'          => new sfWidgetFormTextareaTinyMCE($tinyMCEConfig),
            'slug'             => new sfWidgetFormInput(),
            'meta_title'       => new sfWidgetFormInput(),
            'meta_keywords'    => new sfWidgetFormTextarea(),
            'meta_description' => new sfWidgetFormTextarea(),
        ));

        $this->setValidators(array(
            'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
            'title'            => new sfMainPlugin\Validator\sfValidatorString(array('max_length' => 255)),
            'is_published'     => new sfValidatorBoolean(array('required' => true)),
            'short'            => new sfMainPlugin\Validator\sfValidatorString(),
            'content'          => new sfMainPlugin\Validator\sfValidatorString(array('required' => false)),
            'slug'             => new sfMainPlugin\Validator\sfValidatorSlug(array('max_length' => 50)),
            'meta_title'       => new sfMainPlugin\Validator\sfValidatorString(array('required' => false, 'max_length' => 255)),
            'meta_keywords'    => new sfMainPlugin\Validator\sfValidatorString(array('required' => false, 'max_length' => 1000)),
            'meta_description' => new sfMainPlugin\Validator\sfValidatorString(array('required' => false, 'max_length' => 2000)),
        ));

        $this->widgetSchema->setNameFormat('blog_post[%s]');
        $this->validatorSchema->setPostValidator(
            new sfValidatorDoctrineUnique(array('model' => 'BlogPost', 'column' => array('slug')))
        );
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }
}
