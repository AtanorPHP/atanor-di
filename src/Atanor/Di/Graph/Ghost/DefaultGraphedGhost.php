<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

use Atanor\Di\Graph\DefaultDiGraph;
use Atanor\Di\Graph\Ghost\Feature\DiGraphAware;
use Atanor\Di\Graph\DiGraph;
use Atanor\Graph\Graph\Graph;
use Atanor\Graph\Node\GraphAware;

class DefaultGraphedGhost extends DefaultGhost implements Ghost,DiGraphAware
{
    /**
     * @var DiGraph
     */
    protected $diGraph;

    /**
     * @inheritDoc
     */
    public function getGraph():Graph
    {
        if ( ! $this->diGraph) {
            $this->diGraph = new DefaultDiGraph();
        }
        return $this->diGraph;
    }

    /**
     * @inheritDoc
     */
    public function setGraph(Graph $graph):GraphAware
    {
        $this->diGraph = $graph;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasInjectableDependencies():bool
    {
        return $this->getGraph()->hasInjectableDependencies($this);
    }

    /**
     * @inheritDoc
     */
    public function hasConstructorDependencies():bool
    {
        return $this->getGraph()->hasConstructorDependencies($this);
    }

    /**
     * @inheritDoc
     */
    public function getInjectableDependencies($invocationCallback):array
    {
        return $this->getGraph()->getInjectableDependencies($this,$invocationCallback);
    }

    /**
     * @inheritDoc
     */
    public function getConstructorDependencies($invocationCallback):array
    {
        return $this->getGraph()->getConstructorDependencies($this,$invocationCallback);
    }

    /**
     * @inheritDoc
     */
    public function addProperty(string $property,$value):DiGraphAware
    {
        $this->getGraph()->addPropertyDependency($this,$value,$property);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addPropertyGhost(string $property, string $objectType, array $params = []):Ghost
    {
        $params['objectType'] = $objectType;
        $ghost = DefaultGraphedGhost::build($params);
        $this->addProperty($property,$ghost);
        return $ghost;
    }


    /**
     * @inheritDoc
     */
    public function addConstructorParameter(int $position,$value):DiGraphAware
    {
        $this->getGraph()->addConstructorDependency($this,$value,$position);
        return $this;
    }

}