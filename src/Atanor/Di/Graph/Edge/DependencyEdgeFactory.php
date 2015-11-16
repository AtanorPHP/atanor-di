<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Edge;

use Atanor\Graph\Edge\MutableEdge;
use Atanor\Di\Configuration\Graph\DependencyEdgeFactoryConfiguration as edgeConfig;

class DependencyEdgeFactory
{
    /**
     * Build dependency edge
     * @param array|\ArrayAccess $config
     * @param mixed $end1
     * @param mixed $end2
     * @return DependencyEdge
     */
    public function buildEdge($config,$end1,$end2):DependencyEdge
    {
        $edgeClass = $config[edgeConfig::OPTION_EDGE_CLASS];
        $edge = new $edgeClass($end1,$end2);
        if ($edge instanceof MutableEdge) {
            $edge->setOptions($config);
        }
        return $edge;
    }
}