<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\ServiceLocator;

use Atanor\Di\Container\AbstractContainer;
use Atanor\Di\Graph\Bond\PropertyBond;
use Atanor\Di\Graph\Avatar\Feature\IdentityProvider;
use Atanor\Di\Graph\Avatar\Avatar;
use Atanor\Di\Graph\Avatar\DefaultServiceAvatar;

class DefaultServiceLocator extends AbstractContainer implements ServiceLocator
{
    protected $defaultServiceNodeClass = DefaultServiceAvatar::class;
    protected $defaultPropertyEdgeClass = PropertyBond::class;

    /**
     * @inheritDoc
     */
    public function getRegisteredService(string $name)
    {
        if ( ! $this->hasRegisteredService($name)) {
            throw new \Exception("No registered service named $name");
        }
        /** @var Avatar $dependencyNode */
        $dependencyNode = $this->dependencyGraph->getNode($name);
        if ($dependencyNode->isMaterialized()) return $dependencyNode->getObject();
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
        return $this->dependencyGraph->containsNodeId($name);
    }

    /**
     * @inheritDoc
     */
    public function registerService(string $name, string $typeHint, string $serviceNodeClass = null):ServiceLocator
    {
        if ($serviceNodeClass == null) $serviceNodeClass = $this->defaultServiceNodeClass;
        $serviceNode = new $serviceNodeClass($name,$typeHint);
        $this->dependencyGraph->addInstanceNode($serviceNode);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addServicePropertyDependency(string $serviceName,string $dependencyServiceName,string $propertyName,string $edgeClass = null):ServiceLocator
    {
        if ( ! $edgeClass) $edgeClass = $this->defaultPropertyEdgeClass;
        $this->dependencyGraph->addPropertyDependency($serviceName,$dependencyServiceName,$propertyName,$edgeClass);
        return $this;
    }


}