<?php

class BasesfYaBlogPostActions extends sfActions
{
    /**
     * Список постов
     */
    public function executeIndex(sfWebRequest $request)
    {
       $this->pager = new sfDoctrinePager('BlogPost', sfConfig::get('app_sf_ya_blog_plugin_posts_per_page'));
       $this->pager->setQuery(BlogPostTable::getInstance()->queryActive());
       $this->pager->setPage($request->getParameter('page'));
       $this->pager->init();
    }


    /**
     * Показать пост
     */
    public function executeShow()
    {
        $this->post = $this->getRoute()->getObject();

        $response = $this->getResponse();

        if ($title = $this->post->getMetaTitle()) {
            $response->setTitle($title);
            $response->addHttpMeta('title', $title);
        }

        if ($keywords = $this->post->getMetaKeywords()) {
            $response->addHttpMeta('keywords', $keywords);
        }

        if ($description = $this->post->getMetaDescription()) {
            $response->addHttpMeta('description', $description);
        }
    }
}