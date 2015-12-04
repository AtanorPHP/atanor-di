<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DiGraph;
use Atanor\Di\Graph\Ghost\Feature\GhostGraph;

abstract class AbstractContainer extends AbstractMaterializer implements Container
{
    /**
     * Digraph
     * @var DiGraph
     */
    protected $diGraph;

    /**
     * @inheritDoc
     */
    public function setDiGraph(DiGraph $graph):Container
    {
        $this->diGraph = $graph;
        return $this;
    }

    /**
     * @param string $ghostId
     * @return mixed|null
     */
    protected function getInstance(string $ghostId)
    {
        $ghost = $this->diGraph->getNode($ghostId);
        if ($ghost instanceof GhostGraph) {
            if ($ghost->getDiGraph() !== $this->diGraph) {
                //Throw exception
            }
        }
        return $this->materialize($ghost);
    }

    /**
     * @inheritDoc
     */
    public function getDiGraph():DiGraph
    {
        return $this->diGraph;
    }


}
