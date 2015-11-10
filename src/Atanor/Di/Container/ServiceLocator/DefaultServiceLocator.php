<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\ServiceLocator;

use Atanor\Di\Container\AbstractContainer;
use Atanor\Di\Container\Container;
use Atanor\Di\Graph\DependencyGraph;
use Atanor\Di\Graph\Edge\ConstructorParamEdge;
use Atanor\Di\Graph\Edge\DependencyEdge;
use Atanor\Di\Graph\Edge\PropertyEdge;
use Atanor\Di\Graph\Node\Feature\Service;
use Atanor\Di\Graph\Node\InstanceNode;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Injection\Injector;

class DefaultServiceLocator extends AbstractContainer implements Container,ServiceLocator
{
    /**
     * @var DependencyGraph
     */
    protected $dependencyGraph;

    /**
     * @var Constructor
     */
    protected $constructor;

    /**
     * @var Injector
     */
    protected $injector;

    /**
     * Set constructor
     * @param Constructor $constructor
     * @return Container|DefaultServiceLocator
     */
    public function setConstructor(Constructor $constructor):DefaultServiceLocator
    {
        $this->constructor = $constructor;
        return $this;
    }

    /**
     * Set dependency grapg
     * @param DependencyGraph $dependencyGraph
     * @return DefaultServiceLocator
     */
    public function setDependencyGraph(DependencyGraph $dependencyGraph):DefaultServiceLocator
    {
        $this->dependencyGraph = $dependencyGraph;
        return $this;
    }

    /**
     * Set injector
     * @param Injector $injector
     * @return DefaultServiceLocator
     */
    public function setInjector($injector):DefaultServiceLocator
    {
        $this->injector = $injector;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(InstanceNode $node)
    {
        if ($node->isInstantiated()) return $node->getInstance();
        if ( ! $node instanceof Service) {
            throw new \Exception("Service locator is supposed to build Service instance");
        }
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
                $dependencies[$depEdge->getPropertyName()] = $this->build($dependencyNode);
            }
            else $dependencies[] = $this->build($dependencyNode);

        }
        $instance = $this->constructor->construct($className,$constructorParams);
        $this->injector->inject($instance,$dependencies);
        $node->setInstance($instance);
    }

    /**
     * @inheritDoc
     */
    public function getRegisteredService(string $name)
    {
        if ( ! $this->hasRegisteredService($name)) {
            throw new \Exception("No registered service named $name");
        }
        /** @var InstanceNode $dependencyNode */
        $dependencyNode = $this->dependencyGraph->getNode($name);
        if ($dependencyNode->isInstantiated()) return $dependencyNode->getInstance();
        else return $this->build($dependencyNode);
    }

    /**
     * @inheritDoc
     */
    public function getRegisteredServiceInfo(string $name):ServiceInfo
    {
        // TODO: Implement getRegisteredServiceInfo() method.
    }

    /**
     * @inheritDoc
     */
    public function hasRegisteredService(string $name):bool
    {
        return $this->dependencyGraph->hasService($name);
    }
}