<?php declare(strict_types=1);

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

    public function setType(string $type) : self
    {
        $this->addNamedField('type', $type);

        return $this;
    }

    public function getName()
    {
        return $this->getField('name');
    }

    public function setName(string $name) : self
    {
        $this->addNamedField('name', $name);

        return $this;
    }

    public function getDescription()
    {
        return $this->getField('description');
    }

    public function setDescription(string $description) : self
    {
        $this->addNamedField('description', $description);

        return $this;
    }
}
