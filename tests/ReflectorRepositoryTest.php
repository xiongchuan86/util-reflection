<?php

namespace Kassko\Util\ReflectionTest;

use Kassko\Util\Reflection;
use Kassko\Util\ReflectionTest\Fixtures;

class ReflectorRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function reflClass()
    {
        $class = new Fixtures\ClassA;

        $accessorFinder = new Reflection\AccessorFinder(
            new Reflection\ReflectionClass(
                new \ReflectionClass($class),
                new Reflection\PhpElementsParser
            )
        );

        $this->assertEquals('getName', $accessorFinder->findPropGetter('name'));
        $this->assertEquals('setName', $accessorFinder->findPropSetter('name'));

        $this->assertEquals('getAddresses', $accessorFinder->findPropGetter('addresses'));
        $this->assertEquals('getAddressesItem', $accessorFinder->findPropItemGetter('addresses'));
        $this->assertEquals('setAddresses', $accessorFinder->findPropSetter('addresses'));
        $this->assertEquals('pushAddressesItem', $accessorFinder->findPropAdder('addresses'));
        $this->assertEquals('addAddressesItem', $accessorFinder->findPropAssocAdder('addresses'));
    }
}
