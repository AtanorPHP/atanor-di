<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Construction;

class BasicConstructor implements Constructor
{
    /**
     * BasicConstructor constructor.
     */
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function construct(string $className, $options = null)
    {
        return new $className;
    }

    /**
     * @inheritDoc
     */
    public function canConstruct(string $className, $options = null):bool
    {
        if ($options !== null) return false;
        return true;
    }



}
