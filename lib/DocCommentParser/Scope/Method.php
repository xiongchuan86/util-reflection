<?php

namespace Kassko\Util\Reflection\DocCommentParser\Scope;

use Kassko\Util\Reflection\Tag;

class Method extends \Kassko\Util\Reflection\DocCommentParser\Scope
{
    /** @var \ReflectionMethod */
    private $reflMethod;

    public function __construct(\ReflectionMethod $reflMethod)
    {
        $this->reflMethod = $reflMethod;
    }

    protected function getDocComment()
    {
        return $this->reflMethod->getDocComment();
    }
}
