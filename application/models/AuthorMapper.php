<?php

class Application_Model_AuthorMapper extends Application_Model_MapperAbstract
{
    protected $_dbMappableClass = 'Application_Model_Author';

    protected $_columnMap = [
        'id'=>'userId',
    ];

    public function __construct()
    {
        $this->setDbTable('users');
    }

    public function findByName($name)
    {
        $select = $this->getDbTable()->select()->where('userName = ?', $name);
        $row = $this->getDbTable()->fetchRow($select);
        if (is_null($row)) {
            return;
        }
        $entry = new $this->_dbMappableClass;
        $entry->setOptions($this->remapColumns($row->toArray()));
        return $entry;
    }

}
