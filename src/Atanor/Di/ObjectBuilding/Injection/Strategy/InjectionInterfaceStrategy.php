<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\Exception\DependencyNotInjectable;

class InjectionInterfaceStrategy implements InjectionStrategy
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
        foreach($this->getDependencyInterfaces($dependency->getValue()) as $interface) {
            $injectionInterfaceName = $interface . 'Aware';
            if (is_subclass_of($dependency->getValue(),$injectionInterfaceName)) return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function inject(&$instance,Dependency $dependency)
    {
        if ( ! $this->canInject($instance,$dependency)) {
            throw new DependencyNotInjectable();
        }
        foreach($this->getDependencyInterfaces($dependency) as $interface) {
            $injectionInterfaceName = $interface . 'Aware';
            if ( ! is_subclass_of($instance,$injectionInterfaceName)) continue;
            $setterName = 'set' . $interface;
            if ( ! method_exists($instance,$setterName)) {
                throw new DependencyNotInjectable("$setterName does not exists.");
            }
            $instance->$setterName($dependency->getValue());
        }
        throw new DependencyNotInjectable();
    }

    /**
     * Returns a list of interfaces implemented by instance
     * @param $instance
     * @return array
     */
    protected function getDependencyInterfaces($instance):array
    {
        $interfaces = class_implements($instance);
        array_push($interfaces,get_class($instance));
        $interfaces += class_parents($instance);
        return $interfaces;
    }

}