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
use Atanor\Di\ObjectBuilding\Construction\BasicConstructor;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Injection\DefaultInjector;
use Atanor\Di\ObjectBuilding\Injection\Injector;

class DefaultServiceLocator extends AbstractContainer implements ServiceLocator
{
    /**
     * DefaultServiceLocator constructor.
     */
    public function __construct()
    {
        $this->constructor = new BasicConstructor();
        $this->injector = new DefaultInjector();
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