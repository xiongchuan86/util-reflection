<?php declare(strict_types=1);

namespace Kassko\Util\Reflection\Tag;

class Var_ extends \Kassko\Util\Reflection\Tag
{
    public function __construct(string $type = null, string $description = null)
    {
        parent::__construct('var');

        $this->addNamedField('type', $type);
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
