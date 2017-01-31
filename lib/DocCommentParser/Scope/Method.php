<?php declare(strict_types=1);

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

    protected function getDocComment() : string
    {
        return $this->reflMethod->getDocComment();
    }
}
