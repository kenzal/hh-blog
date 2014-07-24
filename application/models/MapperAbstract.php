<?php

abstract class Application_Model_MapperAbstract
{
    protected $_dbTable;
    protected $_dbMappableClass;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        return $this->_dbTable;
    }

    public function setMappableClass($class)
    {

    }

    abstract public function save($mappable);
    abstract public function find($id, $mappable);
    abstract public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = [];
        foreach ($resultSet as $row) {
            $entry = new $this->_dbMappableClass;
            $entry->setOptions((array)$row);
            $entries[] = $entry;
        }
        return $entries;
    }

    public static function prepForDb(array $oldValues)
    {
        $newValues = [];
        foreach ($values as $key=>$value) {
            if ($value instanceof DateTimeInterface || $value instanceof Zend_Date) {
                $newValue[$key] = new Zend_Db_Expr("FROM_UNIXTIME({$value->getTimestamp()})");
            }
        }
    }
}
