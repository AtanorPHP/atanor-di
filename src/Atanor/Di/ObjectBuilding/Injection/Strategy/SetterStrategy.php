<?php
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\Exception\DependencyNotInjectable;
use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;

class SetterStrategy implements InjectionStrategy
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
    }

    /**
     * @inheritdoc
     */
    public function canInject(&$instance,Dependency $dependency):bool
    {
        if ( ! $dependency instanceof PropertyDependency) return false;
        $propertyName = $dependency->getPropertyName();
        $setterName = $this->getSetterName($instance,$propertyName);
        if (empty($setterName)) return false;
        return true;
    }

    /**
     * @inheritdoc
     */
    public function inject(&$instance,Dependency $dependency)
    {
        if ( ! $this->canInject($instance,$dependency)) {
            throw new DependencyNotInjectable();
        }
        $propertyName = $dependency->getPropertyName();
        $setterName = $this->getSetterName($instance,$propertyName);
        try {
            $instance->$setterName($dependency->getValue());
        } catch (\Exception $e) {
            throw new DependencyNotInjectable();
        }
    }

    /**
     * Get candidate setter name
     * @param mixed     $instance
     * @param string    $propertyName
     * @return string
     */
    protected function getSetterName($instance,string $propertyName):string
    {
        $setterName = 'set' . ucfirst($propertyName);
        if ( ! method_exists($instance,$setterName)) return '';
        return $setterName;
    }
}
