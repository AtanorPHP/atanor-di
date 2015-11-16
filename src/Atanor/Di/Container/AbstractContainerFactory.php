<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DependencyGraphFactory;
use Atanor\Di\Graph\Node\InstanceNodeFactory;
use Atanor\Di\Configuration\Container\ContainerFactoryConfiguration as containerConfig;

abstract class AbstractContainerFactory
{
    /**
     * @var DependencyGraphFactory
     */
    protected $dependencyGraphFactory;

    /**
     * set dependnecy graph factory
     * @param DependencyGraphFactory $dependencyGraphFactory
     */
    public function setDependencyGraphFactory(DependencyGraphFactory $dependencyGraphFactory):AbstractContainerFactory
    {
        $this->dependencyGraphFactory = $dependencyGraphFactory;
        return $this;
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
        $graphFactoryClass = $config[containerConfig::OPTION_GRAPH_FACTORY_CLASS];
        /** @var DependencyGraphFactory $graphFactory */
        $graphFactory = new $graphFactoryClass();
        $instanceNodeFactoryClass = $config[containerConfig::OPTION_NODE_FACTORY_CLASS];
        $graphFactory->setInstanceNodeFactory(new $instanceNodeFactoryClass());
        $dependencyEdgeFactoryClass = $config[containerConfig::OPTION_EDGE_FACTORY_CLASS];
        $graphFactory->setDependencyEdgeFactory(new $dependencyEdgeFactoryClass());
        $this->setDependencyGraphFactory($graphFactory);
    }
}
