<?php
namespace Atanor\Di\Container\ServiceLocator;

interface ServiceInfo
{
    /**
     * @param $interfaceName
     * @return bool
     */
    public function isInstanceOf($interfaceName);
}
