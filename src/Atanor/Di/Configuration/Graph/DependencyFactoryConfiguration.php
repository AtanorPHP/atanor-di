<?php
declare(strict_types = 1);
namespace Atanor\Di\Configuration\Graph;

use Atanor\Configuration\Graph\AbstractConfigurationNode;

class DependencyFactoryConfiguration extends AbstractConfigurationNode
{
    const OPTION_EDGE_CONFIG = 'edge';
    const OPTION_NODE_CONFIG = 'node';

    /**
     * Set dependency edge configuration
     * @param DependencyEdgeFactoryConfiguration $edgeConfig
     * @return DependencyFactoryConfiguration
     */
    public function setEdgeConfig(DependencyEdgeFactoryConfiguration $edgeConfig):DependencyEdgeFactoryConfiguration
    {
        $this->data[static::OPTION_EDGE_CONFIG] = $edgeConfig;
        $edgeConfig->setParent($this);
        return $edgeConfig;
    }

    /**
     * Set instance node configuration
     * @param InstanceNodeFactoryConfiguration $nodeConfig
     * @return InstanceNodeFactoryConfiguration
     */
    public function setNodeConfig(InstanceNodeFactoryConfiguration $nodeConfig):InstanceNodeFactoryConfiguration
    {
        $this->data[static::OPTION_NODE_CONFIG] = $nodeConfig;
        $nodeConfig->setParent($this);
        return $nodeConfig;
    }
}