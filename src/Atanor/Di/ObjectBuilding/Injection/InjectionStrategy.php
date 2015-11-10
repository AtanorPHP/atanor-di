<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Injection;

interface InjectionStrategy
{
    /**
     * @param mixed     $instance
     * @param mixed     $dependency
     * @param string    $propertyName
     * @return bool
     */
    public function canInject($instance, $dependency,string $propertyName = null):bool;

    /**
     * @param mixed     $instance
     * @param mixed     $dependency
     * @param string    $propertyName
     * @return string   returns injected property name
     */
    public function inject(&$instance, $dependency,string $propertyName = null):string;
}
