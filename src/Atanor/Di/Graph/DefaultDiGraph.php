<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Ghost\Feature\GhostGraph;
use Atanor\Di\Graph\Link\ConstructorLink;
use Atanor\Di\Graph\Link\Link;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Graph\Graph\AbstractGraph;
use Atanor\Di\Graph\Link\PropertyLink;
use Atanor\Di\Graph\Ghost\ValueGhost;
use Atanor\Di\ObjectBuilding\Injection\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;

class DefaultDiGraph extends AbstractGraph implements DiGraph
{
    /**
     * @var Ghost
     */
    protected $rootGhost;

    /**
     * @inheritDoc
     */
    public function addGhost(Ghost $ghost):DiGraph
    {
        if ($ghost instanceof GhostGraph) {
            $ghost->setDiGraph($this);
        }
        return $this->addNode($ghost);
    }

    /**
     * @inheritDoc
     */
    public function addLink(Link $link):DiGraph
    {
        return $this->addEdge($link);
    }

    /**
     * @inheritDoc
     */
    public function getDependencyLinks(Ghost $ghost):array
    {
        $dependencies = [];
        foreach($this->edges as $edge) {
            if ($edge->getTail() !== $ghost) continue;
            $dependencies[] = $edge;
        }
        return $dependencies;
    }

    /**
     * @inheritDoc
     */
    public function hasDependencyLinks(Ghost $ghost):bool
    {
        $dependencyEdge = $this->getDependencyLinks($ghost);
        if (count($dependencyEdge) == 0) return false;
        return true;
    }


    /**
     * @inheritdoc
     */
    public function getDependencyObjects(Ghost $ghost, $materializationCallback):array
    {
        $dependencyObjects = [];
        foreach($this->getDependencyLinks($ghost) as $edge) {
            $dependencyNode = $edge->getHead();
            if ($dependencyNode instanceof ValueGhost) {
                $value = $dependencyNode->getObject();
            }
            else {
                $value = call_user_func_array($materializationCallback,[$dependencyNode]);
            }
            if ($edge instanceof PropertyLink) {
                $propertyName = $edge->getProperty();
                $dependency = new PropertyDependency($propertyName,$value);
            }
            else {
                $dependency = new Dependency($value);
            }
            $dependencyObjects[] = $dependency;
        }
        return $dependencyObjects;
    }

    /**
     * @inheritDoc
     */
    public function getConstructorParams(Ghost $ghost, $materializationCallback):array
    {
        $constructorParams = [];
        foreach($this->getDependencyLinks($ghost) as $edge) {
            if ( ! $edge instanceof ConstructorLink) continue;
            $dependencyNode = $edge->getHead();
            if ($dependencyNode instanceof ValueGhost) {
                $value = $dependencyNode->getObject();
            }
            else {
                $value = call_user_func_array($materializationCallback,[$dependencyNode]);
            }
            $position = $edge->getPosition();
            $constructorParams[$position] = $value;
        }
        return $constructorParams;
    }
}