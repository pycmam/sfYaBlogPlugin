<?php

require_once dirname(__FILE__).'/sfYaBlogPostAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/sfYaBlogPostAdminGeneratorHelper.class.php';

/**
 * BasesfYaBlogPostAdmin
 */
class BasesfYaBlogPostAdminActions extends autoSfYaBlogPostAdminActions
{
    public function preExecute()
    {
        parent::preExecute();

        $this->dispatcher()->connect('admin.save_object', array($this, 'setAuthor'));
    }


    /**
     * Назначить автора поста
     */
    public function setAuthor(sfEvent $event)
    {
        if (!$event['object']->getUserId(false)) {
            $event['object']->setUser($this->getUser()->getGuardUser());
            $event['object']->save();
        }
    }
}
