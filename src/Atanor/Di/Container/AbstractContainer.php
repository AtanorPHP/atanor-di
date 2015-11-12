<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DependencyGraphAware;
use Atanor\Di\Graph\DependencyGraph;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Construction\ConstructorAware;
use Atanor\Di\ObjectBuilding\Injection\Injector;
use Atanor\Di\ObjectBuilding\Injection\InjectorAware;
use Atanor\Di\Graph\Node\InstanceNode;
use Atanor\Di\Graph\Edge\DependencyEdge;
use Atanor\Di\Graph\Edge\ConstructorParamEdge;
use Atanor\Di\Graph\Edge\PropertyEdge;

class AbstractContainer implements Container
{
    /**
     * @var DependencyGraph
     */
    protected $dependencyGraph;

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
     * @inheritdoc
     */
    public function setDependencyGraph(DependencyGraph $dependencyGraph)
    {
        $this->dependencyGraph = $dependencyGraph;
    }

    /**
     * @inheritdoc
     */
    public function setConstructor(Constructor $constructor)
    {
        $this->constructor = $constructor;
    }

    /**
     * @inheritdoc
     */
    public function setInjector(Injector $injector)
    {
        $this->injector = $injector;
    }

    /**
     * @inheritDoc
     */
    public function build(InstanceNode $node)
    {
        if ($node->isInstantiated()) return $node->getInstance();
        $className = $node->getTypeHint();
        $constructorParams = [];
        $dependencies = [];
        foreach($this->dependencyGraph->getDependencies($node) as $depEdge) {
            /** @var  DependencyEdge $depEdge */
            $dependencyNode = $depEdge->getHead();
            if ($depEdge instanceof ConstructorParamEdge) {
                $constructorParams[$depEdge->getPosition()] = $this->build($dependencyNode);
            }
            if ($depEdge instanceof PropertyEdge) {
                $propertyName = $depEdge->getPropertyName();
                if ( ! isset($dependencies[$propertyName])) {
                    $dependencies[$propertyName] = [];
                }
                $dependencies[$propertyName][] = $this->build($dependencyNode);
            }
            else $dependencies[] = $this->build($dependencyNode);
        }
        $instance = $this->constructor->construct($className,$constructorParams);
        if (count($dependencies) > 0) $this->injector->inject($instance,$dependencies);
        $node->setInstance($instance);
        return $instance;
    }
}