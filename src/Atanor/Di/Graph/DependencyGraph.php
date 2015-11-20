<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Edge\DependencyEdge;
use Atanor\Di\Graph\Node\InstanceNode;

interface DependencyGraph
{
    /**
     * Add instance node
     * @param InstanceNode $node
     * @return DependencyGraph
     */
    public function addInstanceNode(InstanceNode $node):DependencyGraph;

    /**
     * Add a dependency adge
     * @param DependencyEdge $edge
     * @return DependencyGraph
     */
    public function addDependency(DependencyEdge $edge):DependencyGraph;

    /**
     * @param string $nodeId
     * @param string $nodeId2
     * @param string $propertyName
     * @param string $edgeClass
     * @return DependencyGraph
     */
    public function addPropertyDependency(string $nodeId,string $nodeId2,string $propertyName,string $edgeClass):DependencyGraph;

    /**
     * Get all dependencies
     * @param InstanceNode $node
     * @return mixed
     */
    public function getDependencies(InstanceNode $node):array;
}