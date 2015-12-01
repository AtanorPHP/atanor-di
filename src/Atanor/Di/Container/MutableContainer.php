<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Injection\Injector;

interface MutableContainer
{
    /**
     * Set constructor
     * @param Constructor $constructor
     * @return MutableContainer
     */
    public function setConstructor(Constructor $constructor):MutableContainer;

    /**
     * Set injector
     * @param Injector $injector
     * @return MutableContainer
     */
    public function setInjector(Injector $injector):MutableContainer;
}