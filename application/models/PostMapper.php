<?php

class Application_Model_PostMapper extends Application_Model_MapperAbstract
{
    protected $_dbMappableClass = 'Application_Model_Post';

    protected $_columnMap = [
        'id'=>'postId',
        'author'=>'authorId',
    ];
    protected $_dbDefaults = [];

    public function __construct()
    {
        $this->setDbTable('posts');
        $currentTimestamp = new Zend_Db_Expr('CURRENT_TIMESTAMP');
        $this->_dbDefaults = [
            'date'     => $currentTimestamp,
            'isDraft'  => false,
            'created'  => $currentTimestamp,
            'modified' => $currentTimestamp,
        ];
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
               ->where('slugify(title) = slugify(?)', $title);
        return current($this->fetchAll($select));
    }

}
