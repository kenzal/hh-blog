<?php

class PostController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->posts = new Application_Model_PostMapper;
    }

    public function indexAction()
    {
        $this->redirect('/');
    }


    public function postAction()
    {
        $postId = $this->getParam('postId', null);
        $year   = $this->getParam('year',   null);
        $month  = $this->getParam('month',  null);
        $day    = $this->getParam('day',    null);
        $title  = $this->getParam('title',  null);

        // Zend_Debug::dump($this->getRequest);die;
        if(    is_null($postId)
            && (
                    is_null($year)
                 || is_null($month)
                 || is_null($day)
                 || is_null($title)
                )
        ) {
            $this->redirect('/');
            return;
        }

        $post = is_null($postId)
              ? $this->posts->findByDateTitle("{$year}-{$month}-{$day}", $title)
              : $this->posts->find($postId);

        if(!$post) {
            throw new Zend_Controller_Action_Exception('Post Not Found', 404);
        }
        $this->view->post = $post;
    }


}

