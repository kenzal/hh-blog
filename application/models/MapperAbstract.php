<?php

abstract class Application_Model_MapperAbstract
{
    protected $_dbTable;
    protected $_dbMappableClass;
    protected $_columnMap = [];
    protected $_additionalFields = [];

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable) && class_exists($dbTable)) {
            $dbTable = new $dbTable();
        } elseif (is_string($dbTable)) {
            $dbTable = new Zend_Db_Table($dbTable);
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
        if (is_object($class)) {
            $this->_dbMappableClass = get_class($class);
            return;
        }
        if (is_string($class) && class_exists($class)) {
            $this->_dbMappableClass = $class;
            return;
        }
        throw new InvalidArgumentException('Argument must be a valid class name or an object of the inteded class');
    }


    public function save($mappable)
    {
        if (!($mappable instanceof $this->_dbMappableClass)) {
            $msg = __METHOD__ . " accepts only {$this->_dbMappableClass}";
            throw new InvalidArgumentException($msg);
        }
        $data = $this->prepForDb($this->getOptions());
        if (null === ($key = $mappable->getId())) {
            unset($data[$this->_columnMap['id']]);
            $this->getDbTable()->insert($data);
            return;
        }
        $this->getDbTable()->update($data, array("{$this->_columnMap['id']} = ?" => $key));
    }

    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $entry = new $this->_dbMappableClass;
        $entry->setOptions($this->remapColumns($row->toArray()));
        return $entry;
    }

    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        $resultSet = $this->getDbTable()->fetchAll(
            $where,
            $order,
            $count,
            $offset
        );
        $entries   = [];
        foreach ($resultSet as $row) {
            $entry = new $this->_dbMappableClass;
            $entry->setOptions($this->remapColumns($row->toArray()));
            $entries[] = $entry;
        }
        return $entries;
    }

    public function prepForDb(array $oldValues)
    {
        $newValues = [];
        foreach ($oldValues as $key=>$value) {
            if(array_key_exists($key, $this->_columnMap)) {
                $key = $this->_columnMap[$key];
            }
            if ($value instanceof DateTimeInterface || $value instanceof Zend_Date) {
                $newValue[$key] = new Zend_Db_Expr("FROM_UNIXTIME({$value->getTimestamp()})");
            }
        }
        return $newValues;
    }

    public function remapColumns(array $dbValues)
    {
        $newValues = [];
        $map = array_flip($this->_columnMap);
        foreach ($dbValues as $key=>$value) {
            if(array_key_exists($key, $map)) {
                $key = $map[$key];
            }
            $newValues[$key] = $value;
        }

        return $newValues;
    }
}
