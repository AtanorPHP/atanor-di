<?php
declare(strict_types=1);
namespace Atanor\Di\Container\ServiceLocator;

use Atanor\Di\Graph\DependencyGraphAware;
use Atanor\Di\ObjectBuilding\Construction\ConstructorAware;
use Atanor\Di\ObjectBuilding\Injection\InjectorAware;

interface ServiceLocator extends ConstructorAware,InjectorAware,DependencyGraphAware
{
    /**
     * Returns registered service
     * @param string $name
     * @return mixed
     */
    public function getRegisteredService(string $name);

    /**
     * Returns service info
     * @param string $name
     * @return ServiceInfo
     */
    public function getRegisteredServiceInfo(string $name):ServiceInfo;

    /**
     * Returns true if service is registered
     * @param string $name
     * @return bool
     */
    public function hasRegisteredService(string $name):bool;
}
