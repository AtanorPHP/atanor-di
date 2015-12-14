<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\DiGraph;
use Atanor\Di\Graph\Link\ConstructorLink;
use Atanor\Di\Graph\Link\Link;
use Atanor\Graph\RootedGraph;
use Atanor\Di\Graph\Link\PropertyLink;

interface GhostGraph extends DiGraph,RootedGraph
{
    /**
     * Set di graph
     * @param DiGraph $graph
     * @return GhostGraph
     */
    public function setDiGraph(DiGraph $graph):GhostGraph;

    /**
     * Get Di graph
     * @return DiGraph
     */
    public function getDiGraph():DiGraph;

    /**
     * @param GhostGraph $dependency
     * @param Link $link
     * @return GhostGraph
     */
    public function addDependency(GhostGraph $dependency,Link $link):GhostGraph;
}