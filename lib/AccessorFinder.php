<?php declare(strict_types=1);

namespace Kassko\Util\Reflection;

class AccessorFinder
{
    /** @var ReflectionClass */
    private $advReflClass;
    /** @var \ReflectionClass */
    private $nativeReflClass;
    /** @var string */
    private $class;
    /** @var array */
    private $cached = [];

    public function __construct(ReflectionClass $reflClass)
    {
        $this->advReflClass = $reflClass;
        $this->nativeReflClass = $reflClass->getNativeRefl();
        $this->class = $this->nativeReflClass->getName();
    }

    protected function getCandidatesGetters(string $propName) : \Generator
    {
        $methodsBase = ucFirst($propName);

        yield 'get' . $methodsBase;
        yield 'is' . $methodsBase;
        yield 'has' . $methodsBase;
    }

    public function findPropGetter(string $propName)
    {
        $key = 'getter' . $propName;

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $methodsNames = $this->advReflClass->getMethodsNames();

        $electedMethod = null;
        foreach ($this->getCandidatesGetters($propName) as $candidateMethod) {
            if (isset($methodsNames[$candidateMethod])) {
                $reflMethod = $this->nativeReflClass->getMethod($candidateMethod);
                if (0 !== $reflMethod->getNumberOfParameters()) {
                    continue;
                }

                $electedMethod = $methodsNames[$candidateMethod];
                break;
            }
        }

        return $this->cached[$key] = $electedMethod;
    }

    protected function getCandidatesItemGetters(string $propName) : \Generator
    {
        $methodsBase = ucFirst($propName);

        yield 'get' . substr($methodsBase, 0, -1);
        yield 'get' . $methodsBase . 'Item';
    }

    public function findPropItemGetter(string $propName)
    {
        $key = 'item_getter' . $propName;

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $methodsNames = $this->advReflClass->getMethodsNames();

        $electedMethod = null;
        foreach ($this->getCandidatesItemGetters($propName) as $candidateMethod) {
            if (isset($methodsNames[$candidateMethod])) {
                $reflMethod = $this->nativeReflClass->getMethod($candidateMethod);
                if (1 !== $reflMethod->getNumberOfParameters()) {
                    continue;
                }

                $electedMethod = $methodsNames[$candidateMethod];
                break;
            }
        }

        return $this->cached[$key] = $electedMethod;
    }

    protected function getCandidatesSetters(string $propName) : \Generator
    {
        $methodsBase = ucFirst($propName);

        yield 'set' . $methodsBase;
        yield 'with' . $methodsBase;
        yield 'make' . $methodsBase;
    }

    public function findPropSetter(string $propName)
    {
        $key = 'setter' . $propName;

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $methodsNames = $this->advReflClass->getMethodsNames();

        $electedMethod = null;
        foreach ($this->getCandidatesSetters($propName) as $candidateMethod) {
            if (isset($methodsNames[$candidateMethod])) {
                $reflMethod = $this->nativeReflClass->getMethod($candidateMethod);
                if (1 !== $reflMethod->getNumberOfParameters()) {
                    continue;
                }

                $electedMethod = $methodsNames[$candidateMethod];
                break;
            }
        }

        return $this->cached[$key] = $electedMethod;
    }

    protected function getCandidatesAdders(string $propName) : \Generator
    {
        $methodsBase = ucFirst($propName);

        yield 'add' . $methodsBase . 'Item';
        yield 'push' . $methodsBase . 'Item';
        yield 'append' . $methodsBase . 'Item';
    }

    public function findPropAdder(string $propName)
    {
        $key = 'adder' . $propName;

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $methodsNames = $this->advReflClass->getMethodsNames();

        $electedMethod = null;
        foreach ($this->getCandidatesAdders($propName) as $candidateMethod) {
            if (isset($methodsNames[$candidateMethod])) {
                $reflMethod = $this->nativeReflClass->getMethod($candidateMethod);
                if (1 !== $reflMethod->getNumberOfParameters()) {
                    continue;
                }

                $electedMethod = $methodsNames[$candidateMethod];
                break;
            }
        }

        return $this->cached[$key] = $electedMethod;
    }

    protected function getCandidatesAssocAdders(string $propName) : \Generator
    {
        $methodsBase = ucFirst($propName);

        yield 'add' . $methodsBase . 'Item';
    }

    public function findPropAssocAdder(string $propName)
    {
        $key = 'assoc_adder' . $propName;

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $methodsNames = $this->advReflClass->getMethodsNames();

        $electedMethod = null;
        foreach ($this->getCandidatesAssocAdders($propName) as $candidateMethod) {
            if (isset($methodsNames[$candidateMethod])) {
                $reflMethod = $this->nativeReflClass->getMethod($candidateMethod);
                if (2 !== $reflMethod->getNumberOfParameters()) {
                    continue;
                }
                $electedMethod = $methodsNames[$candidateMethod];

                break;
            }
        }

        return $this->cached[$key] = $electedMethod;
    }

    /**
     * @return array
     */
    public function findGetters() : array
    {
        $key = 'getters';

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $properties = $this->advReflClass->getPropertiesNames();
        $methods = $this->advReflClass->getMethodsNames();

        return $this->cached[$key] = array_merge($this->findStrictGetters(), $this->findIsers(), $this->findHasers());
    }

    public function findStrictGetters() : array
    {
        $key = 'strict_getters';

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $properties = $this->advReflClass->getPropertiesNames();
        $methods = $this->advReflClass->getMethodsNames();

        return $this->cached[$key] = array_filter(
            $methods,
            function ($method) use ($properties) {
                return 'get' === substr($method, 0, 3)
                &&
                in_array(lcfirst(substr($method, 3)), $properties);
            }
        );
    }

    public function findIsers() : array
    {
        $key = 'isers';

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $properties = $this->advReflClass->getPropertiesNames();
        $methods = $this->advReflClass->getMethodsNames();

        return $this->cached[$key] = array_filter(
            $methods,
            function ($method) use ($properties) {
                return 'is' === substr($method, 0, 2)
                &&
                in_array(lcfirst(substr($method, 2)), $properties);
            }
        );
    }

    public function findHasers() : array
    {
        $key = 'hasers';

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $properties = $this->advReflClass->getPropertiesNames();
        $methods = $this->advReflClass->getMethodsNames();

        return $this->cached[$key] = array_filter(
            $methods,
            function ($method) use ($properties) {
                return 'has' === substr($method, 0, 3)
                &&
                in_array(lcfirst(substr($method, 3)), $properties);
            }
        );
    }

    /**
     * @return array
     */
    public function findSetters() : array
    {
        $key = 'setters';

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $properties = $this->advReflClass->getPropertiesNames();
        $methods = $this->advReflClass->getMethodsNames();

        return $this->cached[$key] = array_merge($this->findStrictSetters(), $this->findWithers(), $this->findMakers());
    }

    /**
     * @return array
     */
    public function findStrictSetters() : array
    {
        $key = 'strict_setters';

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $properties = $this->advReflClass->getPropertiesNames();
        $methods = $this->advReflClass->getMethodsNames();

        return $this->cached[$key] = array_filter(
            $methods,
            function ($method) use ($properties) {
                return
                'set' === substr($method, 0, 3)
                &&
                in_array(lcfirst(substr($method, 3)), $properties);
            }
        );
    }

    /**
     * @return array
     */
    public function findWithers() : array
    {
        $key = 'withers';

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $properties = $this->advReflClass->getPropertiesNames();
        $methods = $this->advReflClass->getMethodsNames();

        return $this->cached[$key] = array_filter(
            $methods,
            function ($method) use ($properties) {
                return
                'with' === substr($method, 0, 4)
                &&
                in_array(lcfirst(substr($method, 4)), $properties);
            }
        );
    }

    /**
     * @return array
     */
    public function findMakers() : array
    {
        $key = 'makers';

        if (isset($this->cached[$key])) {
            return $this->cached[$key];
        }

        $properties = $this->advReflClass->getPropertiesNames();
        $methods = $this->advReflClass->getMethodsNames();

        return $this->cached[$key] = array_filter(
            $methods,
            function ($method) use ($properties) {
                return
                'make' === substr($method, 0, 4)
                &&
                in_array(lcfirst(substr($method, 4)), $properties);
            }
        );
    }
}
