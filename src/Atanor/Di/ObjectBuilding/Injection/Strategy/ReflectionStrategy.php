<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;
use Atanor\Di\Exception\DependencyNotInjectable;

class ReflectionStrategy implements InjectionStrategy
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function canInject(&$instance,Dependency $dependency):bool
    {
        if ( ! $dependency instanceof PropertyDependency) return false;
        $reflectionClass = new \ReflectionClass($instance);
        $propertyName = $dependency->getPropertyName();
        try{
            $reflectionClass->getProperty($propertyName);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function inject(&$instance,Dependency $dependency)
    {
        if ( ! $this->canInject($instance,$dependency)) {
            throw new DependencyNotInjectable();
        }
        $propertyName = $dependency->getPropertyName();
        $reflectionClass = new \ReflectionClass($instance);
        $property = $reflectionClass->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($instance,$dependency->getValue());
    }

}