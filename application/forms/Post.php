<?php

class Application_Form_Post extends Zend_Form
{

    public function init()
    {
        $this->setMethod(Zend_Form::METHOD_POST);

        $this->addElement(
            'text', 
            'title',
            [
                'label'    => 'Title',
                'required' => true,
                'filters'  => ['StringTrim'],
            ]
        );

        $this->addElement(
            'textarea', 
            'body',
            [
                'label'    => 'Content',
                'required' => true,
                'filters'  => ['StringTrim'],
            ]
        );

        $this->addElement(
            'submit', 
            'submit',
            [
                'ignore' => true,
                'label' => 'Post to Blog',
            ]
        );

        $this->addElement('hash', 'csrf', ['ignore'=>true]);
    }


}

