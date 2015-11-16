<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\ServiceLocator;

use Atanor\Di\Container\AbstractContainerFactory;
use Atanor\Di\Container\Container;
use Atanor\Di\Graph\DependencyGraphAware;
use Atanor\Di\ObjectBuilding\Construction\BasicConstructor;
use Atanor\Di\ObjectBuilding\Injection\MinimalInjector;
use Atanor\Di\Configuration\Container\ContainerFactoryConfiguration as containerConfig;

class ServiceLocatorFactory extends AbstractContainerFactory
{
    /**
     * @inheritDoc
     */
    protected function initContainer($config):Container
    {
        $containerClass = $config[containerConfig::OPTION_CONTAINER_CLASS];
        $container = new $containerClass();
        if ( ! $container instanceof ServiceLocator) {
            throw new \Exception("This factory can build ServiceLocator only");
        }
        /** @var $container ServiceLocator */
        $container->setConstructor(new BasicConstructor());
        $container->setInjector(new MinimalInjector());
        return $container;
    }

    /**
     * @inheritDoc
     */
    protected function configureContainer(Container &$container, $config):Container
    {
        /** @var $container ServiceLocator */
        $this->setDependencyGraph($container,$config);
        $constructor = $container->getRegisteredService('constructor');
        $container->setConstructor($constructor);
        $injector = $container->getRegisteredService('injector');
        $container->setInjector($injector);
        return $container;
    }

    /**
     * Set dependency graph
     * @param array|\ArrayAccess $config
     * @param DependencyGraphAware $container
     */
    protected function setDependencyGraph(DependencyGraphAware $container,$config)
    {
        $graphConfig = $config[containerConfig::OPTION_GRAPH_CONFIGURATION];
        $dependencyGraph = $this->dependencyGraphFactory->buildDependencyGraph($graphConfig);
        $container->setDependencyGraph($dependencyGraph);
    }
}