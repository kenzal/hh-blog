<?php

class Application_Model_AuthorMapper extends Application_Model_MapperAbstract
{
    protected $_dbMappableClass = 'Application_Model_Author';

    public function __construct()
    {
        $this->setDbTable('users');
    }

    public function save($author)
    {
        if (!($author instanceof $this->_dbMappableClass)) {
            throw new InvalidArgumentException(__METHOD__ . " accepts only {$this->_dbMappableClass}");
        }
        $data = static::prepForDb($this->getOptions());
        if (null === ($id = $author->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
            return;
        }
        $this->getDbTable()->update($data, array('id = ?' => $id));
    }
}
