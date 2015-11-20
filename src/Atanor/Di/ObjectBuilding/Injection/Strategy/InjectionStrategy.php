<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Injection\Strategy;

use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;

interface InjectionStrategy
{
    /**
     * @param $instance
     * @param Dependency $dependency
     * @return bool|bool
     */
    public function canInject(&$instance, Dependency $dependency):bool;


    /**
     * @param $instance
     * @param Dependency $dependency
     * @return mixed
     */
    public function inject(&$instance, Dependency $dependency);

    /**
     * InjectionStrategy constructor.
     */
    public function __construct();
}
