<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Edge;

use Atanor\Graph\Edge\MutableEdge;

class DependencyEdgeFactory
{
    const OPTION_EDGE_CLASS = 'edgeClass';

    public function buildEdge($config,$end1,$end2):DependencyEdge
    {
        $edgeClass = $config[static::OPTION_EDGE_CLASS];
        $edge = new $edgeClass($end1,$end2);
        if ($edge instanceof MutableEdge) {
            $edge->setOptions($config);
        }
        return $edge;
    }
}