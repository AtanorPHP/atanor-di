<?php
declare(strict_types = 1);
namespace Atanor\Di\ObjectBuilding\Injection\Dependency;

class Dependency
{
    /**
     * Instance
     * @var mixed
     */
    protected $value;

    /**
     * Dependency constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function &getValue()
    {
        return $this->value;
    }
}