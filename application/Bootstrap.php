<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDocType()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
    }

    protected function _initRouter()
    {
        // make sure resource is bootstrapped
        $this->bootstrap('frontController');

        $front = $this->getResource('frontController');
        $router = $front->getRouter();

        $router->addRoute(
            'post',
            new Zend_Controller_Router_Route_Regex(
                '(\d{4})/(\d{1,2})/(\d{1,2})/(.+)',
                [
                    'module' => 'default',
                    'controller' => 'post',
                    'action' => 'post',
                ],
                [
                    1 => 'year',
                    2 => 'month',
                    3 => 'day',
                    4 => 'title',
                ],
                '%d/%d/%d/%s'
            )
        );

    }

}

