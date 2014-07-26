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

    public function findByDateTitle($date, $title)
    {
        $date = new DateTime($date);
        $select = $this->getDbTable()->select();
        $select->where('date(`date`) = ?', $date->format('Y-m-d'))
               ->where('title = ?', $title);
        return current($this->fetchAll($select));
    }

}
