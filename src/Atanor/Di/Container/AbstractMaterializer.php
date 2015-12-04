<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Injection\Injector;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Di\Graph\Ghost\Feature\GhostGraph;

abstract class AbstractMaterializer implements Materializer
{
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
     * @inheritDoc
     */
    public function materialize(Ghost $ghost)
    {
        if ($ghost->isMaterialized()) return $ghost->getObject();
        if ( ! $ghost instanceof GhostGraph) {
            //@throw execption !!
        }
        $className = $ghost->getObjectType();
        $dependencies = $ghost->getDependencyObjects($ghost,[$this,'materialize']);
        $constructorParams = $ghost->getConstructorParams($ghost,[$this,'materialize']);
        $instance = $this->constructor->construct($className,$constructorParams);
        if (count($dependencies) > 0) $this->injector->inject($instance,$dependencies);
        $ghost->setObject($instance);
        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function setConstructor(Constructor $constructor):Materializer
    {
        $this->constructor = $constructor;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setInjector(Injector $injector):Materializer
    {
        $this->injector = $injector;
        return $this;
    }
}