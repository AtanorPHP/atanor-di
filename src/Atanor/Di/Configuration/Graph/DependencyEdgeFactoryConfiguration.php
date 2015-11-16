<?php
declare(strict_types = 1);
namespace Atanor\Di\Configuration\Graph;

use Atanor\Configuration\Graph\AbstractConfigurationNode;

class DependencyEdgeFactoryConfiguration extends AbstractConfigurationNode
{
    const OPTION_EDGE_CLASS = 'edgeClass';

    /**
     * Set dependnecy edge class
     * @param string $edgeClass
     * @return DependencyEdgeFactoryConfiguration
     */
    public function setEdgeClass(string $edgeClass):DependencyEdgeFactoryConfiguration
    {
        $this->data[static::OPTION_EDGE_CLASS] = $edgeClass;
        return $this;
    }
}
