<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Core\Exception\ApiException;
use Atanor\Di\Graph\DefaultDiGraph;
use Atanor\Di\Graph\DiGraph;
use Atanor\Di\Graph\Ghost\DefaultGhost;
use Atanor\Di\Graph\Ghost\DefaultGraphedGhost;
use Atanor\Di\Graph\Ghost\Feature\DiGraphAware;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Construction\ReflectionConstructor;
use Atanor\Di\ObjectBuilding\Injection\DefaultInjector;
use Atanor\Di\ObjectBuilding\Injection\Injector;
use Atanor\Di\ObjectBuilding\Injection\Strategy\AdderStrategy;
use Atanor\Di\ObjectBuilding\Injection\Strategy\ReflectionStrategy;

class DefaultContainer extends AbstractWizard implements Container
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
     * @return Injector
     */
    public function getInjector():Injector
    {
        if ( ! $this->injector) {
            if ($this->has('injector')) {
                $this->injector = $this->get('injector');
            }
            else {
                $this->injector = new DefaultInjector();
                $this->injector->addToInjectionStrategies(new AdderStrategy());
                $this->injector->addToInjectionStrategies(new ReflectionStrategy());
            }
        }
        return $this->injector;
    }

    /**
     * @inheritDoc
     */
    public function getConstructor():Constructor
    {
        if ( ! $this->constructor) {
            $this->constructor = new ReflectionConstructor();
        }
        return $this->constructor;
    }


    /**
     * @inheritDoc
     */
    public function getDiGraph():DiGraph
    {
        if ( ! $this->diGraph) {
            $this->diGraph = new DefaultDiGraph();
        }
        return $this->diGraph;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        $node = $this->getDiGraph()->getNodeById($id);
        if ( ! $node instanceof Ghost) return $node;
        return $this->invoke($node);
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return $this->getDiGraph()->hasNodeWithId($id);
    }

    /**
     * @inheritDoc
     */
    public function getGhost($id):Ghost
    {
        $node = $this->getDiGraph()->getNodeById($id);
        if ( ! $node instanceof Ghost) {
            throw new ApiException("Trying to reach a node that is not a Ghost");
        }
        return $node;
    }

    /**
     * @inheritDoc
     */
    public function addItem($item, string $id = null)
    {
        $this->getDiGraph()->addNode($item,$id);
        return $item;
    }

    /**
     * @inheritDoc
     */
    public function addGhost(string $objectType, string $ghostClass = null, array $params = null, string $id = null):Ghost
    {
        if ( ! $ghostClass) $ghostClass = DefaultGraphedGhost::class;
        if ( ! $params) $params = [];
        $params = array_replace($params,['objectType' => $objectType]);
        $ghost = $ghostClass::build($params);
        $this->addItem($ghost,$id);
        return $ghost;
    }
}
