<?php

class Application_Model_Post extends Application_Model_MappableAbstract
{
    protected $_author;
    protected $_body;
    protected $_date;
    protected $_id;
    protected $_isDraft;
    protected $_title;

    public function setAuthor(Application_Model_Author $author)
    {
        $this->_author = $author;
    }

    public function setBody($body)
    {
        $this->_body = (string)$body;
    }

    public function setDate(DateTimeInterface $date)
    {
        $this->_date = $date;
    }

    public function setId($id)
    {
        if(is_null($id) || ($id==(int)$id && $id>=0)) {
            $this->_id = $id;
        }
        throw new OutOfRangeException();
    }

    public function setIsDraft($isDraft)
    {
        $this->_isDraft = (bool)$isDraft;
    }

    public function setTitle($title)
    {
        $this->_title = (string)$title;
    }


}
