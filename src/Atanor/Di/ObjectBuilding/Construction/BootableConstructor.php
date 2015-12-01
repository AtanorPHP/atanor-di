<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Construction;

interface BootableConstructor
{
    /**
     * @param $dependencies
     * @return BootableConstructor
     */
    public function boot($dependencies):BootableConstructor;
}