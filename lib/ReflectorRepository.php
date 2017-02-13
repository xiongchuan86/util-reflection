<?php declare(strict_types=1);

namespace Kassko\Util\Reflection;

class ReflectorRepository
{
    /**
     * @var array
     */
    private $cache = [];

    public function reflClass($classOrObject)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'refl_class.' . $class;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new \ReflectionClass($class);
        }

        return $this->cache[$key];
    }

    public function reflProperty($classOrObject, $property)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'refl_prop.' . '.' . $class . '.' . $property;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new \ReflectionProperty($class, $property);
        }

        return $this->cache[$key];
    }

    public function reflMethod($classOrObject, $method)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'refl_method' . '.' . $class . '.' . $method;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new \ReflectionMethod($class, $property);
        }

        return $this->cache[$key];
    }

    public function advReflClass($classOrObject)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'adv_refl_class.' . $class;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new ReflectionClass($this->reflClass($class));
        }

        return $this->cache[$key];
    }

    public function accessorFinder($classOrObject)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'accessor.' . $class;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new AccessorFinder($this->advReflClass($class));
        }

        return $this->cache[$key];
    }

    public function classDocParser($classOrObject)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'class_doc_parser.' . $class;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new DocCommentParser\Scope\Class_($this->advReflClass($class));
        }

        return $this->cache[$key];
    }

    public function propertyDocParser($classOrObject, $property)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'prop_doc_parser' . '.' . $class . '.' . $property;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new DocCommentParser\Scope\Property($this->reflProperty($class, $property));
        }

        return $this->cache[$key];
    }

    public function methodDocParser($classOrObject, $method)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'method_doc_parser' . '.' . $class . '.' . $method;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new DocCommentParser\Scope\Method($this->reflMethod($class, $method));
        }

        return $this->cache[$key];
    }

    public function fullDocParser($classOrObject)
    {
        $class = is_string($classOrObject) ? $classOrObject : get_class($classOrObject);
        $key = 'full_doc_parser' . '.' . $class . '.' . $method;

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = new DocCommentParser\FullScope(
                $class,
                $this
            );
        }

        return $this->cache[$key];
    }

    public function newPhpElemParser()
    {
        return new PhpElementsParser();
    }
}
