<?php
declare(strict_types=1);
namespace Atanor\Di\Container\ServiceLocator;

interface ServiceLocator
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

    /**
     * @param string $name
     * @param string $typeHint
     * @param string|null $serviceNodeClass
     * @return ServiceLocator
     */
    public function registerService(string $name,string $typeHint,string $serviceNodeClass = null):ServiceLocator;

    /**
     * Add property dependency edge between two services
     * @param string $serviceName
     * @param string $dependencyServiceName
     * @param string $property
     * @param string|null $edgeClass
     * @return ServiceLocator
     */
    public function addServicePropertyDependency(string $serviceName,string $dependencyServiceName,string $property,string $edgeClass = null):ServiceLocator;

}
