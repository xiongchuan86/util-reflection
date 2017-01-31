<?php

namespace Kassko\Util\ReflectionTest;

use Kassko\Util\Reflection\ReflectorRepository;

class ReflectorRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $reflectorRepo;

    public function setUp()
    {
        $this->reflectorRepo = new ReflectorRepository;
    }

    /**
     * @test
     */
    public function reflClass()
    {
        $class = new Class {

            private $name;
            private $addresses;

            public function getName()
            {
                return $this->name;
            }

            public function setName($name)
            {
                $this->name = $name;
            }

            public function getAddresses()
            {
                return $this->addresses;
            }

            public function getAddressesItem($key)
            {
                return $this->addresses[$key];
            }

            public function setAddresses(array $addresses)
            {
                $this->addresses = $addresses;
            }

            public function addAddressesItem(int $key, string $address)
            {
                $this->addresses[$key] = $address;
            }

            public function pushAddressesItem(string $address)
            {
                $this->addresses[] = $address;
            }
        };

        //$reflClass = $this->reflectorRepo->advReflClass($class);
        //var_dump($reflClass->getMethodsNames());


        $accessorFinder = $this->reflectorRepo->accessorFinder($class);

        $this->assertEquals('getName', $accessorFinder->findPropGetter('name'));
        $this->assertEquals('setName', $accessorFinder->findPropSetter('name'));

        $this->assertEquals('getAddresses', $accessorFinder->findPropGetter('addresses'));
        $this->assertEquals('getAddressesItem', $accessorFinder->findPropItemGetter('addresses'));
        $this->assertEquals('setAddresses', $accessorFinder->findPropSetter('addresses'));
        $this->assertEquals('pushAddressesItem', $accessorFinder->findPropAdder('addresses'));
        $this->assertEquals('addAddressesItem', $accessorFinder->findPropAssocAdder('addresses'));
    }
}
