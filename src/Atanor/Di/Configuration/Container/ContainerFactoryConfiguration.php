<?php
declare(strict_types = 1);
namespace Atanor\Di\Configuration\Container;

use Atanor\Configuration\Graph\AbstractConfigurationNode;
use Atanor\Configuration\Graph\ConfigurationNode;

class ContainerFactoryConfiguration extends AbstractConfigurationNode
{
    const OPTION_CONTAINER_CLASS = 'containerClass';
    const OPTION_GRAPH_FACTORY_CLASS = 'graphFactory';
    const OPTION_NODE_FACTORY_CLASS = 'nodeFactory';
    const OPTION_EDGE_FACTORY_CLASS = 'edgeFactory';
    const OPTION_GRAPH_CONFIGURATION = 'graphConfiguration';

    /**
     * @param string $containerClass
     * @return ContainerFactoryConfiguration
     */
    public function setContainerClass(string $containerClass):ContainerFactoryConfiguration
    {
        $this->data[static::OPTION_CONTAINER_CLASS] = $containerClass;
        return $this;
    }

    /**
     * Set dependency grpah factory class
     * @param string $graphFactoryClass
     * @return ContainerFactoryConfiguration
     */
    public function setGraphFactoryClass(string $graphFactoryClass):ContainerFactoryConfiguration
    {
        $this->data[static::OPTION_GRAPH_FACTORY_CLASS] = $graphFactoryClass;
        return $this;
    }

    /**
     * Set instance node factory class
     * @param string $nodeFactoryClass
     * @return ContainerFactoryConfiguration
     */
    public function setNodeFactoryClass(string $nodeFactoryClass):ContainerFactoryConfiguration
    {
        $this->data[static::OPTION_NODE_FACTORY_CLASS] = $nodeFactoryClass;
        return $this;
    }

    /**
     * Set dependency edge factory class
     * @param string $edgeFactoryClass
     * @return ContainerFactoryConfiguration
     */
    public function setEdgeFactoryClass(string $edgeFactoryClass):ContainerFactoryConfiguration
    {
        $this->data[static::OPTION_EDGE_FACTORY_CLASS] = $edgeFactoryClass;
        return $this;
    }

    /**
     * Set dependency graph configuration
     * @param ConfigurationNode $graphConfiguration
     * @return ContainerFactoryConfiguration
     */
    public function setGraphConfiguration(ConfigurationNode $graphConfiguration):ConfigurationNode
    {
        $this->data[static::OPTION_GRAPH_CONFIGURATION] = $graphConfiguration;
        $graphConfiguration->setParent($this);
        return $graphConfiguration;
    }

}
