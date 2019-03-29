<?php declare(strict_types=1);

namespace Kassko\Util\Reflection\DocCommentParser\Scope;

use Kassko\Util\Reflection\Tag;

class Property extends \Kassko\Util\Reflection\DocCommentParser\Scope
{
    /** @var \ReflectionProperty */
    private $reflProperty;

    public function __construct(\ReflectionProperty $reflProperty)
    {
        $this->reflProperty = $reflProperty;
    }

    protected function getDocComment() : string
    {
        return (string)$this->reflProperty->getDocComment();
    }
}
