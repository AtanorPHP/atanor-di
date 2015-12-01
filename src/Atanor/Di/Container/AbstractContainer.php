<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DefaultAvatarGraph;
use Atanor\Di\Graph\AvatarGraph;
use Atanor\Di\Graph\Avatar\ValueAvatar;
use Atanor\Di\ObjectBuilding\Construction\BootableConstructor;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Construction\ReflectionConstructor;
use Atanor\Di\ObjectBuilding\Injection\BootableInjector;
use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;
use Atanor\Di\ObjectBuilding\Injection\Injector;
use Atanor\Di\Graph\Avatar\Avatar;
use Atanor\Di\Graph\Bond\Bond;
use Atanor\Di\Graph\Bond\ConstructorBond;
use Atanor\Di\Graph\Bond\PropertyBond;

class AbstractContainer implements Container,MutableContainer,BootableContainer
{
    /**
     * @var AvatarGraph
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
    protected $isBooted = false;

    /**
     * AbstractContainer constructor.
     */
    public function __construct()
    {
        $this->dependencyGraph = new DefaultAvatarGraph();
        $this->constructor = new ReflectionConstructor();
    }

    /**
     * @inheritdoc
     */
    public function isBooted():bool
    {
        return $this->isBooted;
    }

    /**
     * @inheritdoc
     */
    public function boot():BootableContainer
    {
        $this->bootConstructor();
        $this->bootInjector();
        $this->isBooted = true;
        return $this;
    }

    /**
     * Boot constructor
     * @return Container
     */
    protected function bootConstructor():Container
    {
        $constructorNode = $this->dependencyGraph->getNode('constructor');
        $constructorClass = $constructorNode->getTypeHint();
        $this->constructor = new $constructorClass();
        if ($this->constructor instanceof BootableConstructor) {
            $dependencies = $this->dependencyGraph->getDependencyObjects($constructorNode,[$this,'instantiationCallbackForBoot']);
            $this->constructor->boot($dependencies);
        }
        return $this;
    }

    /**
     * Method used to instantiate a
     * @param Avatar $node
     * @return mixed
     */
    public function instantiationCallbackForBoot(Avatar $node)
    {
        if ($node instanceof ValueAvatar) return $node->getInstance();
        else  {
            if ($this->dependencyGraph->hasDependencies($node)) {
                //Throw exception : cannot use injector dependency having dependencies.
            }
            $dependencyClass = $node->getTypeHint();
            return new $dependencyClass();
        }
    }

    /**
     * Boot injector
     * @return Container
     */
    protected function bootInjector():Container
    {
        $injectorNode = $this->dependencyGraph->getNode('injector');
        $injectorClass = $injectorNode->getTypeHint();
        $this->injector = new $injectorClass();
        if ($this->injector instanceof BootableInjector) {
            $dependencies = $this->dependencyGraph->getDependencyObjects($injectorNode,[$this,'instantiationCallbackForBoot']);
            $this->injector->boot($dependencies);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(Avatar $node)
    {
        if ( ! $this->isBooted) {
            //trhow exception
        }
        if ($node->isMaterialized()) return $node->getObject();
        $className = $node->getTypeHint();
        $constructorParams = [];
        $dependencies = [];
        //@todo use dependencyGraph::getDependencyObjects($node)...
        foreach($this->dependencyGraph->getDependencies($node) as $depEdge) {
            /** @var  Bond $depEdge */
            $dependencyNode = $depEdge->getHead();
            $instance = $this->build($dependencyNode);
            if ($depEdge instanceof ConstructorBond) {
                $constructorParams[$depEdge->getPosition()] = $instance;
                continue;
            }
            if ($depEdge instanceof PropertyBond) {
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
        $node->setObject($instance);
        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function setConstructor(Constructor $constructor):MutableContainer
    {
        $this->constructor = $constructor;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setInjector(Injector $injector):MutableContainer
    {
        $this->injector = $injector;
        return $this;
    }


}