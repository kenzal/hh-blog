<?php

class Application_View_Helper_PostUrl extends Zend_View_Helper_Abstract
{
    public function postUrl(Application_Model_Post $post)
    {
        $url = $this->view->url(
            [
                'year'  => $post->date->format('Y'),
                'month' => $post->date->format('m'),
                'day'   => $post->date->format('d'),
                'title' => $post->getSlug(),
            ],
            'post'
        );
        return $url;
    }
}
