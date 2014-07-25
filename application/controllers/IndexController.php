<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

        $posts = new Application_Model_PostMapper;
        $this->view->posts = $posts->fetchAll();
    }


}

