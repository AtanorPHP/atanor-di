<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Dependency;

class PropertyDependency extends  Dependency
{

    /**
     * Property name
     * @var string
     */
    protected $propertyName;

    /**
     * PropertyDependency constructor.
     * @param string $propertyName
     * @param mixed $value
     */
    public function __construct(string $propertyName, $value)
    {
        $this->propertyName = $propertyName;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getPropertyName():string
    {
        return $this->propertyName;
    }
}