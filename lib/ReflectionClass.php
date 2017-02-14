<?php declare(strict_types=1);

namespace Kassko\Util\Reflection;

class ReflectionClass extends \ReflectionClass
{
    /** @var ReflectionClass */
    private $innerRefl;
    /** @var PhpElementsParser */
    private $phpElementsParser;
    /** @var array */
    private $cached = [];
    /** @var array */
    private $propertiesNames;
    /** @var array */
    private $methodsNames;

    public function __construct(\ReflectionClass $innerRefl, PhpElementsParser $phpElementsParser)
    {
        $this->innerRefl = $innerRefl;
        $this->phpElementsParser = $phpElementsParser;
    }

    public function getNativeRefl() : \ReflectionClass
    {
        return $this->innerRefl;
    }

    public function getPropertiesNames() : array
    {
        if (isset($this->cached['prop_names'])) {
            return $this->propertiesNames;
        }
        $this->cached['prop_names'] = true;

        $this->propertiesNames = array_map(
            function ($method) {
                return $method->getName();
            },
            $this->innerRefl->getProperties()
        );


        return $this->propertiesNames = array_combine($this->propertiesNames, $this->propertiesNames);
    }

    public function getMethodsNames() : array
    {
        if (isset($this->cached['methods_names'])) {
            return $this->methodsNames;
        }
        $this->cached['methods_names'] = true;

        $this->methodsNames = array_map(
            function ($method) {
                return $method->getName();
            },
            $this->innerRefl->getMethods()
        );

        return $this->methodsNames = array_combine($this->methodsNames, $this->methodsNames);
    }

    /**
     * @param string $type
     * @param string $parentFullClass
     *
     * @return array
     */
    protected function resolveType($type, $parentFullClass) : array
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
