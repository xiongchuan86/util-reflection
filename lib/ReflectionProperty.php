<?php

namespace Kassko\Util\Reflection;

class ReflectionProperty extends \ReflectionProperty
{
    /** @var ReflectionClass */
    private $innerRefl;
    /** @var array */
    private $cache = [];

    public function __construct(\ReflectionProperty $innerRefl)
    {
        $this->innerRefl = $innerRefl;
    }

    public function getNativeRefl()
    {
        return $this->innerRefl;
    }

    /**
     * @param string $type
     * @param string $parentFullClass
     *
     * @return array
     */
    protected function resolveType($type)
    {
        if ('$this' === $type || 'self' === $type) {
            $type = 'object';
            $fullClass = $parentFullClass;
        } elseif (in_array($type, ['boolean', 'float', 'integer', 'string', 'array'])) {
            $fullClass = null;
        } else {
            $fullClass = $this->phpElementsParser->resolveFullClass($parentFullClass, $type);
            $type = 'object';
        }

        return [$type, $fullClass];
    }
}
