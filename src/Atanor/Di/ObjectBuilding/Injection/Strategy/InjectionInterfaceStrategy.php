<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\ObjectBuilding\Injection\InjectionStrategy;

class InjectionInterfaceStrategy implements InjectionStrategy
{
    /**
     * @inheritDoc
     */
    public function canInject($instance, $dependency,string $propertyName = null):bool
    {
        foreach($this->getDependencyInterfaces($dependency) as $interface) {
            $injectionInterfaceName = $interface . 'Aware';
            if (is_subclass_of($instance,$injectionInterfaceName)) return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function inject(&$instance, $dependency,string $propertyName = null):string
    {
        foreach($this->getDependencyInterfaces($dependency) as $interface) {
            $injectionInterfaceName = $interface . 'Aware';
            if ( ! is_subclass_of($instance,$injectionInterfaceName)) continue;
            $setterName = 'set' . $interface;
            if ( ! method_exists($instance,$setterName)) {
                throw new \Exception("$setterName is not implemented");
            }
            $instance->$setterName($dependency);
            return ''; //@todo...
        }
        throw new \Exception("No suitable injection interface implemented");
    }

    protected function getDependencyInterfaces($dependency):array
    {
        $interfaces = class_implements($dependency);
        array_push($interfaces,get_class($dependency));
        $interfaces += class_parents($dependency);
        return $interfaces;
    }

}