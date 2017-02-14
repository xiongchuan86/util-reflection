<?php declare(strict_types=1);

namespace Kassko\Util\Reflection;

class Tag
{
    /** @var string */
    private $name;
    /** @var array */
    private $fields = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getTagName() : string
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

    public function getFields() : array
    {
        return $this->fields;
    }

    public function getFieldsCount() : integer
    {
        return count($this->fields);
    }

    public function addField(string $field) : self
    {
        $this->fields[] = $field;

        return $this;
    }

    public function addNamedField(string $fieldName, $fieldValue) : self
    {
        $this->fields[$fieldName] = $fieldValue;

        return $this;
    }

    public function __toString() : string
    {
        return $this->name;
    }
}
