<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\Exception\DependencyNotInjectable;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;

class AdderStrategy implements InjectionStrategy
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function canInject(&$instance, Dependency $dependency):bool
    {
        if ( ! $dependency instanceof PropertyDependency) return false;
        $adderName = $this->getAdderName($instance,$dependency->getPropertyName());
        if (empty($adderName)) return false;
        return true;
    }

    /**
     * @inheritDoc
     */
    public function inject(&$instance, Dependency $dependency)
    {
        if ( ! $this->canInject($instance,$dependency)) {
            throw new DependencyNotInjectable();
        }
        $adderName = $this->getAdderName($instance,$dependency->getPropertyName());
        $instance->$adderName($dependency->getValue());
    }

    /**
     * Returns potential adder method name
     * @param $instance
     * @param $propertyName
     * @return string
     */
    protected function getAdderName($instance,$propertyName)
    {
        $adderName = 'addTo' . ucfirst($propertyName);
        if ( ! method_exists($instance,$adderName)) return '';
        return $adderName;
    }

}