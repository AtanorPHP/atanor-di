<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Container\ServiceLocator\ServiceLocator;
use Atanor\Di\Graph\DefaultDependencyGraph;
use Atanor\Di\Graph\DependencyGraph;
use Atanor\Di\Graph\DependencyGraphAware;
use Atanor\Di\Graph\DependencyGraphFactory;
use Atanor\Di\Graph\Edge\DependencyEdgeFactory;
use Atanor\Di\Graph\Node\InstanceNodeFactory;
use Atanor\Di\ObjectBuilding\Construction\BasicConstructor;
use Atanor\Di\ObjectBuilding\Construction\ConstructorAware;
use Atanor\Di\ObjectBuilding\Injection\DefaultInjector;

abstract class AbstractContainerFactory
{
    const OPTION_CONTAINER_CLASS = 'containerClass';
    const OPTION_DEPENDENCY_GRAPH_FACTORY_CLASS = 'dependencyGraphFactory';
    const OPTION_INSTANCE_NODE_FACTORY_CLASS = 'instanceNodeFactory';
    const OPTION_DEPENDENCY_GRAPH = 'dependencyGraph';
    const OPTION_DEPENDENCY_EDGE_FACTORY_CLASS = 'dependencyEdgeFactory';
    const OPTION_CONSTRUCTOR_SERVICE_NAME = 'constructor';

    /**
     * @var DependencyGraphFactory
     */
    protected $dependencyGraphFactory;


    /**
     * set dependnecy graph factory
     * @param DependencyGraphFactory $dependencyGraphFactory
     */
    public function setDependencyGraphFactory(DependencyGraphFactory $dependencyGraphFactory)
    {
        $this->dependencyGraphFactory = $dependencyGraphFactory;
    }

    /**
     * Build container
     * @param array|\ArrayAccess $config
     * @return Container
     */
    public function buildContainer($config):Container
    {
        $this->setFactories($config);
        $container = $this->initContainer($config);
        $this->configureContainer($container,$config);
        return $container;
    }

    /**
     * Initiate container
     * Instantiate and inject what is necessary by default.
     * @param array|\ArrayAccess $config
     * @return Container
     */
    abstract protected function initContainer($config):Container;

    /**
     * Configure container
     * @param Container $container
     * @param array|\ArrayAccess $config
     * @return Container
     */
    abstract protected function configureContainer(Container &$container,$config):Container;

    /**
     * Set required factories
     * @param array|\ArrayAccess $config
     */
    protected function setFactories($config)
    {
        $graphFactoryClass = $config[static::OPTION_DEPENDENCY_GRAPH_FACTORY_CLASS];
        /** @var DependencyGraphFactory $graphFactory */
        $graphFactory = new $graphFactoryClass();
        $instanceNodeFactoryClass = $config[static::OPTION_INSTANCE_NODE_FACTORY_CLASS];
        /** @var InstanceNodeFactory $instanceNodeFactory */
        $graphFactory->setInstanceNodeFactory(new $instanceNodeFactoryClass());
        $dependencyEdgeFactoryClass = $config[static::OPTION_DEPENDENCY_EDGE_FACTORY_CLASS];
        $graphFactory->setDependencyEdgeFactory(new $dependencyEdgeFactoryClass());
        $this->setDependencyGraphFactory($graphFactory);
    }
}
