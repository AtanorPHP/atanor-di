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
    //public function getService(string $name);

    /**
     * Returns true if service is registered
     * @param string $name
     * @return bool
     */
    //public function hasService(string $name):bool;

    /**
     * @param string $name
     * @param string $className
     * @param string|null $serviceNodeClass
     * @return ServiceLocator
     */
    //public function registerService(string $name, string $className):ServiceLocator;

}
