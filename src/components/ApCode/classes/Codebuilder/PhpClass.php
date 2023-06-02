<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpClass extends PhpInterface
{
    protected $abstract = null;

    protected $implementations = [];

    protected $traits = [];

    protected $properties = [];

    protected $propertyGroups = [];

    public function setAbstract($bool)
    {
        $this->abstract = $bool;
        return $this;
    }

    public function isAbstract()
    {
        return (bool) $this->abstract;
    }

    public function hasImplementations()
    {
        return count($this->implementations) > 0;
    }

    public function getImplementations()
    {
        return $this->implementations;
    }

    public function addImplementation(PhpInterface $interface)
    {
        $this->implementations[] = $interface;
        return $this;
    }

    public function addTrait($trait)
    {
        if (!in_array($trait, $this->traits)) {
            $this->traits[] = $trait;
        }

        return $this;
    }

    public function getTraits()
    {
        return $this->traits;
    }

    public function hasTraits()
    {
        return boolval($this->traits);
    }

    public function hasProperties()
    {
        return count($this->properties) > 0;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function createProperty($name)
    {
        $property = new PhpClassProperty($name);
        $this->properties[] = $property;

        return $property;
    }

    public function hasPropertyGroups()
    {
        return count($this->propertyGroups) > 0;
    }

    public function getPropertyGroups()
    {
        return $this->propertyGroups;
    }

    public function createGroupOfProperties()
    {
        $group = new PhpGroupOfProperties();
        $this->propertyGroups[] = $group;

        return $group;
    }
}
