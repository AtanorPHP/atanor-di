<?php
declare(strict_types = 1);
namespace Atanor\Di\Configuration\Graph;

use Atanor\Di\Graph\Node\InstanceNodeFactory;
use Atanor\Configuration\Graph\AbstractConfigurationNode;

class InstanceNodeFactoryConfiguration extends AbstractConfigurationNode
{
    const OPTION_NODE_CLASS = 'nodeClass';
    const OPTION_NODE_OPTIONS = 'options';
    const OPTION_NODE_DEPENDENCIES = 'dependencies';
    const OPTION_NODE_DEPENDENCY_NODE_CONFIG = 'node';
    const OPTION_NODE_EDGE_CONFIG = 'edge';
    const OPTION_NODE_CONSTRUCTOR_PARAMS = 'constructorParams';
    const OPTION_INSTANCE_TYPE_HINT = 'typeHint';

    /**
     * Set instance node class
     * @param string $nodeClass
     * @return InstanceNodeFactory
     */
    public function setNodeClass(string $nodeClass):InstanceNodeFactoryConfiguration
    {
        $this->data[static::OPTION_NODE_CLASS] = $nodeClass;
        return $this;
    }

    /**
     * Set instance node options
     * @param $options
     * @return InstanceNodeFactoryConfiguration
     */
    public function setOptions($options):InstanceNodeFactoryConfiguration
    {
        $this->data[static::OPTION_NODE_OPTIONS] = $options;
        return $this;
    }

    /**
     * Set instance type hint
     * @param string $typeHint
     * @return InstanceNodeFactoryConfiguration
     */
    public function setTypeHint(string $typeHint):InstanceNodeFactoryConfiguration
    {
        $this->data[static::OPTION_NODE_OPTIONS][static::OPTION_INSTANCE_TYPE_HINT]=$typeHint;
        return $this;
    }

    /**
     * Add dependency configuration
     * @param DependencyFactoryConfiguration $dependencyConfig
     * @return DependencyFactoryConfiguration
     */
    public function addDependency(DependencyFactoryConfiguration $dependencyConfig):DependencyFactoryConfiguration
    {
        $this->data[static::OPTION_NODE_DEPENDENCIES][] = $dependencyConfig;
        $dependencyConfig->setParent($this);
        return $dependencyConfig;
    }

}