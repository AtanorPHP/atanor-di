<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph;

interface DependencyGraphAware
{
    /**
     * Set dependency graph
     * @param DependencyGraph $graph
     * @return null
     */
    public function setDependencyGraph(DependencyGraph $graph);
}
