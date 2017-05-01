<?php

namespace Kassko\Util\Reflection;

class ReflectionClass extends \ReflectionClass
{
    /** @var ReflectionClass */
    private $innerRefl;
    /** @var PhpElementsParser */
    private $phpElementsParser;
    /** @var array */
    private $cache = [];

    public function __construct(\ReflectionClass $innerRefl, PhpElementsParser $phpElementsParser)
    {
        $this->innerRefl = $innerRefl;
        $this->phpElementsParser = $phpElementsParser;
    }

    public function getNativeRefl()
    {
        return $this->innerRefl;
    }

    public function getPropertiesNames()
    {
        $key = 'properties_names';

        if (!isset($this->cache[$key])) {
            $propertiesNames = array_map(
                function ($property) {
                    return $property->getName();
                },
                $this->innerRefl->getProperties()
            );

            $this->cache[$key] = array_combine($propertiesNames, $propertiesNames);
        }

        return $this->cache[$key];
    }

    public function getMethodsNames()
    {
        $key = 'methods_names';

        if (!isset($this->cache[$key])) {
            $methodsNames = array_map(
                function ($method) {
                    return $method->getName();
                },
                $this->innerRefl->getMethods()
            );
            $this->cache[$key] = array_combine($methodsNames, $methodsNames);
        }

        return $this->cache[$key];
    }

    /**
     * @param string $type
     * @param string $parentFullClass
     *
     * @return array
     */
    protected function resolveType($type, $parentFullClass)
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
