<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection;

interface BootableInjector
{
    /**
     * Boot injector using a list of Dependencies
     * @param array|\Traversable $dependencies
     * @return BootableInjector
     */
    public function boot($dependencies):BootableInjector;
}