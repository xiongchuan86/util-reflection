<?php

namespace Kassko\Util\ReflectionTest\Fixtures;

class ClassA
{
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

    public function addAddressesItem($key, $address)
    {
        $this->addresses[$key] = $address;
    }

    public function pushAddressesItem($address)
    {
        $this->addresses[] = $address;
    }
}
