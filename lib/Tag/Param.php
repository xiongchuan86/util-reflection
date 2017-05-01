<?php

namespace Kassko\Util\Reflection\Tag;

class Param extends \Kassko\Util\Reflection\Tag
{
    public function __construct($type = null, $name = null, $description = null)
    {
        parent::__construct('param');

        $this->addNamedField('type', $type);
        $this->addNamedField('name', $name);
        $this->addNamedField('description', $description);
    }

    public function getType()
    {
        return $this->getField('type');
    }

    public function setType($type)
    {
        $this->addNamedField('type', $type);

        return $this;
    }

    public function getName()
    {
        return $this->getField('name');
    }

    public function setName($name)
    {
        $this->addNamedField('name', $name);

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
