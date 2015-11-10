<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Edge\DependencyEdge;
use Atanor\Graph\Graph\Graph;
use Atanor\Di\Graph\Node\InstanceNode;

interface DependencyGraph extends Graph
{
    /**
     * Add instance node
     * @param InstanceNode $node
     * @return DependencyGraph
     */
    public function addInstanceNode(InstanceNode $node):DependencyGraph;

    /**
     * Add dependency
     * @param DependencyEdge $dependencyEdge
     * @return DependencyGraph
     */
    public function addDependency(DependencyEdge $dependencyEdge):DependencyGraph;

    /**
     * Get all dependencies
     * @param InstanceNode $node
     * @return mixed
     */
    public function getDependencies(InstanceNode $node):array;

    /**
     * @param string $name
     * @return bool
     */
    public function hasService(string $name):bool;


}