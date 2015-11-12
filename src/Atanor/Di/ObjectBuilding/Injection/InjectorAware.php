<?php
declare(strict_types = 1);

namespace Atanor\Di\ObjectBuilding\Injection;

interface InjectorAware
{
    /**
     * Inject injector
     * @param Injector $injector
     * @return null
     */
    public function setInjector(Injector $injector);
}


