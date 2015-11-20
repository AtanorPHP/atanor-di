<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Edge\DependencyEdge;
use Atanor\Di\Graph\Node\InstanceNode;
use Atanor\Graph\Graph\AbstractGraph;
use Atanor\Di\Graph\Edge\PropertyEdge;

class DefaultDependencyGraph extends AbstractGraph implements DependencyGraph
{
    /**
     * @inheritDoc
     */
    public function addInstanceNode(InstanceNode $node):DependencyGraph
    {
        return $this->addNode($node);
    }

    /**
     * @inheritDoc
     */
    public function addDependency(DependencyEdge $edge):DependencyGraph
    {
        return $this->addEdge($edge);
    }


    /**
     * @inheritDoc
     */
    public function getDependencies(InstanceNode $node):array
    {
        $dependencies = [];
        foreach($this->edges as $edge) {
            if ($edge->getTail() !== $node) continue;
            $dependencies[] = $edge;
        }
        return $dependencies;
    }

    /**
     * @inheritDoc
     */
    public function addPropertyDependency(string $nodeId, string $nodeId2, string $propertyName,string $edgeClass):DependencyGraph
    {
        if ( ! $this->containsNodeId($nodeId)) {
            //@todo throw exception
        }
        if ( ! $this->containsNodeId($nodeId2)) {
            //@todo throw exception
        }
        $node1 = $this->getNode($nodeId);
        $node2 = $this->getNode($nodeId2);
        try {
            $dependencyEdge = new $edgeClass($node1,$node2,$propertyName);
        } catch (\Exception $e) {
            //@todo
        }
        $this->addDependency($dependencyEdge);
        return $this;
    }
}