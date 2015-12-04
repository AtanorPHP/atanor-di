<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Construction;

class ReflectionConstructor implements Constructor
{
    /**
     * ReflectionConstructor constructor.
     */
    public function __construct()
    {
    }

    /**
     * @inheritdoc
     */
    public function canConstruct(string $className, $options = null):bool
    {
        if ($options === null) return false;
        return true;
    }

    /**
     * @inheritdoc
     */
    public function construct(string $className,$options = null)
    {
        $reflection = new \ReflectionClass($className);
        return $reflection->newInstanceArgs($options);
    }



}
