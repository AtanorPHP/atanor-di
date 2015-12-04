<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DiGraph;

interface Container extends Materializer
{
    /**
     * Set Di graph
     * @param DiGraph $graph
     * @return Container
     */
    public function setDiGraph(DiGraph $graph):Container;

    /**
     * Return di graph
     * @return DiGraph
     */
    public function getDiGraph():DiGraph;
}