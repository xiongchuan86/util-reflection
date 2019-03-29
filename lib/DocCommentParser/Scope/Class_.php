<?php declare(strict_types=1);

namespace Kassko\Util\Reflection\DocCommentParser\Scope;

use Kassko\Util\Reflection\ReflectionClass;

class Class_ extends \Kassko\Util\Reflection\DocCommentParser\Scope
{
    /** @var \ReflectionClass */
    private $nativeReflClass;

    public function __construct(ReflectionClass $reflClass)
    {
        $this->nativeReflClass = $reflClass->getNativeRefl();
    }

    protected function getDocComment() : string
    {
        return (string)$this->nativeReflClass->getDocComment();
    }
}
