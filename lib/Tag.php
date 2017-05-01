<?php

namespace Kassko\Util\Reflection;

class Tag
{
    /** @var string */
    private $name;
    /** @var array */
    private $fields = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getTagName()
    {
        return $this->name;
    }

    public function getField($fieldKey)
    {
        if (!isset($this->fields[$fieldKey])) {
            return null;
        }

        return $this->fields[$fieldKey];
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getFieldsCount()
    {
        return count($this->fields);
    }

    public function addField($field)
    {
        $this->fields[] = $field;

        return $this;
    }

    public function addNamedField($fieldName, $fieldValue)
    {
        $this->fields[$fieldName] = $fieldValue;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
