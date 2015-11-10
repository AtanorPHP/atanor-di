<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\InstanceGraph;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Injection\Injector;

class AbstractContainer
{
    /**
     * @var InstanceGraph
     */
    protected $instanceGraph;

    /**
     * Constructor
     * @var Constructor
     */
    protected $constructor;

    /**
     * Injector
     * @var Injector
     */
    protected $injector;

    /**
     * Set instanceGraph
     * @param InstanceGraph $instanceGraph
     * @return Container
     */
    public function setInstanceGraph($instanceGraph):Container
    {
        $this->instanceGraph = $instanceGraph;
        return $this;
    }

    /**
     * @param Constructor $constructor
     * @return Container
     */
    public function setConstructor(Constructor $constructor):Container
    {
        $this->constructor = $constructor;
        return $this;
    }
}