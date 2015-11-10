<?php
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\ObjectBuilding\Injection\InjectionStrategy;

class SetterStrategy implements InjectionStrategy
{
    /**
     * @inheritdoc
     */
    public function canInject($instance, $dependency,string $propertyName = null):bool
    {
        $setterName = $this->getSetterName($instance,$propertyName);
        if (empty($setterName)) return false;
        return true;
    }

    /**
     * @inheritdoc
     */
    public function inject(&$instance, $dependency,string $propertyName = null):string
    {
        $setterName = $this->getSetterName($instance,$propertyName);
        $instance->$setterName($dependency);
        return $propertyName;
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
