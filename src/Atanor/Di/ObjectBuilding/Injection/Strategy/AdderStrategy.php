<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\ObjectBuilding\Injection\InjectionStrategy;

class AdderStrategy implements InjectionStrategy
{
    /**
     * @inheritDoc
     */
    public function canInject($instance, $dependency, string $propertyName = null):bool
    {
        $adderName = $this->getAdderName($instance,$propertyName);
        if (empty($adderName)) return false;
        return true;
    }

    /**
     * @inheritDoc
     */
    public function inject(&$instance, $dependency, string $propertyName = null):string
    {
        $adderName = $this->getAdderName($instance,$propertyName);
        $instance->$adderName($dependency);
        return $propertyName;
    }

    protected function getAdderName($instance,$propertyName)
    {
        $adderName = 'addTo' . ucfirst($propertyName);
        if ( ! method_exists($instance,$adderName)) return '';
        return $adderName;
    }

}