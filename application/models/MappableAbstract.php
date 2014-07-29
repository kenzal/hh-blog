<?php

class Application_Model_MappableAbstract
{

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $property = '_' . lcfirst($name);
        $method   = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
        }
        if(property_exists($this, $property)) {
            return $this->$property = $value;
        }
        throw new Exception('Invalid property');
    }

    public function __get($name)
    {
        $property = '_' . lcfirst($name);
        $method   = 'get' . ucfirst($name);
        if(method_exists($this, $method)) {
            return $this->method();
        }
        if(property_exists($this, $property)) {
            return $this->$property;
        }
        throw new Exception('Invalid property');
    }

    public function setOptions(array $options)
    {
        $methods    = get_class_methods($this);
        $properties = get_object_vars($this);
        foreach ($options as $key => $value) {
            $method   = 'set' . ucfirst($key);
            $property = '_' . lcfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            } elseif (in_array($property, $properties)) {
                $this->$property = $value;
            }
        }
        return $this;
    }

    public function getOptions()
    {
        $config = [];
        foreach (get_object_vars($this) as $key=>$val) {
            if (substr($key, 0, 1) ==='_') {
                $config[substr($key, 1)] = $val;
            }
        }
        return $config;
    }
}
