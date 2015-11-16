<?php
declare(strict_types = 1);
namespace Atanor\Di\Configuration\Graph;

use Atanor\Configuration\Graph\AbstractConfigurationNode;
use Atanor\Di\Configuration\Graph\InstanceNodeFactoryConfiguration;

class DependencyGraphFactoryConfiguration extends AbstractConfigurationNode
{
    const OPTION_GRAPH_CLASS = 'graphClass';
    const OPTION_NODES = 'nodes';

    /**
     * Set dependency graph class
     * @param string $graphClass
     * @return DependencyGraphFactoryConfiguration
     */
    public function setGraphClass(string $graphClass):DependencyGraphFactoryConfiguration
    {
        $this->data[static::OPTION_GRAPH_CLASS] = $graphClass;
        return $this;
    }

    /**
     * Add an instance node configuration
     * @param InstanceNodeFactoryConfiguration $nodeConfig
     * @return DependencyGraphFactoryConfiguration
     */
    public function addNodeConfiguration(InstanceNodeFactoryConfiguration $nodeConfig):InstanceNodeFactoryConfiguration
    {
        $this->data[static::OPTION_NODES][] = $nodeConfig;
        $nodeConfig->setParent($this);
        return $nodeConfig;
    }


}