<?php

class Application_Model_Post extends Application_Model_MappableAbstract
{
    protected $_author;
    protected $_body;
    protected $_date;
    protected $_id;
    protected $_isDraft;
    protected $_title;

    public function setAuthor($author)
    {
        if (is_numeric($author)) {
            $authors = new Application_Model_AuthorMapper;
            $author = $authors->find((int)$author);
        }
        if (!($author instanceof Application_Model_Author)) {
            throw new InvalidArgumentException('Author must be instance of InvalidArgumentException or valid Author id');
        }
        $this->_author = $author;
    }

    public function setBody($body)
    {
        $this->_body = (string)$body;
    }

    public function setDate($date)
    {
        if(is_string($date)) {
            $date = new DateTime($date);
        }
        $this->_date = $date;
    }

    public function setId($id)
    {
        if(is_null($id) || ($id==(int)$id && $id>=0)) {
            $this->_id = $id;
            return $this;
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
