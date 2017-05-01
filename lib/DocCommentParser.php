<?php

namespace Kassko\Util\Reflection;

use Kassko\Util\Reflection\Tag;

abstract class DocCommentParser
{
    /** @var Tag[] */
    protected $allTags = [];
    /** @var Tag[] */
    protected $allCustomTags = [];
    /** @var array */
    protected $tags = [];

    abstract public function parse();

    /**
     * @return DocTag[]
     */
    public function getAllTags()
    {
        return $this->allTags;
    }

    /**
     * @return DocTag[]
     */
    public function getAllCustomTags()
    {
        return $this->allCustomTags;
    }

    public function getTag($name)
    {
        if (!isset($this->tags[$name]) || 0 === sizeof($this->tags[$name])) {
           return null;
        }

        return $this->tags[$name][0];
    }

    public function getTags($name)
    {
        if (!isset($this->tags[$name])) {
           return [];
        }

        return $this->tags[$name];
    }

    protected function addTag($name, Tag $tag)
    {
        if (!isset($this->tags[$name])) {
            $this->tags[$name] = [];
        }

        $this->tags[$name][] = $tag;

        return $this;
    }
}
