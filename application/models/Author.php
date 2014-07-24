<?php

class Application_Model_Author extends Application_Model_MappableAbstract
{

    protected $_displayName;
    protected $_id;
    protected $_username;

    public function setDisplayName($displayName)
    {
        $this->_displayName = (string) $displayName;
    }

    public function setId($id)
    {
        if(is_null($id) || ($id==(int)$id && $id>=0)) {
            $this->_id = $id;
        }
        throw new OutOfRangeException();
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

}
