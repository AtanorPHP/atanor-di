<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Dependency;

interface PropertyDependency extends Dependency
{
    /**
     * @return string
     */
    public function getPropertyName():string;

    /**
     * @return string
     */
    public function setPropertyName(string $name):PropertyDependency;
}