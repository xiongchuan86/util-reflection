<?php

namespace Kassko\Util\Reflection\Tag;

class Throws extends \Kassko\Util\Reflection\Tag
{
    public function __construct($class = null, $description = null)
    {
        parent::__construct('throws');

        $this->addNamedField('class', $class);
        $this->addNamedField('description', $description);
    }

    public function getClass()
    {
        return $this->getField('class');
    }

    public function setClass($class)
    {
        $this->addNamedField('class', $class);

        return $this;
    }

    public function getDescription()
    {
        return $this->getField('description');
    }

    public function setDescription($description)
    {
        $this->addNamedField('description', $description);

        return $this;
    }
}
