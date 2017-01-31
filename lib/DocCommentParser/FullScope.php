<?php declare(strict_types=1);

namespace Kassko\Util\Reflection\DocCommentParser;

use Kassko\Util\Reflection\DocCommentParser;
use Kassko\Util\Reflection\ReflectorRepository;

class FullScope extends \Kassko\Util\Reflection\DocCommentParser
{
    /** @var array */
    private $cached = [];
    /** @var string */
    private $class;
    /** @var ReflectorRepository */
    private $reflectorRepo;

    public function __construct($class, ReflectorRepository $reflectorRepo)
    {
        $this->class = $class;
        $this->reflectorRepo = $reflectorRepo;
    }

    public function parse()
    {
        if (isset($this->cached['doc'])) {
            return;
        }

        $reflClass = $this->reflectorRepo->advReflClass($this->class);
        foreach ($reflClass->getPropertiesNames() as $propertyName) {
            $this->allTags = array_merge($this->allTags, $this->reflectorRepo->propertyDocParser($this->class, $propertyName)->getAllTags());
            $this->allCustomTags = array_merge($this->allCustomTags, $this->reflectorRepo->propertyDocParser($this->class, $propertyName)->getAllCustomTags());
            $this->tags = array_merge_recursive($this->tags, $this->reflectorRepo->propertyDocParser($this->class, $propertyName)->getTags());
        }

        $reflClass = $this->reflectorRepo->advReflClass($this->class);
        foreach ($reflClass->getMethodsNames() as $methodName) {
            $this->allTags = array_merge($this->allTags, $this->reflectorRepo->methodDocParser($this->class, $methodName)->getAllTags());
            $this->allCustomTags = array_merge($this->allCustomTags, $this->reflectorRepo->methodDocParser($this->class, $methodName)->getAllCustomTags());
            $this->tags = array_merge_recursive($this->tags, $this->reflectorRepo->methodDocParser($this->class, $methodName)->getTags());
        }

        $this->cached['doc'] = true;
    }
}
