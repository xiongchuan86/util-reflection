<?php declare(strict_types=1);

namespace Kassko\Util\Reflection;

class Type
{
    /** @var string */
    private $type;
    /** @var boolean */
    private $collection;
    /** @var string */
    private $itemType;
    /** @var boolean */
    private $builtin;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function setType(string $type) : string
    {
        $this->type = $type;

        return $this;
    }

    public function isCollection() : boolean
    {
        return $this->collection;
    }

    public function makeCollection(boolean $collection = true)
    {
        $this->collection = $collection;

        return $this;
    }

    public function getItemType() : string
    {
        return $this->itemType;
    }

    public function setItemType(string $itemType) : string
    {
        $this->itemType = $itemType;

        return $this;
    }

    public function isBuiltin() : boolean
    {
        return $this->builtin;
    }

    public function makeBuiltin(boolean $builtin = true) : boolean
    {
        $this->builtin = $builtin;

        return $this;
    }

    public function __toString() : string
    {
        return $this->type;
    }
}
