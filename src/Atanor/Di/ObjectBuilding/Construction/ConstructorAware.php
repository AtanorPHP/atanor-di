<?php
declare(strict_types = 1);

namespace Atanor\Di\ObjectBuilding\Construction;

interface ConstructorAware
{
    /**
     * Set constructor
     * @param Constructor $constructor
     * @return null
     */
    public function setConstructor(Constructor $constructor);
}