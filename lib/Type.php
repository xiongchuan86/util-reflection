<?php

namespace Kassko\Util\Reflection;

class Type
{
    /** @var string */
    private $type;
    /** @var string */
    private $fullClass;
    /** @var string */
    private $resolvedType;
    /** @var boolean */
    private $class;
    /** @var boolean */
    private $collection;
    /** @var boolean */
    private $objectCollection;
    /** @var boolean */
    private $builtIn;

    public function __construct($type, $fullClass)
    {
        $this->type = $type;

        $this->parse();
    }

    protected function parse()
    {
        if ('array' === $this->type) {
            $this->collection = true;
        }

        if (null !== $fullClass) {
            if ('[]' === substr($fullClass, -2)) {
                $this->resolvedType = $fullClass;
                $this->collection = true;
                $this->objectCollection = true;
                $this->itemClass = substr($fullClass, 0, -2);
            } else {
                $this->class = true;
                $this->fullClass = $fullClass;
            }
        } else {
            $this->resolvedType = $this->type;
        }

        $this->builtIn = in_array(
            $this->type, [
                'boolean',
                'integer',
                'int',
                'float',
                'string',
                'array',
                'object',
                'callable',
                'resource',
                'null',
                'mixed',
                'number',
                'callback',
                'array|object',
                'void',
            ]
        );
    }

    public function getType()
    {
        return $this->type;
    }

    public function getClass()
    {
        return $this->fullClass;
    }

    public function getItemClass()
    {
        return $this->itemClass;
    }

    public function isClass()
    {
        return $this->class;
    }

    public function isCollection()
    {
        return $this->collection;
    }

    public function isObjectCollection()
    {
        return $this->objectCollection;
    }

    protected function isBuiltIn()
    {
        return $this->builtIn;
    }

    public function __toString()
    {
        return $this->type;
    }
}
