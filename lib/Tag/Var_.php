<?php

namespace Kassko\Util\Reflection\Tag;

class Var_ extends \Kassko\Util\Reflection\Tag
{
    public function __construct($type = null, $description = null)
    {
        parent::__construct('var');

        $this->addNamedField('type', $type);
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
