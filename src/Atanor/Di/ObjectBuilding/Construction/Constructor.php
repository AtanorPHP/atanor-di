<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Construction;

interface Constructor
{
    /**
     * Return instance of class className
     * @param string                                $className
     * @param array|\ArrayAccess|\Traversable|null   $options
     * @return mixed|null
     */
    public function construct(string $className,$options = null);

    /**
     * Returns true if constructor can build instance
     * @param string                                $className
     * @param array|\ArrayAccess|\Traversable|null  $options
     * @return bool
     */
    public function canConstruct(string $className,$options = null):bool;

    /**
     * Force empty constructor
     * Constructor constructor.
     */
    public function __construct();
}
