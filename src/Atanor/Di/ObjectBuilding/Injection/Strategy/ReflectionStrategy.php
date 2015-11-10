<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\ObjectBuilding\Injection\InjectionStrategy;

class ReflectionStrategy implements InjectionStrategy
{
    /**
     * @inheritDoc
     */
    public function canInject($instance, $dependency, string $propertyName = null):bool
    {
        $reflectionClass = new \ReflectionClass($instance);
        try{
            $property = $reflectionClass->getProperty($propertyName);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function inject(&$instance, $dependency, string $propertyName = null):string
    {
        $reflectionClass = new \ReflectionClass($instance);
        $property = $reflectionClass->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($instance,$dependency);
        return $propertyName;
    }

}