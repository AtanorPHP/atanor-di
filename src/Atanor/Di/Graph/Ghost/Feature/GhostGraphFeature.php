<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\DiGraph;
use Atanor\Di\Graph\Ghost\AbstractFeature;
use Atanor\Di\Graph\Ghost\Feature;
use Atanor\Graph\Graph\Graph;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Di\Graph\Link\Link;
use Atanor\Graph\RootedGraph;

class GhostGraphFeature extends AbstractFeature implements GhostGraph
{
    /**
     * @var DiGraph
     */
    protected $diGraph;

    /**
     * @inheritDoc
     */
    public function getNode($nodeId)
    {
        return $this->diGraph->getNode($nodeId);
    }

    /**
     * @inheritDoc
     */
    public function addNode($node, string $nodeId = null):Graph
    {
        return $this->diGraph->addNode($node,$nodeId);
    }

    /**
     * @inheritDoc
     */
    public function removeNodeById($nodeId):Graph
    {
        return $this->diGraph->removeNodeById($nodeId);
    }

    /**
     * @inheritDoc
     */
    public function removeNode($node):Graph
    {
        return $this->removeNode($node);
    }

    /**
     * @inheritDoc
     */
    public function contains($node):bool
    {
        return $this->diGraph->containsNodeId($node);
    }

    /**
     * @inheritDoc
     */
    public function containsNodeId(string $nodeId):bool
    {
        return $this->diGraph->containsNodeId($nodeId);
    }

    /**
     * @inheritDoc
     */
    public function addGhost(Ghost $ghost):DiGraph
    {
        return $this->diGraph->addGhost($ghost);
    }

    /**
     * @inheritDoc
     */
    public function addLink(Link $link):DiGraph
    {
        return $this->diGraph->addLink($link);
    }

    /**
     * @inheritDoc
     */
    public function getDependencyLinks(Ghost $ghost):array
    {
        return $this->diGraph->getDependencyLinks($ghost);
    }

    /**
     * @inheritDoc
     */
    public function hasDependencyLinks(Ghost $ghost):bool
    {
        return $this->diGraph->hasDependencyLinks($ghost);
    }

    /**
     * @inheritDoc
     */
    public function getDependencyObjects(Ghost $ghost, $materializationCallback):array
    {
        return $this->diGraph->getDependencyObjects($ghost,$materializationCallback);
    }

    /**
     * @inheritDoc
     */
    public function getConstructorParams(Ghost $ghost, $materializationCallback):array
    {
        return $this->diGraph->getConstructorParams($ghost,$materializationCallback);
    }

    /**
     * @inheritDoc
     */
    public function getRoot()
    {
        return $this->ghost;
    }

    /**
     * @inheritDoc
     */
    public function setRoot(&$node):RootedGraph
    {
        return $this;
    }

    /**
     * @param DiGraph $diGraph
     */
    public function setDiGraph(DiGraph $diGraph):Ghost
    {
        $this->diGraph = $diGraph;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDiGraph():DiGraph
    {
        return $this->diGraph;
    }

    /**
     * @inheritdoc
     */
    public function addDependency(GhostGraph $dependency,Link $link):GhostGraph
    {
        if ( ! $this->contains($dependency)) {
           $this->addNode($dependency);
        }
        $this->addLink($link);
        return $this;
    }
    /**
     * @inheritDoc
     */
    public static function build(Ghost $ghost, array $params):Feature
    {
        $feature = new self($ghost);
        if (isset($params['dependencies'])) {
            foreach($params['dependencies'] as $dependency) {
                $ghostClass = $dependency['ghostClassName'];
                $ghostDep = $ghostClass::build($dependency);
                if ( ! $feature->contains($ghostDep)) {
                    $feature->addNode($ghostDep);
                }
                $linkClass = $dependency['linkClassName'];
                $link = $linkClass::build($ghost,$ghostDep,$dependency);
                $feature->addLink($link);
            }
        }
        return $feature;
    }
}