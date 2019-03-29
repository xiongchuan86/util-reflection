<?php declare(strict_types=1);

namespace Kassko\Util\Reflection\DocCommentParser;

use Kassko\Util\Reflection\Tag;

abstract class Scope extends \Kassko\Util\Reflection\DocCommentParser
{
    /** @var array */
    private $cached = [];
    /** @var array */
    private $fieldsNumbersByTags = [];

    public function setFieldsNumbersByTags(array $fieldsNumbersByTags) : self
    {
        $this->fieldsNumbersByTags = $fieldsNumbersByTags;

        return $this;
    }

    public function parse()
    {
        if (isset($this->cached['doc'])) {
            return;
        }

        $this->doParse($this->getDocComment());

        $this->cached['doc'] = true;
    }

    protected function doParse($docComment)
    {
        if($docComment){
            $docComment = trim(str_replace(['/**', '*/', '*', '$'], '', $docComment));
            $docCommentLines = explode(PHP_EOL, $docComment);

            foreach ($docCommentLines as $docCommentLine) {
                $this->parseLine(trim($docCommentLine));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function parseLine(string $docCommentLine)
    {
        if ('' === $docCommentLine
            || ('@' === $docCommentLine[0] && strlen($docCommentLine) < 2)
        ) {//If blank separator line or only '@' symbol.
            return;
        }

        preg_match('/^@([a-z]+)\s/', $docCommentLine, $matchs);

        if (sizeof($matchs) > 1) {
            $tagName = $matchs[1];
            switch ($tagName) {
                case 'var':
                    $tag = new Tag\Var_;
                    $setters = ['setType', 'setName'];
                    $tokens = preg_split('/[\s]+/', $docCommentLine, 3);
                    array_shift($tokens);
                    foreach ($tokens as $i => $token) {
                        $tag->{$setters[$i]}($token);
                    }
                    $this->allTags[] = $tag;
                    break;
                case 'param':
                    $tag = new Tag\Param;
                    $setters = ['setType', 'setName', 'setDescription'];
                    $tokens = preg_split('/[\s]+/', $docCommentLine, 4);
                    array_shift($tokens);
                    foreach ($tokens as $i => $token) {
                        $tag->{$setters[$i]}($token);
                    }
                    $this->allTags[] = $tag;
                    break;
                case 'return':
                    $tag = new Tag\Return_;
                    $setters = ['setType', 'setDescription'];
                    $tokens = preg_split('/[\s]+/', $docCommentLine, 3);
                    array_shift($tokens);
                    foreach ($tokens as $i => $token) {
                        $tag->{$setters[$i]}($token);
                    }
                    $this->allTags[] = $tag;
                    break;
                case 'throws':
                    $tag = new Tag\Throws;
                    $setters = ['setClass', 'setDescription'];
                    $tokens = preg_split('/[\s]+/', $docCommentLine, 3);
                    array_shift($tokens);
                    foreach ($tokens as $i => $token) {
                        $tag->{$setters[$i]}($token);
                    }
                    $this->allTags[] = $tag;
                    break;
                default:
                    $tag = new Tag($tagName);
                    $fieldsNumbersByTags = isset($this->fieldsNumbersByTags[$tagName]) ?
                        $this->fieldsNumbersByTags[$tagName]:
                        1;

                    $tokens = preg_split('/[\s]+/', $docCommentLine, $fieldsNumbersByTags);
                    $tokensSize = sizeof($tokens);
                    for ($i = 1; $i < $tokensSize; $i++) {
                        $tag->addField($tokens[$i]);
                    }
                    $this->allTags[] = $tag;
                    $this->allCustomTags[] = $tag;
                    break;
            }

            $this->addTag($tagName, $tag);
        }
    }

    abstract protected function getDocComment() : string;
}
