<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Dependency;

interface Dependency
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param $value
     * @return Dependency
     */
    public function setValue($value):Dependency;
}