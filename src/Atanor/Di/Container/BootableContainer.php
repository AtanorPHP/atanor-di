<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

interface BootableContainer
{
    /**
     * Boot container
     * @return BootableContainer
     */
    public function boot():BootableContainer;

    /**
     * Returns true if container is booted
     * @return bool
     */
    public function isBooted():bool;
}
