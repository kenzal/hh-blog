<?php

class Application_Model_PostMapper extends Application_Model_MapperAbstract
{
    protected $_dbMappableClass = 'Application_Model_Post';

    protected $_columnMap = [
        'id'=>'postId',
        'author'=>'authorId',
    ];

    public function __construct()
    {
        $this->setDbTable('posts');
    }

    public function findByDay($day)
    {
        return;
    }

}
