<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Edge\ConstructorParamEdge;
use Atanor\Di\Graph\Edge\DependencyEdge;
use Atanor\Di\Graph\Node\Feature\NodeIdProvider;
use Atanor\Di\Graph\Node\Feature\Service;
use Atanor\Di\Graph\Node\InstanceNode;
use Atanor\Graph\Graph\AbstractGraph;

class DefaultDependencyGraph extends AbstractGraph implements DependencyGraph
{
    /**
     * @inheritDoc
     */
    public function addInstanceNode(InstanceNode $node):DependencyGraph
    {
        $nodeId = $this->getNewNodeId($node);
        $this->addNode($node,$nodeId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addDependency(DependencyEdge $dependencyEdge):DependencyGraph
    {
        $this->addEdge($dependencyEdge);
        return $this;
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
    public function hasService(string $name):bool
    {
        if ( ! $this->containsNodeId($name)) return false;
        $service = $this->getNode($name);
        if ($service instanceof Service) return true;
        return false;
    }


    /**
     * Create a new node Id
     * @param InstanceNode $node
     * @return string
     */
    protected function getNewNodeId(InstanceNode $node)
    {
        if ($node instanceof NodeIdProvider) return $node->getId();
        return $nodeId = spl_object_hash($node);
    }
}