<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DefaultDependencyGraph;
use Atanor\Di\Graph\DependencyGraph;
use Atanor\Di\Graph\Node\ValueNode;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Construction\ReflectionConstructor;
use Atanor\Di\ObjectBuilding\Injection\BootableInjector;
use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;
use Atanor\Di\ObjectBuilding\Injection\Injector;
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
     * True if container has been initiated
     * @var bool
     */
    protected $isInitiated = false;

    /**
     * @var string
     */
    protected $defaultPropertyEdgeClass = PropertyEdge::class;

    /**
     * AbstractContainer constructor.
     */
    public function __construct()
    {
        $this->dependencyGraph = new DefaultDependencyGraph();
        $this->constructor = new ReflectionConstructor();
    }


    public function init()
    {
        $this->bootInjector();
        //$this->bootConstructor();
        $this->isInitiated = true;
    }

    protected function bootConstructor()
    {
        $constructorNode = $this->dependencyGraph->getNode('constructor');
        $constructorClass = $constructorNode->getTypeHint();
        $this->constructor = new $constructorClass();
    }

    /**
     * Boot injector.
     * Will consider any dependencies of injector if they have no other dependencies and
     * are constructed with no parameter
     * @return $this
     */
    protected function bootInjector()
    {
        $injectorNode = $this->dependencyGraph->getNode('injector');
        $injectorClass = $injectorNode->getTypeHint();
        $this->injector = new $injectorClass();
        if ($this->injector instanceof BootableInjector) {
            $dependencies = [];
            foreach($this->dependencyGraph->getDependencies($injectorNode) as $edge) {
                if ($edge instanceof ConstructorParamEdge) continue;
                $dependencyNode = $edge->getHead();
                if ($dependencyNode instanceof ValueNode) {
                    $value = $dependencyNode->getInstance();
                }
                $instanceClass = $dependencyNode->getTypeHint();
                try {
                    $value = new $instanceClass();
                } catch (\Exception $e) {
                    continue;
                    //@todo : throw execption
                }
                if ($edge instanceof PropertyEdge) {
                    $propertyName = $edge->getPropertyName();
                    $dependency = new PropertyDependency($propertyName,$value);
                }
                else {
                    $dependency = new Dependency($value);
                }
                $dependencies[] = $dependency;
            }
            $this->injector->boot($dependencies);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(InstanceNode $node)
    {
        if ( ! $this->isInitiated) {
            //trhow exception
        }
        if ($node->isInstantiated()) return $node->getInstance();
        $className = $node->getTypeHint();
        $constructorParams = [];
        $dependencies = [];
        foreach($this->dependencyGraph->getDependencies($node) as $depEdge) {
            /** @var  DependencyEdge $depEdge */
            $dependencyNode = $depEdge->getHead();
            $instance = $this->build($dependencyNode);
            if ($depEdge instanceof ConstructorParamEdge) {
                $constructorParams[$depEdge->getPosition()] = $instance;
                continue;
            }
            if ($depEdge instanceof PropertyEdge) {
                $propertyName = $depEdge->getPropertyName();
                $dependency = new PropertyDependency($propertyName,$instance);
            }
            else {
                $dependency = new Dependency($instance);

            }
            $dependencies[] = $dependency;
        }
        $instance = $this->constructor->construct($className,$constructorParams);
        if (count($dependencies) > 0) $this->injector->inject($instance,$dependencies);
        $node->setInstance($instance);
        return $instance;
    }
}