<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Construction;

class LittleConstructor implements Constructor
{
    /**
     * LittleConstructor constructor.
     */
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function construct(string $className, $options = null)
    {
        $paramCount = max(array_keys($options));
        switch($paramCount) {
            case 0 : return new $className($options[0]);
            case 1 : return new $className($options[0],$options[1]);
            case 2 : return new $className($options[0],$options[1],$options[2]);
            case 3 : return new $className($options[0],$options[1],$options[2],$options[3]);
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function canConstruct(string $className, $options = null):bool
    {
        if ($options === null) return false;
        $paramCount = max(array_keys($options));
        if ($paramCount >= 4) return false;
        return true;
    }



}
