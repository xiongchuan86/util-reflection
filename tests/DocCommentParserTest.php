<?php

namespace Kassko\Util\ReflectionTest;

use Kassko\Util\MemberAccessor\ObjectMemberAccessor;
use Kassko\Util\Reflection\DocCommentParser;

class DocCommentParserTest extends \PHPUnit_Framework_TestCase
{
    private $docCommentParser;
    private $memberAccessor;

    public function setUp()
    {
        $this->docCommentParser = new DocCommentParser\Scope\Method(
            $this->getMockBuilder('ReflectionMethod')->disableOriginalConstructor()->getMock()
        );
        $this->docCommentParser->setFieldsNumbersByTags(['mytag' => 2]);

        $this->memberAccessor = new ObjectMemberAccessor;
    }

    /** @tests */
    public function getParsedTagsFromDocComment()
    {
        $this->memberAccessor->executeMethod(
            $this->docCommentParser,
            'doParse', [
            <<<'DOC'
            /**
             * @param string   $name  My name
             * @param int   $age
             *
             * @throws \Exception My exception
             *
             * @mytag My description
             */
DOC
            ]
        );

        $tags = $this->memberAccessor->executeMethod($this->docCommentParser, 'getAllTags');

        $this->assertCount(4, $tags);

        $this->assertInstanceOf('Kassko\Util\Reflection\Tag\Param', $tags[0]);
        $this->assertEquals('param', $tags[0]->getTagName());
        $this->assertEquals('string', $tags[0]->getType());
        $this->assertEquals('name', $tags[0]->getName());
        $this->assertEquals('My name', $tags[0]->getDescription());

        $this->assertInstanceOf('Kassko\Util\Reflection\Tag\Param', $tags[1]);
        $this->assertEquals('param', $tags[1]->getTagName());
        $this->assertEquals('int', $tags[1]->getType());
        $this->assertEquals('age', $tags[1]->getName());
        $this->assertNull($tags[1]->getDescription());

        $this->assertInstanceOf('Kassko\Util\Reflection\Tag\Throws', $tags[2]);
        $this->assertEquals('throws', $tags[2]->getTagName());
        $this->assertEquals('\Exception', $tags[2]->getClass());
        $this->assertEquals('My exception', $tags[2]->getDescription());

        $this->assertInstanceOf('Kassko\Util\Reflection\Tag', $tags[3]);
        $this->assertEquals('mytag', $tags[3]->getTagName());
        $this->assertEquals('My description', $tags[3]->getField(0));

        $tags = $this->memberAccessor->executeMethod($this->docCommentParser, 'getAllCustomTags');

        $this->assertCount(1, $tags);
        $this->assertInstanceOf('Kassko\Util\Reflection\Tag', $tags[0]);
        $this->assertEquals('mytag', $tags[0]->getTagName());
        $this->assertEquals('My description', $tags[0]->getField(0));
    }
}
