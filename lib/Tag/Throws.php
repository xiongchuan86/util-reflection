<?php declare(strict_types=1);

namespace Kassko\Util\Reflection\Tag;

class Throws extends \Kassko\Util\Reflection\Tag
{
    public function __construct(string $class = null, string $description = null)
    {
        parent::__construct('throws');

        $this->addNamedField('class', $class);
        $this->addNamedField('description', $description);
    }

    public function getClass()
    {
        return $this->getField('class');
    }

    public function setClass(string $class) : self
    {
        $this->addNamedField('class', $class);

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
